// Header Scroll Add Class
if($(window).scrollTop() == 0){
    $(".header_area").removeClass("fixed-white");
}else{
    $(".header_area").addClass("fixed-white");
}

$(window).on('scroll',function() {    
    var scroll = $(window).scrollTop();
    if (scroll < 10) {
        $(".header_area").removeClass("fixed-white");
    }else{
        $(".header_area").addClass("fixed-white");
    }
});

$(document).on('click', '.btn_topup', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});

// SHOW MORE
$(".showmore-member").click(function () {
    // console.log('asdasdas');
    $(this).text(function(i, v){
       return v === 'Lihat Lebih Sedikit' ? 'Lihat Selengkapnya' : 'Lihat Lebih Sedikit'
    })
});

$('#partner').owlCarousel({
    autoplay:true,
    loop:true,
    margin:30,
    nav:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
});

$('#blogs').owlCarousel({
    autoplay:true,
    loop:true,
    margin:40,
    nav:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
});


// BACK TO TOP
let backToTop = $(".back-to-top");

$(window).on('scroll',function() {    
var scroll = $(window).scrollTop();

if (scroll < 750) {
    backToTop.removeClass('in');
} else{
    backToTop.addClass('in');
}
});

backToTop.click(function () {
    //1 second of animation time
    //html works for FFX but not Chrome
    //body works for Chrome but not FFX
    //This strange selector seems to work universally
    $("html, body").animate({scrollTop: 0}, 1000);
});

function testimonialSlider(){
    var testimonialSlider = $(".testimonial-slider");
    if( testimonialSlider.length ){
        testimonialSlider.owlCarousel({
            loop:true,
            margin:10,
            items: 1,
            autoplay: true,
            smartSpeed: 2500,
            autoplaySpeed: false,
            responsiveClass:true,
            nav: true,
            dot: true,
            stagePadding: 0,
            navText: ['<i class="ti-arrow-left"></i>','<i class="ti-arrow-right"></i>'],
            navContainer: '.agency_testimonial_info'
        })
    }
}
testimonialSlider();

// Banner Anchor Link
$(document).on('click', '.scroll-btn>a, .icon', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 1000);
});

function initialize() {
    var myLatLang = {lat: -6.207984, lng: 106.812344};

    var mapOptions = {
      center: myLatLang,
      zoom: 14,
    //   styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}],
      disableDefaultUI: true
    };

    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var marker = new google.maps.Marker({
        position: myLatLang,
        map: map,
        title: 'Kantor Pusat Inkindo'
    });
  };
  google.maps.event.addDomListener(window, 'load', initialize);

/*--------- WOW js-----------*/
function wowAnimation(){
    new WOW({
        offset: 100,          
        mobile: true
    }).init()
}
wowAnimation()