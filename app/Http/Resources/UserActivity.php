<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserActivity extends JsonResource
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
            'user' => $this->id,
            'activity' => $this->name,
            'is_done' => $this->is_done,
            'date' => $this->date,
        ];
    }
}
