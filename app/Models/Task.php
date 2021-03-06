<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function members() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'member_task')->withTimestamps();
    }
}
