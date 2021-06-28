var lastScrollTop = 0;

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

function resizeBody(){
  $h = $("footer").outerHeight() - 200;
  $("body").css("padding-bottom", $h+"px");
  $("footer").addClass("loaded");
}


function navbarScroll(){
  $c = $(document).scrollTop();
  if ($c > lastScrollTop){
    $(".navbar").addClass("dir-down");
    $(".navbar").removeClass("dir-up");
  } else {
    $(".navbar").addClass("dir-up");
    $(".navbar").removeClass("dir-down");
  }

  $orig_h = $("header").height();
  $h = $orig_h - $(".navbar").height();
  if( $c >= $h ){
    $(".navbar").addClass("fixed");
    $("header").css("height", $orig_h+"px");
  } else {
    $(".navbar").removeClass("fixed");
    $("header").css("height", "unset");
  }

  lastScrollTop = $c;
}
function applySelect(){
  $("select").select2();
}
function applyTextarea(){
  tinymce.init({
    selector: 'textarea',
    oninit : "setPlainText",
    plugins : "paste",
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright',
    menubar: false,
    toolbar_mode: 'floating',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
  });
}
function applyTimepicker(){
  $('input[type="custom-date"]').bootstrapMaterialDatePicker({
    time: false,
    weekStart: 1,
    lang: 'pl',
    switchOnClick: true,
  });

  $('input[type="custom-time"]').bootstrapMaterialDatePicker({
    time: true,
    date: false,
    lang: 'pl',
    switchOnClick: true,
    format : 'HH:mm',
  });

}
function captchaReady(){
  if($("#recaptcha").get(0)){
    $recaptcha = grecaptcha.render('recaptcha');
    $grecaptcha_active = true;
  }
}

function captchaReset(){
  if($("#recaptcha").get(0)){
    grecaptcha.reset()
  }
}

$(document).on("scroll", function(){
  navbarScroll();
});
$(document).ready(function(){
  resizeBody();
  navbarScroll();
  applySelect();
  applyTextarea();
  applyTimepicker();
  $("body").addClass("loaded");
})
$(window).resize(function(){
  resizeBody();
})
