<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class UsersActivityExport implements FromCollection
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

        return $activity;
    }
}
