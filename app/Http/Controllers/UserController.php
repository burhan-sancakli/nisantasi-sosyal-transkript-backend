<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->filter(function ($user) {
            return !$user->is_staff;
        });

        return response()->json($users);
    }
    public function getUserDetails($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'university_id' => $user->university_id,
            'faculty' => $user->faculty,
            'department' => $user->department
        ]);
    }
}