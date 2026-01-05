<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;
use App\Services\PineconeService;
use App\Services\OpenAIEmbeddingService;
use App\Support\MovieVectorFormatter;

class SyncMoviesToPinecone extends Command
{
    protected $signature = 'ai:sync-movies 
                            {--force : Re-sync only unsynced movies}
                            {--wipe : DELETE ALL Pinecone vectors before syncing}';

    protected $description = 'Sync movies to Pinecone vector database';

    public function handle(
        PineconeService $pinecone,
        OpenAIEmbeddingService $embeddings
    ): int {
        $this->info('Starting Pinecone movie sync...');

        if ($this->option('wipe')) {
            if (! $this->confirm(
                'This will DELETE ALL vectors from Pinecone. Continue?',
                false
            )) {
                $this->warn('Aborted.');
                return self::SUCCESS;
            }

            $this->warn('Deleting ALL Pinecone vectors...');
            $pinecone->deleteAll();

            // Reset local sync markers
            Movie::query()->update([
                'vector_synced_at' => null,
            ]);

            $this->info('Pinecone index wiped & local sync state reset.');

        } else {
            Movie::with('people')
            ->when(!$this->option('force'), fn ($q) =>
                $q->whereNull('vector_synced_at')
            )
            ->chunkById(25, function ($movies) use ($pinecone, $embeddings) {

                $vectors = [];
                $syncedMovies = [];

                foreach ($movies as $movie) {
                    try {
                        $text   = MovieVectorFormatter::toText($movie);
                        $vector = $embeddings->embed($text);

                        $vectors[] = [
                            'id'     => 'movie_' . $movie->id,
                            'values' => $vector,
                            'metadata' => [
                                'movie_id' => $movie->id,
                                'title'    => $movie->title,
                            ],
                        ];

                        $syncedMovies[] = $movie;

                        $this->line("Prepared: {$movie->title}");
                    } catch (\Throwable $e) {
                        $this->error("✖ {$movie->title}: {$e->getMessage()}");
                    }
                }

                if (empty($vectors)) {
                    $this->warn('No vectors prepared for this chunk');
                    return;
                }

                $pinecone->upsert($vectors);

                foreach ($syncedMovies as $movie) {
                    $movie->updateQuietly([
                        'vector_synced_at' => now(),
                    ]);
                }

                $this->info('Chunk synced: ' . count($vectors) . ' movies');
            });

            $this->info('Movie sync complete.');
        }

        

        return self::SUCCESS;
    }
}