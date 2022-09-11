@if (Session::has('successAddTesti'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambah data testimonial',
        })
    </script>
@endif

@if (Session::has('successUpdateTesti'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah data testimonial',
        })
    </script>
@endif

@if (Session::has('failedUpdateTesti'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal merubah data testimonial',
        })
    </script>
@endif

@if (Session::has('successAddSponsorship'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambah data sponsorship',
        })
    </script>
@endif

@if (Session::has('successUpdateSponsorhip'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah data sponsorship',
        })
    </script>
@endif

@if (Session::has('failedUpdateSponsorship'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal merubah data sponsorship',
        })
    </script>
@endif

@if (Session::has('successAddFaq'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambah data FAQ',
        })
    </script>
@endif

@if (Session::has('failedAddFaq'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal menambah data sponsorship',
        })
    </script>
@endif

@if (Session::has('successUpdateFaq'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah data FAQ',
        })
    </script>
@endif

@if (Session::has('failedUpdateFaq'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal merubah data FAQ',
        })
    </script>
@endif

@if (Session::has('failedDeleteFaq'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal merubah menghapus FAQ',
        })
    </script>
@endif


@if (Session::has('successAddNews'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambah data berita',
        })
    </script>
@endif

@if (Session::has('failedAddNews'))
    <script>
        Swal.fire({
        type: 'erroe',
        title: 'Gagal',
        text: 'Gagal menambah data berita',
        })
    </script>
@endif


@if (Session::has('successUpdateNews'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah data berita',
        })
    </script>
@endif


@if (Session::has('successUpdateNews'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah data berita',
        })
    </script>
@endif


@if (Session::has('failedDeleteNews'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gaga menghapus data berita',
        })
    </script>
@endif

@if (Session::has('successUpdateDataDpn'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah data DPN',
        })
    </script>
@endif

@if (Session::has('failedUpdateDataDpn'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gaga merubah data DPN',
        })
    </script>
@endif


@if (Session::has('successSaveAccountDpn'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambah akun DPN',
        })
    </script>
@endif

@if (Session::has('failedSaveAccountDpn'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gaga menambah akun DPN',
        })
    </script>
@endif


@if (Session::has('successUpdateAccountDpn'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah akun DPN',
        })
    </script>
@endif

@if (Session::has('failedUpdateAccountDpn'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal merubah akun DPN',
        })
    </script>
@endif

@if (Session::has('successSaveDataDpp'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambah data DPP',
        })
    </script>
@endif

@if (Session::has('failedSaveDataDpp'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal menambah akun DPP',
        })
    </script>
@endif


@if (Session::has('successUpdateDataDpp'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah data DPP',
        })
    </script>
@endif

@if (Session::has('failedUpdateDataDpp'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal merubah data DPP',
        })
    </script>
@endif



@if (Session::has('successSaveAccountDpp'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambah akun DPP',
        })
    </script>
@endif

@if (Session::has('failedSaveAccountDpp'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal menambah akun DPP',
        })
    </script>
@endif


@if (Session::has('successUpdateAccountDpp'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah akun DPP',
        })
    </script>
@endif

@if (Session::has('failedUpdateAccountDpp'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal merubah akun DPP',
        })
    </script>
@endif


@if (Session::has('successAddSuperAdmin'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambah akun Super Admin',
        })
    </script>
@endif

@if (Session::has('failedAddSuperAdmin'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal menambah akun Super Admin',
        })
    </script>
@endif



@if (Session::has('successUpdateSuperAdmin'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah akun Super Admin',
        })
    </script>
@endif

@if (Session::has('failedUpdateSuperAdmin'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gagal merubah akun Super Admin',
        })
    </script>
@endif


@if (Session::has('failedToFormDpnAccount'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Isi data DPN terlebih dahulu',
        })
    </script>
@endif

@if (Session::has('sucsessUpdateAkunAnggota'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah akun Anggota',
        })
    </script>
@endif

@if (Session::has('successUpdateDokumenBu'))
    <script>
        Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Berhasil merubah dokumen Anggota',
        })
    </script>
@endif

@if (Session::has('failUpdateDokumenBu'))
    <script>
        Swal.fire({
        type: 'error',
        title: 'Gagal',
        text: 'Gaggal merubah dokumen anggota',
        })
    </script>
@endif












