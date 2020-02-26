<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivitiesWithDayActivitiesResourceCollection extends ResourceCollection
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
            'activities' => ActivitiesWithDayActivitiesResource::collection($this),
            'user' => $this->first() ? new UserResource($this->first()->userActivity->user): [],
        ];
    }
}
