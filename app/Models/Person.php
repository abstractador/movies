<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'tmdb_id',
        'name',
        'profile_path',
        'known_for_department',
    ];

    /**
     * Movies this person appeared in or worked on
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class)
            ->withPivot([
                'character',
                'job',
                'order',
            ])
            ->withTimestamps();
    }
}

?>