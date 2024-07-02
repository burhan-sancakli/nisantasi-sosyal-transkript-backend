<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    // Fillable fields for mass assignment
    protected $fillable = [
        'name', 'description', 'score', 'parent_id', 'is_active'
    ];

    /**
     * Relationship to fetch child activities.
     */
    public function children()
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    /**
     * Relationship to fetch the parent activity.
     */
    public function parent()
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    // Add any other methods or business logic specific to activities here
}