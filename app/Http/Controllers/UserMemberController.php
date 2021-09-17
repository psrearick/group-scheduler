<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Repositories\UserMemberRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserMemberController extends Controller
{
    private UserMemberRepository $userMemberRepository;

    public function __construct(UserMemberRepository $userMemberRepository)
    {
        $this->userMemberRepository = $userMemberRepository;
    }

    public function store(StoreMemberRequest $request) : RedirectResponse
    {
        $this->userMemberRepository->storeUserMember($request);

        return Redirect::back();
    }
}
