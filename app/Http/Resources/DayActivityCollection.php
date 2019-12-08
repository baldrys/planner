<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\UserResource;

class DayActivityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'day_activities' => DayActivityResource::collection($this),
                'user' =>$this->count() != 0 ? new UserResource($this->first()->userActivity->user): []
            ]
        ];
    }
}
