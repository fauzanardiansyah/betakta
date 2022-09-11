<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return [
        //     'id'              => $this->id,
        //     'name'            => $this->name,
        //     'profile_picture' => url('storage/foto-testimonial/'.$this->profile_picture),
        //     'position'        => $this->position,
        //     'message'         => $this->message,
        //     'status'          => 200  
        // ];


        return [
            'data'    => $this->collection,
            'message' => 'Api data testimonials',
            'status'  => 200
        ];
    }
}
