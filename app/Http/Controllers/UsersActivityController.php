<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersActivityController extends Controller
{
    public function index(User $user)
    {
        $startDate =  Carbon::parse(request('start'))->startOfDay();
        $endDate =  Carbon::parse(request('end'))->endOfDay();

        if (auth()->user()->id === $user->id  || auth()->user()->hasRole('manager')) {
            $activity = $user->activity()
                ->where('description', '=', request('selected'))
                ->whereBetween('created_at', [ $startDate, $endDate])
                ->with($this->resolveEagerLoadingModel(request('selected')))->get();
            return $activity;
        }

        abort(403);
    }

    public function resolveEagerLoadingModel($activityDescription)
    {
        if ($activityDescription == 'completed_task' || $activityDescription == 'incompleted_task' || $activityDescription == 'created_task') {
            return 'subject.project';
        }

        return 'subject';
    }
}
