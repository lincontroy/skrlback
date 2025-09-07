<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'biometrics_enabled' => 'sometimes|boolean',
            'notifications_enabled' => 'sometimes|boolean',
        ]);

        $user->update($request->only([
            'name', 'biometrics_enabled', 'notifications_enabled'
        ]));

        return response()->json($user);
    }
}