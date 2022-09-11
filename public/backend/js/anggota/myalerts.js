
    $('.btn-stop-kta').click(function (event) {
     
        event.preventDefault()
     
        var url = $(this).attr('href');    
    
        Swal.fire({
            title: 'Apakah anda yakin ingin berhenti menjadi anggota Inkindo ?',
            text: "Tekan tombol ya jika, yakin",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya ingin berhenti!'
        }).then((result) => {
            if (result.value) {
                $(location).attr('href',url);
            }
        })
    });


    $('.btn-extend-kta').click(function (event) {
     
        event.preventDefault()
     
        var direct_to_extend = $(this).attr('href');
        
        var extend_with_update = $(this).attr('data-link');


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-primary'
            },
            buttonsStyling: false,
          })
          
          swalWithBootstrapButtons.fire({
            title: 'Apakah Ingin Melakukan Perubahan Data KTA ?',
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Lakukan Perubahan Terlebih Dahulu !',
            cancelButtonText: 'Perpanjang tanpa perubahan data',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
              $(location).attr('href',extend_with_update);
            } else if (
              // Read more about handling dismissals
              result.dismiss === Swal.DismissReason.cancel
            ) {
                $(location).attr('href',direct_to_extend);
            }
          })
    });

