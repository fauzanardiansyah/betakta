<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class AllCouncilResource extends JsonResource
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
            'id'                     => $this->id,
            'nama_provinsi'          => $this->provinsi->name,
            'alamat'                 => $this->alamat,
            'no_telp_dewan_pengurus' => $this->no_telp_dewan_pengurus,
            'email_dewan_pengurus'   => $this->email_dewan_pengurus, 
            'status'                 => 200  
        ];
    }
}
