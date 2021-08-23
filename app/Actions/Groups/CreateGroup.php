<?php

namespace App\Actions\Groups;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;

class CreateGroup
{
    /**
     * @throws ValidationException
     */
    public function store(array $input) : Group
    {
        return $this->createGroup($input);
    }

    /**
     * @throws ValidationException
     */
    public function storeForUser(array $input, User $user) : Group
    {
        $group = $this->createGroup($input);
        $user->groups()->attach($group->id);
        return $group;
    }

    /*
     * @throws ValidationException
     */
    public function createGroup(array $input) : Group
    {
        $this->validateData($input);
        return Group::create($input);
    }

    /**
     * @throws ValidationException
     */
    protected function validateData(array $input) : void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:groups,name'],
        ])->validate();
    }
}
