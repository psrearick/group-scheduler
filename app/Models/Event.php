<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    public function schedule() : BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function members() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class);
    }
}
