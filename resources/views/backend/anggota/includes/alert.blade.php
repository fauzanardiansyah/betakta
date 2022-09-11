@if(Session::has('ktaStillActive'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Tidak Dapat Di Proses',
        text: 'Status Kartu Tanda Anggota anda masih dalam status pengguna "Aktif"',
        
        })
    </script>
@endif

@if(Session::has('kta_kosong'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Mohon Maaf',
        text: 'KTA anda belum tergistrasi silahkan cetak KTA terlebih dahulu sebelum melakukan pindah DPP "Aktif"',
        
        })
    </script>
@endif

@if(Session::has('ktaAlreadyRegistered'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Tidak Dapat Di Proses',
        text: 'Tidak dapat melakukan pendaftaran ulang, di karenakan anda telah terdaftar di sistem KTA online INKINDO sebelumnya',
        
        })
    </script>
@endif

@if(Session::has('pindah_dpp'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Success',
        text: 'Pengajuan pindah dpp berhasil di ajukan',
        
        })
    </script>
@endif
@if(Session::has('validasi_kta_kosong'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Success',
        text: 'Kartu Tanda Anggota anda masih belum tersedia',
        
        })
    </script>
@endif

@if(Session::has('get_exist_dpp'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Error',
        text: 'Mohon maaf provinsi asal dengan provinsi tujuan sama ',
        
        })
    </script>
@endif


@if(Session::has('successExtend'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Pengajuan perpanjangan Kartu Tanda Anggota Anda akan segera di proses oleh team inkindo',
        
        })
    </script>
@endif

@if(Session::has('successRegistration'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Pengajuan ke anggotaan anda akan segera di proses oleh team inkindo',
        })
    </script>
@endif

@if(Session::has('successEdit'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Melakukan ubah data',
        })
    </script>
@endif

@if(Session::has('successResetPasswordRegistrationUsers'))
    <script>
       Swal.fire({
        type: 'success',
        title: 'Berhasil Merubah Password',
        text: 'Password anda telah berhasil kami ubah"',
        
        })
    </script>
@endif

@if(Session::has('faildResetPasswordRegistrationUsers'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Gagal Merubah Password',
        text: 'Password anda gagal kami rubah, silahkan cek kembali"',
        
        })
    </script>
@endif

@if(Session::has('preventDKI'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'MAAF, PROSES ANDA BELUM DAPAT KAMI LANJUTKAN! ',
        text: 'Mohon menunggu sistem sedang dalam proses integrasi,  silahkan hubungi https://www.inkindo-dki.org/contact',
        
        })
    </script>
@endif




