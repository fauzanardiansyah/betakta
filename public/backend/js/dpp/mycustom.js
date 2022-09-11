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
    $('.show-file-pemberhentian').click(function(){
      event.preventDefault();
      var file_name = $(this).attr('file-name');
      PDFObject.embed(location.protocol + '//' + location.host+'/storage/dokumen-pemberhentian/'+file_name, "#show-file-detail")
  
    });
  });


  $(document).ready(function() {
    $('.show-file-pindah').click(function(){
      event.preventDefault();
      var file_name = $(this).attr('file-name');
      console.log(file_name);
      PDFObject.embed(location.protocol + '//' + location.host+'/storage/pindah_dpp/'+file_name, "#show-file-detail")
  
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
  
  
  
  
  
  
  
  
  