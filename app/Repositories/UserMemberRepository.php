<?php

namespace App\Repositories;

use App\Actions\Members\GenerateUsername;
use App\Http\Requests\SearchMemberRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;

class UserMemberRepository extends Repository
{
    private GroupRepository $groupRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
    }

    public function searchUsersInCurrentGroup(SearchMemberRequest $request) : Collection
    {
        return $this->groupRepository->getCurrentGroup()->users()
            ->where('name', 'like', '%' . $request->get('search') . '%')
            ->limit(20)
            ->get();
    }

    public function storeUserMember(StoreMemberRequest $request) : void
    {
        $user = User::create([
            'name'     => $request->input('name'),
            'username' => $request->input('username')
                ?? (new GenerateUsername($request->input('name')))->generate(),
            'email'            => $request->input('email'),
            'phone_number'     => $request->input('phone_number'),
            'groupme_username' => $request->input('groupme_username'),
        ]);

        $user->groups()->syncWithoutDetaching(Session::get('group'));
    }
}
