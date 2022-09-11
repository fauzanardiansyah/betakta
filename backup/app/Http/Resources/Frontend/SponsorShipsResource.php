<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class SponsorShipsResource extends JsonResource
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
            'data' => [
                'id' => $this->id,
                'logo_bu' => url('storage/sponsorship/'.$this->logo_bu),
            ],
            'message' => 'Data sponsorship inkindo',
            'status' => 200  
        ];
    }
}
