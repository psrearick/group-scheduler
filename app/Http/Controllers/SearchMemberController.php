<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchMemberRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class SearchMemberController extends Controller
{
    public function show(SearchMemberRequest $request) : JsonResponse
    {
        $members = User
            ::where('name', 'like', '%' . $request->get('search') . '%')
            ->limit(20)
            ->get();

        return response()->json(['members' => $members]);
    }
}
