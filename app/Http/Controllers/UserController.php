<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Populate the user text input jQuery autocomplete.
     * On the groups.show page, if admin, allows admin to find users and set as co-admin
     * Called with every user keystroke
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $user = $request->input('term'); // specific var from jQuery autocomplete

        $users = User::select('id as value', 'name as label')
            ->where('name', 'like', '%' . $user . '%')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

}
