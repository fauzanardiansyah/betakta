<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InvoiceRoleSharing extends ResourceCollection
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
        'id' => $this->id,
        'no_invoice' => $this->no_invoice,
        'nm_bu' => $this->nm_bu,
        'jenis_pengajuan' => ($this->jenis_pengajuan == 0) ? 'Buat Baru' : 'Daftar Ulang',
        'total_role_share' => $this->total_role_share,
        'tgl_cetak' => $this->tgl_cetak,
        'status_pembayaran' => ($this->status_pembayaran == 0) ? 'pending' : 'paid',
        'created_at' => $this->created_at
       ];
    }
}
