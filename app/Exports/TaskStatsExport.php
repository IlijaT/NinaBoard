<?php

namespace App\Exports;

use App\Task;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaskStatsExport implements FromCollection, WithHeadings
{
    protected $description;
    protected $name;
    protected $startDate;
    protected $endDate;
    protected $eagerLoadingModel;


    public function __construct(array $paramsForQuerying)
    {
        $this->description = $paramsForQuerying['description'];
        $this->name = $paramsForQuerying['name'];
        $this->startDate = $paramsForQuerying['startDate'];
        $this->endDate = $paramsForQuerying['endDate'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->description == 'all') {
            $tasks = Task::withTrashed()->with("project")->whereHas("project", function ($q) {
                $q->where("title", 'like', '%' . strtolower($this->name) . '%');
            })
            ->whereBetween('created_at', [ $this->startDate, $this->endDate])
            ->oldest()
            ->get();
        } elseif ($this->description == 'completed') {
            $tasks = Task::withTrashed()->with("project")->whereHas("project", function ($q) {
                $q->where("title", 'like', '%' . strtolower($this->name) . '%');
            })
            ->where('completed', 1)
            ->whereBetween('created_at', [ $this->startDate, $this->endDate])
            ->oldest()
            ->get();
        } else {
            $tasks = Task::withTrashed()->with("project")->whereHas("project", function ($q) {
                $q->where("title", 'like', '%' . strtolower($this->name) . '%');
            })
            ->whereNotNull('cancelled')
            ->whereBetween('created_at', [ $this->startDate, $this->endDate])
            ->oldest()
            ->get();
        }

       

        $dataForTable = $tasks->map(function ($task, $key) {
            return
            ['client'   => $task->project->title,
            'task'      => $task->title,
            'completed' => $task->completed == 1 ? 'completed' : '/',
            'cancelled' => $task->cancelled ? 'cancelled' : '/',
            'date'      => $task->created_at,
        ];
        });

        return  $dataForTable;
    }

    public function headings(): array
    {
        return [
           [$this->name],
           ['Client', 'Task', 'Completed', 'Cancelled', 'Date']
        ];
    }
}
