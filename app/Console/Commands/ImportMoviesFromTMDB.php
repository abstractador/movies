<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TMDB\TMDBService;
use App\Models\Movie;
use App\Models\Genre;

class ImportMoviesFromTMDB extends Command
{
    protected $signature = 'tmdb:import
        {--movies : Import ALL movies via discover endpoint}
        {--movies-pages=0 : Import popular movies (number of pages)}
        {--genres : Import ALL genres}
        {--credits : Import cast and crew for movies}
        {--delete-movies : DELETE ALL movies}
        {--delete-genres : DELETE ALL genres}';

    protected $description = 'Import or manage Movies and Genres from TheMovieDB';

    public function handle(TMDBService $tmdb)
    {
        $didSomething = false;

        /* =======================
         * IMPORT MOVIES
         * ======================= */
        if ($this->option('movies')) {
            $this->info('Importing ALL movies from TMDB (discover)…');
            $count = $tmdb->importAllMovies();
            $this->info("Imported/updated {$count} movies.");
            $didSomething = true;
        }

        $pages = (int) $this->option('movies-pages');
        if ($pages > 0) {
            $this->info("Importing popular movies ({$pages} pages) ...");
            $count = $tmdb->importPopularMovies($pages);
            $this->info("Imported/updated {$count} movies.");
            $didSomething = true;
        }

        /* =======================
         * IMPORT GENRES
         * ======================= */
        if ($this->option('genres')) {
            $this->info('Importing ALL genres from TMDB…');
            $count = $tmdb->importGenres();
            $this->info("Imported/updated {$count} genres.");
            $didSomething = true;
        }

        /* =======================
        * IMPORT CREDITS
        * ======================= */
        if ($this->option('credits')) {
            $this->info('Importing movie credits (cast)…');
            $count = $tmdb->importAllCredits();
            $this->info("Imported/updated {$count} cast records.");
            $didSomething = true;
        }

        /* =======================
         * DELETE ACTIONS
         * ======================= */
        if ($this->option('delete-movies')) {
            $this->confirmDanger('movies');
            $count = Movie::count();
            Movie::truncate();
            $this->info("Deleted {$count} movies.");
            $didSomething = true;
        }

        if ($this->option('delete-genres')) {
            $this->confirmDanger('genres');
            $count = Genre::count();
            Genre::truncate();
            $this->info("Deleted {$count} genres.");
            $didSomething = true;
        }

        if (! $didSomething) {
            $this->warn('No action specified.');
            $this->line('Try:');
            $this->line('  --movies-all');
            $this->line('  --movies-pages=5');
            $this->line('  --genres-all');
        }



        return Command::SUCCESS;
    }

    /**
     * Require explicit YES confirmation for destructive actions
     */
    protected function confirmDanger(string $target): void
    {
        $this->warn("You are about to DELETE ALL {$target}.");
        $this->warn('This action CANNOT be undone.');

        if ($this->ask('Type YES to confirm') !== 'YES') {
            $this->info('Aborted.');
            exit(Command::SUCCESS);
        }
    }
}