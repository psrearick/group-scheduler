<?php

namespace App\Repositories;

use App\Helpers\CollectionHelper;
use App\Http\Requests\StoreOtherMemberRequest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MemberRepository extends Repository
{
    private GroupRepository $groupRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
    }

    public function getMembersForCurrentGroup() : Collection
    {
        $currentGroup = $this->groupRepository->getCurrentGroup();

        return $currentGroup->users;
    }

    public function getMembersForCurrentGroupPaginated(int $paginate) : LengthAwarePaginator
    {
        return CollectionHelper::paginate($this->getMembersForCurrentGroup(), $paginate);
    }

    public function storeMember(StoreOtherMemberRequest $request) : array
    {
        if (isset($request['email'])) {
            $user = User::where('email', '=', $request['email'])->first();

            if (!$user) {
                return ['email' => 'Email not found'];
            }
        }

        if (isset($request['username'])) {
            $user = User::where('username', '=', $request['username'])->first();

            if (!$user) {
                return ['username' => 'Username not found'];
            }
        }

        if (isset($user)) {
            $user->groups()->syncWithoutDetaching(session('group'));
        }

        return [];
    }
}
