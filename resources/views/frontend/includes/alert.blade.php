@if(Session::has('faildStoreRegistrationUser'))
    <script>
        $( document ).ready(function() {
            $('#registration-modal').modal('show');
        });
    </script>
@endif 
@if(Session::has('sucsessStoreRegistrationUser'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil Melakukan Registrasi',
        text: 'Cek email yang terdaftar untuk melakukan aktifasi akun.',
        })
    </script>
@endif 
@if(Session::has('sucsessVerifyRegistrationUser'))
    <script>
         Swal.fire({
        type: 'success',
        title: 'Berhasil Verifikasi',
        text: 'Akun anda sudah dapat di gunakan.',
        })
    </script>
@endif 
@if(Session::has('failValidationdLoginRegistrationUser'))
    <script>
        $( document ).ready(function() {
            $('#login-modal').modal('show');
        });
    </script>
@endif
@if(Session::has('failEmailOrNpwpLoginRegistrationUser'))
    <script>
        $( document ).ready(function() {
            $('#login-modal').modal('show');
        });
    </script>
@endif

@if(Session::has('failPasswordLoginRegistrationUser'))
    <script>
        $( document ).ready(function() {
            $('#login-modal').modal('show');
        });
    </script>
@endif

@if(Session::has('successSendResetPassword'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil Mengirimkan email reset password',
        text: 'Cek email anda untuk melakukan reset password',
        })
    </script>
@endif
@if(Session::has('successResetPasswordRegistrationUsers'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil Mereset Password',
        text: 'Password Anda Berhasil Di Reset.',
        })
    </script>
@endif 
@if(Session::has('faildResetPasswordRegistrationUsers'))
    <script>
        $( document ).ready(function() {
            $('#forget-password-modal').modal('show');
        });
    </script>
@endif
@if(Session::has('failedCekKeAbsahan'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal Melakukan Cek Ke Absahan',
        text: 'NPWP Atau Email Wajib Di Isi.',
        })
    </script>
@endif
@if(Session::has('failedEmailOrNpwpValidity'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Gagal Melakukan Cek Ke Absahan',
        text: 'NPWP Atau Email Yang Anda Masukan Tidak Terdaftar.',
        })
    </script>
@endif

@if(Session::has('failVerficationLoginRegistrationUser'))
    <script>
       Swal.fire({
        type: 'error',
        title: 'Gagal Melakukan Login',
        text: 'Anda belum melakukan aktifasi akun.',
        })
    </script>
@endif





