<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\UsersActivityExport;
use Maatwebsite\Excel\Facades\Excel;

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
                ->with($this->resolveEagerLoadingModel(request('selected')))->paginate(50); //temporary

            return $activity;
        }

        abort(403);
    }

    protected function resolveEagerLoadingModel($activityDescription)
    {
        if ($activityDescription == 'completed_task' || $activityDescription == 'incompleted_task' || $activityDescription == 'created_task') {
            return 'subject.project';
        }

        return 'subject';
    }

    public function export(User $user)
    {
        $description = request('selected');
        $startDate =  Carbon::parse(request('start'))->startOfDay();
        $endDate =  Carbon::parse(request('end'))->endOfDay();
        $eagerLoadingModel = $this->resolveEagerLoadingModel(request('selected'));

        $paramsForQuerying = ['user' => $user, 'description' => $description, 'startDate' => $startDate, 'endDate' => $endDate, 'eagerLoadingModel' => $eagerLoadingModel];

        if (auth()->user()->id === $user->id  || auth()->user()->hasRole('manager')) {
            return Excel::download(new UsersActivityExport($paramsForQuerying), 'users.xlsx');
        }

        abort(403);
    }
}
