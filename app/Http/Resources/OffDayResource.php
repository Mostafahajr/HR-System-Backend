<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OffDayResource extends JsonResource
{

    // you can fix the problem in offday model
    //or here Check if $this->date is a Carbon instance and in return ['date'=>$date]  

   // $date = $this->date instanceof Carbon ? $this->date->toDateString() : $this->date;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->toDateString(),
            'description' => $this->description,
            'off_day_types' => OffDayTypeResource::collection($this->offDayTypes),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
