<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOtherMemberRequest;
use App\Repositories\MemberRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class MemberController extends Controller
{
    private MemberRepository $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * @throws BindingResolutionException
     */
    public function index() : Response
    {
        return Inertia::render('Members/Index', [
            'members' => $this->memberRepository->getMembersForCurrentGroupPaginated(10),
        ]);
    }

    public function store(StoreOtherMemberRequest $request) : RedirectResponse
    {
        $errors = $this->memberRepository->storeMember($request);

        if (count($errors)) {
            return Redirect::back()->withErrors($errors);
        }

        return Redirect::back();
    }
}
