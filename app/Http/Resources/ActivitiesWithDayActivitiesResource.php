<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivitiesWithDayActivitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'activity_period' => $this->userActivity->activity_period,
            'day_activities' => DayActivityResource::collection($this->userActivity->dayActivities()->get())
    ];
    }
}
