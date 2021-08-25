<?php

namespace App\Actions\Members;

use App\Models\User;
use Illuminate\Support\Str;

class GenerateUsername
{
    public string $name;

    public string $username;

    public function __construct(string $name = "")
    {
        $this->name = $name;
    }

    public function generate(int $iteration = 0) : string
    {
        $text = Str::studly($this->name);
        $append = $iteration > 0 ? $iteration : null;
        $username = $text . $append;
        $count = User::where('username', '=', $username)->count();
        return $count == 0 ? $username : $this->generate(++$iteration);
    }
}
