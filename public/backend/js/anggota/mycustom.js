// Select pengurusan
$(document).ready(function () {
  $('#jenis-bu').on('change', function () {
    const jenis_bu = $(this).find(":selected").val();
    const kualifikasi = $('#kualifikasi').find(":selected").val()

    if (jenis_bu == "pmdn") {
      $('.lokasi-pengurusan').attr('value', 'DPP INKINDO')
      $('#kualifikasi').removeAttr('disabled', 'disabled');
    } else {
      $('.lokasi-pengurusan').attr('value', 'DPN INKINDO');
    
      $('#kualifikasi').attr('disabled', 'disabled');
      $('#kualifikasi').val('besar');
    }
  });
});

// Select kewrganegaraan
$(document).ready(function () {
  $('#kewarganegaraan').on('change', function () {
    const kewarganegaraan = $(this).find(":selected").val();

    if (kewarganegaraan == "wni") {
      $('#passport').attr('disabled', 'disabled')
      $('#passport')
      $('#nik').removeAttr('disabled');
    } else {
      $('#nik').attr('disabled', 'disabled');
      $('#passport').removeAttr('disabled');
    }
  });
});



// Add akte perubahan fields
$(document).ready(function () {
  var max_fields = 10; //maximum input boxes allowed
  var wrapper = $(".input_fields_wrap_akte"); //Fields wrapper
  var add_button = $(".add_field_button_akte"); //Add button ID

  var x = 1; //initlal text box count
  $(add_button).click(function (e) { //on add input button click
    e.preventDefault();
    if (x < max_fields) { //max input box allowed
      x++; //text box increment
      $(wrapper).append(`
          <br><br><br>
          <div class="form-group">
                <label class="col-sm-3 control-label" for="w4-cc">Nomor Akte Perubahan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="no_akte_perubahan[]" id="w4-cc" placeholder="Nomor Akte Perubahan" >
                </div>
            </div>

            <div class="form-group">
                    <label class="col-sm-3 control-label" for="w4-cc">Nama Notaris Perubahan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nm_notaris_perubahan[]" id="w4-cc" placeholder="Nama Notaris" >
                    </div>
            </div>


            <div class="form-group">
                    <label class="col-sm-3 control-label" for="w4-cc">Tanggal Akte Perubahan Di Keluarkan</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="tgl_akte_perubahan_keluar[]" id="w4-cc" >
                    </div>
            </div>

            <div class="form-group">
                    <label class="col-sm-3 control-label" for="w4-cc">Maksud Dan Tujuan Badan Usaha Perubahan</label>
                    <div class="col-sm-9">
                    <textarea name="maksud_tujuan_akte_perubahan[]" class="form-control" id="" cols="30" rows="10" placeholder="Maksud dan tujuan badan usaha perubahan"></textarea>
            </div>
           
          `); //add input box
    }
  });

});



// Add sk perubahan fields
$(document).ready(function () {
  var max_fields = 10; //maximum input boxes allowed
  var wrapper = $(".input_fields_wrap_sk"); //Fields wrapper
  var add_button = $(".add_field_button_sk"); //Add button ID

  var x = 1; //initlal text box count
  $(add_button).click(function (e) { //on add input button click
    e.preventDefault();
    if (x < max_fields) { //max input box allowed
      x++; //text box increment
      $(wrapper).append(`
              <br><br><br>
              <div class="item form-group">
              <label class="col-sm-3 control-label" for="w4-first-name">Nomor Perubahan Pengesahan</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="no_sk_perubahan[]" id="" placeholder="Nomor Perubahan Pengesahan" >
              </div>
            </div>


            <div class="item form-group">
                    <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Perubahan Di Keluarkan </label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="tgl_sk_perubahan_keluar[]" id="" placeholder="Masa Berlaku" >
                    </div>
            </div>
           
               
              `); //add input box
    }
  });

});

// Add KBLI fields
$(document).ready(function () {
  var max_fields = 10; //maximum input boxes allowed
  var wrapper = $(".input_fields_wrap_kbli"); //Fields wrapper
  var add_button = $(".add_field_button_klbi"); //Add button ID

  var x = 1; //initlal text box count
  $(add_button).click(function (e) { //on add input button click
    e.preventDefault();
    if (x < max_fields) { //max input box allowed
      x++; //text box increment
      $(wrapper).append(`
              <br><br><br>
              <div class="item form-group">
              <label class="col-sm-3 control-label" for="w4-first-name">Nama KBLI</label>
              <div class="col-sm-3">
                  <input type="text" class="form-control" name="nama_kbli[]" id="" placeholder="Nama KBLI">
              </div>
            </div>


            <div class="item form-group">
                    <label class="col-sm-3 control-label" for="w4-first-name">Nomor KBLI</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="no_kbli[]" id="" placeholder="Nomor KBLI" >
                    </div>
            </div>
          
              `); //add input box
    }
  });

});

// Data Tables
$(document).ready(function() {
  $('#datatable-status-anggota').DataTable( {
    "order": [[ 0, "desc" ]]
  });
} );


$(document).ready(function (event) {
  $('.forms-with-spinner').submit(function () {
    var loading = new Loading({
      // loading title
      title: 'Loading...',

      // text color
      titleColor: '#FFF',
      // background color
      loadingBgColor: 'rgb(49, 176, 213)',

    });
  });
});


$(document).ready(function() {
  $('.show-file-detail').click(function(){
    event.preventDefault();
    var file_name = $(this).attr('file-name');
    PDFObject.embed(location.protocol + '//' + location.host+'/storage/legalitas-files/'+file_name, "#show-file-detail")

  });
});


$(document).ready(function() {
  $('.show-file-foto-pjbu').click(function(){
    event.preventDefault();
    var file_name = $(this).attr('file-name');
    $('#show-file-detail').html("<center><img src='"+location.protocol + '//' + location.host+'/storage/legalitas-files/'+file_name+"' style='height:40em' class='img-responsive'></center>");

  });
});


$(document).ready(function() {

    
  var readURL = function(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('.profile-pic').attr('src', e.target.result);
          }
  
          reader.readAsDataURL(input.files[0]);
      }
  }
  

  $(".file-upload").on('change', function(){
      readURL(this);
  });
  
  $(".upload-button").on('click', function() {
     $(".file-upload").click();
  });
});








