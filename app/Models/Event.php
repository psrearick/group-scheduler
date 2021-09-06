<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $appends = ['start_date'];

    public function eventGroup() : BelongsTo
    {
        return $this->belongsTo(EventGroup::class);
    }

    public function getDateAttribute(string $date) : string
    {
        $day = new Carbon($date);

        return $day->format('m-d-Y');
    }

    public function getStartDateAttribute() : string
    {
        $day = new Carbon($this->attributes['date']);

        return $day->format('Y-m-d');
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function members() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function schedule() : BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class);
    }
}
