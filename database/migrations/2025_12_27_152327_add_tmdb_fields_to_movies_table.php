<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {

            // TMDB core fields
            $table->boolean('adult')->default(false);
            $table->string('backdrop_path')->nullable();

            // Store as JSON (PostgreSQL native)
            $table->json('genre_ids')->nullable();

            $table->string('original_language', 10)->nullable();
            $table->string('original_title')->nullable();

            $table->float('popularity')->default(0);

            $table->boolean('video')->default(false);

            // Rename / alias compatibility
            $table->float('vote_average')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn([
                'adult',
                'backdrop_path',
                'genre_ids',
                'original_language',
                'original_title',
                'popularity',
                'video',
                'vote_average',
                'vote_count',
            ]);
        });
    }
};

?>