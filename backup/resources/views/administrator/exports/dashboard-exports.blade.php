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
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">{{ $item->nama_provinsi }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">{{ $item->total_aktif }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">{{ $item->total_berhenti }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">{{ $item->dikembalikan_dpp }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">{{ $item->dikembalikan_dpn }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">{{ $item->diproses_dpp }}</td>
        <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:10px 5px;text-align:center;vertical-align:top;word-break:normal">{{ $item->diproses_dpn }}</td>
    </tr>
    <?php $no++; ?> 
    @endforeach
    
</tbody>
</table>