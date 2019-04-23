<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Project;

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

        if (! request()->ajax()) {
            abort(403);
        }

        if (request('selected') == 'all') {
            return Project::withTrashed()
                    ->with(['tasks' => function ($query) {
                        $query->withTrashed();
                    }])
                    ->where('title', 'like', '%' . strtolower(request('name')) . '%')
                    ->whereBetween('created_at', [ $startDate, $endDate])
                    ->paginate(50);
        }

        if (request('selected') == 'completed') {
            return Project::withTrashed()
                    ->with(['tasks' => function ($query) {
                        $query->withTrashed()->where('completed', 1);
                    }])
                    ->where('title', 'like', '%' . strtolower(request('name')) . '%')
                    ->whereBetween('created_at', [ $startDate, $endDate])
                    ->paginate(50);
        }

        if (request('selected') == 'cancelled') {
            return Project::withTrashed()
                    ->with(['tasks' => function ($query) {
                        $query->withTrashed()->whereNotNull('cancelled');
                    }])
                    ->where('title', 'like', '%' . strtolower(request('name')) . '%')
                    ->whereBetween('created_at', [ $startDate, $endDate])
                    ->paginate(50);
        }
    }

    public function export()
    {
    }
}
