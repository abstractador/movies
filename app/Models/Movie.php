<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'tmdb_id',
        
        // Titles & text
        'title',
        'original_title',
        'overview',
        
        // Dates
        'release_date',
        
        // Media
        'poster_path',
        'backdrop_path',
        
        // Metadata
        'adult',
        'video',
        'original_language',
        'genre_ids',
        
        // Stats
        'popularity',
        'vote_average',
        'vote_count',
    ];
    
    protected $casts = [
        'adult' => 'boolean',
        'video' => 'boolean',
        'genre_ids' => 'array',
        'release_date' => 'date',
        'popularity' => 'float',
        'vote_average' => 'float',
        'vote_count' => 'integer',
    ];
    
    /**
     * PostgreSQL-safe date handling
     */
    public function setReleaseDateAttribute($value): void
    {
        $this->attributes['release_date'] = !empty($value) ? $value : null;
    }

    /**
     * The people (cast & crew) that belong to the movie.
     */
    public function people()
    {
        return $this->belongsToMany(Person::class)
            ->withPivot(['character', 'job', 'order'])
            ->withTimestamps();
    }
}

?>