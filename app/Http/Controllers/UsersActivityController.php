<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Activity;

class UsersActivityController extends Controller
{
    public function index(User $user)
    {
        if (auth()->user()->id === $user->id  || auth()->user()->hasRole('manager')) {
            $activity = Activity::with('subject.project')->get();
            return $activity;
        }

        abort(403);
    }
}
