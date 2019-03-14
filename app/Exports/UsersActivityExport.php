<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersActivityExport implements FromCollection, WithHeadings
{
    protected $user;
    protected $description;
    protected $startDate;
    protected $endDate;
    protected $eagerLoadingModel;

    public function __construct(array $paramsForQuerying)
    {
        $this->user = $paramsForQuerying['user'];
        $this->description = $paramsForQuerying['description'];
        $this->startDate = $paramsForQuerying['startDate'];
        $this->endDate = $paramsForQuerying['endDate'];
        $this->eagerLoadingModel = $paramsForQuerying['eagerLoadingModel'];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $activity = $this->user->activity()
            ->where('description', '=', $this->description)
            ->whereBetween('created_at', [ $this->startDate, $this->endDate])
            ->with($this->eagerLoadingModel)->get();

        $dataForTable = $activity->map(function ($activity, $key) {
            return
            ['client'    => $activity->subject_type == 'App\\Project' ? $activity->subject->title : $activity->subject->project->title,
            'task'      => $activity->subject_type == 'App\\Project' ? '/' : $activity->subject->title,
            'action'    => $activity->description,
            'date'      => $activity->created_at];
        });

        return  $dataForTable;
    }

    public function headings(): array
    {
        return [
           [$this->user->name],
           ['Client', 'Task', 'Action', 'Date']
        ];
    }
}
