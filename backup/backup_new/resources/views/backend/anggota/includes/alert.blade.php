@if(Session::has('ktaStillActive'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Tidak Dapat Di Proses',
        text: 'Status Kartu Tanda Anggota anda masih dalam status pengguna "Aktif"',
        
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

<!-- add by Yudiana 22-12-2020 -->
@if(Session::has('preventJenisPengajuan'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'MAAF, PROSES ANDA BELUM DAPAT KAMI LANJUTKAN! ',
        text: 'Kartu Tanda Anggota Anda sudah aktif',
        
        })
    </script>
@endif

@if(Session::has('preventReJenisPengajuan'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'MAAF, PROSES ANDA BELUM DAPAT KAMI LANJUTKAN! ',
        text: 'Kartu Tanda Anggota Anda sudah aktif',
        
        })
    </script>
@endif


