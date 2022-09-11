<table style="border-collapse:collapse;border-spacing:0" border="1" class="tg">
    <thead>
    <tr>
        <th style="background-color: #95CEFF;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:middle;word-break:normal" rowspan="2">No</th>
        <th style="background-color: #95CEFF;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal" colspan="7"><span style="font-weight:bold">Rekapitulasi Anggota KTA ONLINE INKINDO</span></th>
    </tr>
    <tr>
        <td style="background-color: #95CEFF;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:middle;word-break:normal">Nama Provinsi</td>
        <td style="background-color: #95CEFF;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:middle;word-break:normal">Anggota Aktif</td>
        <td style="background-color: #95CEFF;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:middle;word-break:normal">Anggota Berhenti</td>
        <td style="background-color: #95CEFF;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:middle;word-break:normal">Di Kembalikan DPP</td>
        <td style="background-color: #95CEFF;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:middle;word-break:normal">Di kembalikan DPN</td>
        <td style="background-color: #95CEFF;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:middle;word-break:normal">Di Proses DPP</td>
        <td style="background-color: #95CEFF;border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;font-weight:bold;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:middle;word-break:normal">Di Proses DPN</td>
    </tr>
</thead>
<tbody>
    <?php $no = 1; ?>

    @foreach ($data as $item)
    <tr>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">{{ $no }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">

            {{ $item['name'] }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">

            @php 

                $total_aktif = DB::table('provinsi as a')
                ->select('a.id','kd_provinsi','name',DB::raw('COUNT(b.id) as total_aktif'))
                ->leftjoin('t_kta as b','a.id','b.id')
                ->leftjoin('t_detail_kta as c','c.id_kta','b.id')
                ->leftjoin('t_registrasi_users as d','c.id','b.id_registrasi_users')
                ->leftjoin('t_dp as e','e.id','b.id_dp')
                ->leftjoin('t_administrasi_kta as f','f.id_detail_kta','c.id')
                ->leftjoin('t_pj_kta as g','g.id_detail_kta','c.id')
                ->where('b.status_kta','0')
                ->where('c.is_inserted','4')
                ->where('a.id',$item['id'])
                ->groupBy()->first();

            @endphp
            {{ $total_aktif->total_aktif }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">

            @php 

            $total_berhenti = DB::table('provinsi as a')
                ->select('a.id','kd_provinsi','name',DB::raw('COUNT(b.id) as total_berhenti'))
                ->leftjoin('t_kta as b','a.id','b.id')
                ->leftjoin('t_detail_kta as c','c.id_kta','b.id')
                ->leftjoin('t_app_kta as d','c.id','d.id_detail_kta')
                ->leftjoin('t_dp as e','e.id','b.id_dp')
                
                // ->leftjoin('t_administrasi_kta as f','f.id_detail_kta','c.id')
                // ->leftjoin('t_pj_kta as g','g.id_detail_kta','c.id')
                ->where('b.status_kta','2')
                ->where('c.is_inserted','4')
                ->where('a.id',$item['id'])
                ->groupBy()->first();

                // dd($total_berhenti);

            @endphp
            {{ $total_berhenti->total_berhenti }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">
              @php 

                $dikembalikan_dpp = DB::table('provinsi as a')
                ->select('a.id','kd_provinsi','name',DB::raw('COUNT(b.id) as dikembalikan_dpp'))
                ->leftjoin('t_kta as b','a.id','b.id')
                ->leftjoin('t_detail_kta as c','c.id_kta','b.id')
                ->leftjoin('t_app_kta as d','c.id','d.id_detail_kta')
                ->leftjoin('t_dp as e','e.id','b.id_dp')

                // ->leftjoin('t_administrasi_kta as f','f.id_detail_kta','c.id')
                // ->leftjoin('t_pj_kta as g','g.id_detail_kta','c.id')
                ->where('d.status_pengajuan','1')
                ->where('c.is_inserted','4')
                ->where('a.id',$item['id'])
                ->groupBy()->first();

            @endphp
            {{ $dikembalikan_dpp->dikembalikan_dpp }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">

             @php 

                $dikembalikan_dpn = DB::table('provinsi as a')
                ->select('a.id','kd_provinsi','name',DB::raw('COUNT(b.id) as dikembalikan_dpn'))
                ->leftjoin('t_kta as b','a.id','b.id')
                ->leftjoin('t_detail_kta as c','c.id_kta','b.id')
                ->leftjoin('t_app_kta as d','c.id','d.id_detail_kta')
                ->leftjoin('t_dp as e','e.id','b.id_dp')

                // ->leftjoin('t_administrasi_kta as f','f.id_detail_kta','c.id')
                // ->leftjoin('t_pj_kta as g','g.id_detail_kta','c.id')
                ->where('d.status_pengajuan','4')
                ->where('c.is_inserted','4')
                ->where('a.id',$item['id'])
                ->groupBy()->first();

            @endphp

            {{ $dikembalikan_dpn->dikembalikan_dpn }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">
             @php 

                $diproses_dpp = DB::table('provinsi as a')
                ->select('a.id','kd_provinsi','name',DB::raw('COUNT(b.id) as diproses_dpp'))
                ->leftjoin('t_kta as b','a.id','b.id')
                ->leftjoin('t_detail_kta as c','c.id_kta','b.id')
                ->leftjoin('t_app_kta as d','c.id','d.id_detail_kta')
                ->leftjoin('t_dp as e','e.id','b.id_dp')

                // ->leftjoin('t_administrasi_kta as f','f.id_detail_kta','c.id')
                // ->leftjoin('t_pj_kta as g','g.id_detail_kta','c.id')
                ->whereRaw('(d.status_pengajuan =2 or status_pengajuan = 0)')
                ->where('c.is_inserted','4')
                ->where('a.id',$item['id'])
                ->groupBy()->first();

            @endphp

            {{ $diproses_dpp->diproses_dpp }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">
             @php 

                $diproses_dpn = DB::table('provinsi as a')
                ->select('a.id','kd_provinsi','name',DB::raw('COUNT(b.id) as diproses_dpn'))
                ->leftjoin('t_kta as b','a.id','b.id')
                ->leftjoin('t_detail_kta as c','c.id_kta','b.id')
                ->leftjoin('t_app_kta as d','c.id','d.id_detail_kta')
                ->leftjoin('t_dp as e','e.id','b.id_dp')

                // ->leftjoin('t_administrasi_kta as f','f.id_detail_kta','c.id')
                // ->leftjoin('t_pj_kta as g','g.id_detail_kta','c.id')
                ->whereRaw('(d.status_pengajuan = 3 OR d.status_pengajuan = 5 OR d.status_pengajuan = 6)')
                ->where('c.is_inserted','4')
                ->where('a.id',$item['id'])
                ->groupBy()->first();

                // dd($diproses_dpn);

            @endphp


            {{ $diproses_dpn->diproses_dpn }}</td>
    </tr>
    <?php $no++; ?> 
    @endforeach
    
</tbody>
</table>