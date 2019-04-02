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
            if (request('selected') == 'all') {
                $activity = $user->activity()
                ->where('subject_type', 'App\\Task')
                ->where('description', '!=', 'incompleted_task')
                ->whereBetween('created_at', [ $startDate, $endDate])
                ->with('subject.project:id,title')->paginate(5); //temporary

                return $activity;
            }

            $activity = $user->activity()
                ->where('description', '=', request('selected'))
                ->whereBetween('created_at', [ $startDate, $endDate])
                ->with($this->resolveEagerLoadingModel(request('selected')))->paginate(5); //temporary

            return $activity;
        }

        abort(403);
    }

    protected function resolveEagerLoadingModel($activityDescription)
    {
        if ($activityDescription == 'completed_task' || $activityDescription == 'incompleted_task' || $activityDescription == 'created_task') {
            return 'subject.project:id,title';
        }
        return 'subject:id,title';
    }

    public function export(User $user)
    {
        $description = request('selected');
        $startDate =  Carbon::parse(request('start'))->startOfDay();
        $endDate =  Carbon::parse(request('end'))->endOfDay();
        $eagerLoadingModel = 'subject.project:id,title';

        $paramsForQuerying = ['user' => $user, 'description' => $description, 'startDate' => $startDate, 'endDate' => $endDate, 'eagerLoadingModel' => $eagerLoadingModel];
       
        $now = Carbon::now()->timestamp;

        if (auth()->user()->id === $user->id  || auth()->user()->hasRole('manager')) {
            return Excel::download(new UsersActivityExport($paramsForQuerying), "{$now}_{$user->name}_activity_stats.xlsx");
        }

        abort(403);
    }
}
