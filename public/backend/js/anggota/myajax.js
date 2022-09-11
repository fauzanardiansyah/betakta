// Ajax untuk tracking status 

$(document).on("click", "#status", function (event) {
    event.preventDefault();

    const id_registrasi_kta = $(this).attr("data-status");

    $.ajax({
        url: "/panel/anggota/get-tracking-anggota/" + id_registrasi_kta,
        type: 'GET',
        dataType: "JSON",
        data: { id_registrasi_kta: id_registrasi_kta, },
        processData: false,
        contentType: false,
        success: function (data) {

            $('#wizard').load(location.href+" #wizard>*","", function(){
           

                if (data.is_inserted == 4) {
                    $("#step-1").attr('class', 'done');
                }
    
                if (data.status_pengajuan == 10 || data.status_pengajuan == 0 || data.status_pengajuan == 2 || data.status_pengajuan == 3 || data.status_pengajuan == 4 || data.status_pengajuan == 5 || data.status_pengajuan == 6 || data.status_pengajuan == 7)  {
                    $("#step-2").attr('class', 'done');
                    $("#message-kta").html("<p class='alert alert-info'>" + data.keterangan + "</p>")
                } else if (data.status_pengajuan == 1) {
                    $("#step-2").attr('class', 'reject-document');
                    $("#message-kta").html("<p class='alert alert-danger'>" + data.keterangan + "</p>")
                }
    
                if (data.status_pengajuan == 3 || data.status_pengajuan == 5 || data.status_pengajuan == 6 || data.status_pengajuan == 7) {
                    $("#step-3").attr('class', 'done');
                    $("#message-kta").html("<p class='alert alert-info'>" + data.keterangan + "</p>")
                } else if (data.status_pengajuan == 4) {
                    $("#step-3").attr('class', 'reject-document');
                    $("#message-kta").html("<p class='alert alert-danger'>" + data.keterangan + "</p>")
                }
    
                if (data.status_pengajuan == 7 ) {
                    $("#step-4").attr('class', 'done');
                    $("#message-kta").html("<p class='alert alert-info'>" + data.keterangan + "</p>")
                }
            });
        
          

        },
        error: function (xhr, desc, err) {
            alert(err);
        }
    });

});