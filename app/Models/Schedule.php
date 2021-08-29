<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function events() : HasMany
    {
        return $this->hasMany(Event::class);
    }
}
