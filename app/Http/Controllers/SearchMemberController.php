<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMemberRequest;
use App\Models\User;
use App\Repositories\UserMemberRepository;
use Illuminate\Http\JsonResponse;

class SearchMemberController extends Controller
{
    private UserMemberRepository $userMemberRepository;

    public function __construct(UserMemberRepository $userMemberRepository)
    {
        $this->userMemberRepository = $userMemberRepository;
    }

    /**
     * @param SearchMemberRequest $request
     * @return JsonResponse
     */
    public function show(SearchMemberRequest $request) : JsonResponse
    {
        return response()->json([
            'members' => $this->userMemberRepository->searchUsersInCurrentGroup($request),
        ]);
    }
}
