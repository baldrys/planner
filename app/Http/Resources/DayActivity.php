<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DayActivity extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userActivity = $this->userActivity;
        return [
            'user' => $userActivity->user->name,
            'activity' => $userActivity->activity->name,
            'is_done' => $this->is_done,
            'date' => $this->date,
        ];
    }
}