$(document).ready(function(){
    $('#agt-baru-datatable').on('click', '#approve-dokumen-anggota', function(event) {     
        event.preventDefault()
     
        var url = $(this).attr('href');   

        Swal.fire({
            title: 'Apakah anda yakin sudah memeriksa dokumen anggota ini secara benar ?',
            text: "Tekan tombol ya jika, yakin",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, approve dokumen ini'
        }).then((result) => {
            if (result.value) {
                $(location).attr('href',url);
            }
        })
    });
});


$(document).ready(function(){
    $('#agt-baru-datatable').on('click', '#reject-dokumen-anggota', function(event) {     
        event.preventDefault()
     
        var url_process = $(this).attr('href'); 
        var id_detail_kta = $(this).attr('data-detail-kta')

        $('#id_detail_kta').val(id_detail_kta);
        
        $('#reject-form-modal').modal('show'); 

    });
});

$(document).ready(function(){
    $('#agt-pindah-datatable').on('click', '#pindah-dokumen-anggota', function(event) {     
        event.preventDefault()
        // alert('tes');
     
        var url_process = $(this).attr('href'); 
        var id_detail_kta = $(this).attr('data-detail-kta')

        $('#id_detail_kta').val(id_detail_kta);
        
        $('#pindah-dokumen-modal').modal('show'); 

    });
});


$(document).ready(function(){
    $('#reject-document').click( function(event) {     
        event.preventDefault()
     
        var url = $(this).attr('href');
        
      
        Swal.fire({
            title: 'Apakah anda yakin sudah memeriksa dokumen anggota ini secara benar ?',
            text: "Tekan tombol ya jika, yakin",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tolak pengajuan ini'
        }).then((result) => {
            if (result.value) {
                $( "#form-reject-document" ).submit();
            }
        })
    });
});



    