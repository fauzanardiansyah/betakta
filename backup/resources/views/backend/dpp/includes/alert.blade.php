@if(Session::has('successApproveDokumenAnggota'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil melakukan approval dokumen anggota',
        
        })
    </script>
@endif

@if(Session::has('successRejectDokumenAnggota'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Dokumen berhasil di tolak oleh team inkindo',
        
        })
    </script>
@endif

@if(Session::has('successVerifyAnggota'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Pengajuan anggota ini sudah terverifikasi',
        
        })
    </script>
@endif

@if(Session::has('successUpdateAdminDpp'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Data dewan pengurus berhasil di perbaharui',
        
        })
    </script>
@endif

@if(Session::has('faildUpdateAdminDpp'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Data dewan pengurus gagal di perbaharui',
        
        })
    </script>
@endif
