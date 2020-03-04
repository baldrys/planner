<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ActivityResource;

class DayActivityResource extends JsonResource
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
            // 'activity' => new ActivityResource($this->userActivity->activity),
            'id'=> $this->id,
            'is_done' => (bool)$this->is_done,
            'is_free_day' => (bool)$this->is_free_day,
            'date' => $this->date->format('Y-m-d'),
            'is_paused' => (bool)$this->is_paused,
        ];
    }
}
