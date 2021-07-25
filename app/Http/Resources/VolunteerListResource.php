<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VolunteerListResource extends JsonResource
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
            'id'    => $this->id,
            'name'  => $this->name,
            'phone' => $this->phone,
            'active'    => $this->active,
            'township_id'  => $this->township_id,
            'township'  => $this->township->name_mm,
            'activities'    => $this->activities,
            'address'       => $this->address,
            'created_at'    => $this->created_at
        ];
    }
}
