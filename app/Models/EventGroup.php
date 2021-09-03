<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class EventGroup extends Model
{
    public function events() : HasMany
    {
        return $this->hasMany(Event::class);
    }
}
