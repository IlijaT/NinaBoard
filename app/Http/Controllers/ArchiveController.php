<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TaskStatsExport;

class ArchiveController extends Controller
{
    public function index()
    {
        return view('archive');
    }

    public function show()
    {
        $startDate =  Carbon::parse(request('start'))->startOfDay();
        $endDate =  Carbon::parse(request('end'))->endOfDay();

        if (request('selected') == 'all') {
            return Task::withTrashed()->with("project")->whereHas("project", function ($q) {
                $q->where("title", 'like', '%' . strtolower(request('name')) . '%');
            })
            ->whereBetween('created_at', [ $startDate, $endDate])
            ->oldest()
            ->paginate(50);
        }

        if (request('selected') == 'completed') {
            return Task::withTrashed()->with("project")->whereHas("project", function ($q) {
                $q->where("title", 'like', '%' . strtolower(request('name')) . '%');
            })
            ->where('completed', 1)
            ->whereBetween('created_at', [ $startDate, $endDate])
            ->oldest()
            ->paginate(50);
        }

        if (request('selected') == 'cancelled') {
            return Task::withTrashed()->with("project")->whereHas("project", function ($q) {
                $q->where("title", 'like', '%' . strtolower(request('name')) . '%');
            })
            ->whereNotNull('cancelled')
            ->whereBetween('created_at', [ $startDate, $endDate])
            ->oldest()
            ->paginate(50);
        }
    }

    public function export()
    {
        $name = request('name');
        $description = request('selected');
        $startDate =  Carbon::parse(request('start'))->startOfDay();
        $endDate =  Carbon::parse(request('end'))->endOfDay();

        $paramsForQuerying = ['name' => $name, 'description' => $description, 'startDate' => $startDate, 'endDate' => $endDate];
       
        $now = Carbon::now()->timestamp;

        return Excel::download(new TaskStatsExport($paramsForQuerying), "{$now}_{$name}_announcements_stats.xlsx");
    }
}
