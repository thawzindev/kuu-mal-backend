<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HelpRequestListResource extends JsonResource
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
            'uuid'  => $this->uuid,
            'name'  => $this->name,
            'phone' => $this->phone,
            'activities'    => $this->activities,
            'address'       => $this->address,
            'township'      => $this->township->name_mm,
            'created_date'  => $this->created_at->diffForHumans(),
            'created_at'    => $this->created_at->format('d-m-Y h:i:s A')
        ];
    }
}
