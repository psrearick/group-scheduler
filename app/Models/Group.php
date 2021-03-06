<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    public function schedules() : HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
