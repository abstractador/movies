<?php

namespace App\Support;

use App\Models\Movie;

class MovieVectorFormatter
{
    public static function toText(Movie $movie): string
    {
        $cast = $movie->people
            ->whereNotNull('pivot.character')
            ->sortBy('pivot.order')
            ->take(8)
            ->pluck('name')
            ->implode(', ');

        return implode("\n", array_filter([
            "Title: {$movie->title}",
            "Overview: {$movie->overview}",
            "Release date: " . optional($movie->release_date)->format('Y-m-d'),
            "Rating: {$movie->vote_average}",
            "Popularity: {$movie->popularity}",
            "Genres: " . implode(', ', $movie->genre_ids ?? []),
            "Cast: {$cast}",
        ]));
    }
}

?>