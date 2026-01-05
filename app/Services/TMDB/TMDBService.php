<?php

namespace App\Services\TMDB;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Person;
use Illuminate\Support\Facades\Http;

class TMDBService
{
    protected string $apiKey;
    protected string $baseUrl;
    
    public function __construct()
    {
        $this->apiKey = config('services.tmdb.key');
        $this->baseUrl = config('services.tmdb.url');
    }

    /**
     * Fetch popular movies from TMDB API
     * 
     * @param int $page
     * @return array
     */
    public function fetchPopularMovies(int $page = 1): array
    {
        $response = Http::get("{$this->baseUrl}/movie/popular", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'page' => $page,
        ]);
        
        $response->throw();
        
        return $response->json('results', []);
    }
    
    /**
     * Import popular movies into the database
     * 
     * @param int $pages
     * @return int
     */
    public function importPopularMovies(int $pages = 1): int
    {
        $imported = 0;
        
        for ($page = 1; $page <= $pages; $page++) {
            $movies = $this->fetchPopularMovies($page);
            
            foreach ($movies as $movie) {
                Movie::updateOrCreate(
                    ['tmdb_id' => $movie['id']],
                    [
                        'title' => $movie['title'],
                        'original_title' => $movie['original_title'] ?? null,
                        'overview' => $movie['overview'] ?? null,
                        
                        'release_date' => !empty($movie['release_date']) ? $movie['release_date'] : null,
                        
                        'poster_path' => $movie['poster_path'] ?? null,
                        'backdrop_path' => $movie['backdrop_path'] ?? null,
                        
                        'adult' => $movie['adult'] ?? false,
                        'video' => $movie['video'] ?? false,
                        'original_language' => $movie['original_language'] ?? null,
                        'genre_ids' => $movie['genre_ids'] ?? [],
                        
                        'popularity' => $movie['popularity'] ?? 0,
                        'vote_average' => $movie['vote_average'] ?? 0,
                        'vote_count' => $movie['vote_count'] ?? 0,
                    ]
                    );
                
                $imported++;
            }
        }
        
        return $imported;
    }
    
    /**
     * Fetch all movies via discover endpoint
     * 
     * @param int $page
     * @return array
     */
    public function fetchAllMovies(int $page = 1): array
    {
        $response = Http::get("{$this->baseUrl}/discover/movie", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
            'page' => $page,
            'sort_by' => 'popularity.desc',
            'include_adult' => false,
            'include_video' => false,
        ]);
        
        $response->throw();
        
        return $response->json();
    }
    
    /**
     * Import all movies via discover endpoint
     * 
     * @param int $maxPages
     * @return int
     */
    public function importAllMovies(int $maxPages = 100): int
    {
        $imported = 0;
        
        // First request to know total pages
        $first = $this->fetchAllMovies(1);
        
        $totalPages = min($first['total_pages'] ?? 1, $maxPages);
        
        for ($page = 1; $page <= $totalPages; $page++) {
            $data = $page === 1 ? $first : $this->fetchAllMovies($page);
            
            foreach ($data['results'] ?? [] as $movie) {
                Movie::updateOrCreate(
                    ['tmdb_id' => $movie['id']],
                    [
                        'title' => $movie['title'],
                        'original_title' => $movie['original_title'] ?? null,
                        'overview' => $movie['overview'] ?? null,
                        
                        'release_date' => !empty($movie['release_date']) ? $movie['release_date'] : null,
                        
                        'poster_path' => $movie['poster_path'] ?? null,
                        'backdrop_path' => $movie['backdrop_path'] ?? null,
                        
                        'adult' => $movie['adult'] ?? false,
                        'video' => $movie['video'] ?? false,
                        'original_language' => $movie['original_language'] ?? null,
                        'genre_ids' => $movie['genre_ids'] ?? [],
                        
                        'popularity' => $movie['popularity'] ?? 0,
                        'vote_average' => $movie['vote_average'] ?? 0,
                        'vote_count' => $movie['vote_count'] ?? 0,
                    ]
                    );
                
                $imported++;
            }
            
            // Optional: avoid rate limiting
            usleep(200000); // 0.2s
        }
        
        return $imported;
    }

    /**
     * Fetch movie genres from TMDB
     *
     * @return array
     */
    public function fetchGenres(): array
    {
        $response = Http::get("{$this->baseUrl}/genre/movie/list", [
            'api_key'  => $this->apiKey,
            'language' => 'en-US',
        ]);

        $response->throw();

        return $response->json('genres', []);
    }

    /**
     * Import all movie genres into database
     *
     * @return int
     */
    public function importGenres(): int
    {
        $genres = $this->fetchGenres();

        foreach ($genres as $genre) {
            Genre::updateOrCreate(
                ['tmdb_id' => $genre['id']],
                ['name' => $genre['name']]
            );
        }

        return count($genres);
    }

    /**
     * Fetch movie credits (cast and crew) from TMDB
     * 
     * @param int $movieId
     * @return array
     */
    public function fetchMovieCredits(int $movieId): array
    {
        $response = Http::get("{$this->baseUrl}/movie/{$movieId}/credits", [
            'api_key' => $this->apiKey,
            'language' => 'en-US',
        ])->throw();
        
        sleep(3);

        return $response->json();
    }

    /**
     * Import movie credits (cast) into database
     * 
     * @param Movie $movie
     * @return int
     */
    public function importMovieCredits(Movie $movie): int
    {
        $credits = $this->fetchMovieCredits($movie->tmdb_id);
        $count = 0;

        foreach ($credits['cast'] ?? [] as $cast) {
            $person = Person::updateOrCreate(
                ['tmdb_id' => $cast['id']],
                [
                    'name' => $cast['name'],
                    'profile_path' => $cast['profile_path'] ?? null,
                    'known_for_department' => $cast['known_for_department'] ?? 'Acting',
                ]
            );

            $movie->people()->syncWithoutDetaching([
                $person->id => [
                    'character' => $cast['character'] ?? null,
                    'order' => $cast['order'] ?? null,
                ]
            ]);

            $count++;
        }

        return $count;
    }

    /**
     * Import credits for all movies in the database
     * 
     * @return int
     */
    public function importAllCredits(): int
    {
        $movies = Movie::all();
        $totalImported = 0;

        foreach ($movies as $movie) {
            $imported = $this->importMovieCredits($movie);
            $totalImported += $imported;
        }

        return $totalImported;
    }

    /**
     * Normalize date string to nullable format
     * 
     * @param string|null $date
     * @return string|null
     */
    protected function normalizeDate(?string $date): ?string
    {
        return !empty($date) ? $date : null;
    }
}

?>