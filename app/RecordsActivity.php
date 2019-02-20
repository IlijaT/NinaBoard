<?php

namespace App;

trait RecordsActivity
{
    public $oldAttributes = [];

    public static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });
            
            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    public static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }
    
        return ['created', 'updated'];
    }

    protected function activityDescription($description)
    {
        return "{$description}_". strtolower(class_basename($this));
    }
    
    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }


    public function recordActivity($description)
    {
        return $this->activities()->create([
            'user_id'     => auth()->id(),
            'description' => $description,
            'changes'     => $this->activityChanges(),
            'project_id'  => class_basename($this) === "Project" ? $this->id : $this->project->id

            ]);
    }

    public function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after'  => array_except($this->getChanges(), 'updated_at')
            ];
        }
    }
}
