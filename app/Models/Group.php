<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function schedules() : HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
