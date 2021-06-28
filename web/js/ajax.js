d = console.log;
function ajaxSend($form_holder, $additional_data = {}){
  if(event) event.preventDefault();

  d("AJAX | Rozpoczynam dla "+$form_holder);
  if(!$form_holder) return false;
  $form = $("#"+$form_holder);
  if(!$form) return false;


  $data = {};
  $data.recaptcha = false;
  $data.additional = $additional_data;

  $url = $($form).attr("action") ? $($form).attr("action") : location.href;
  $method = $($form).attr("method") ? $($form).attr("method") : "POST";

  $($($form).find("input, select")).each(function(i, e){
    $id = $(e).attr('id');
    $data[$id] = $(e).attr("type") == "checkbox" ? $(e).is(":checked") ? 1 : 0 : $(e).val();;
  });

  $($($form).find("textarea")).each(function(i, e){
    if(typeof(tinymce) != "undefined"){
      $id = $(e).attr('id');
      $editor = tinymce.get($id)
      $data[$id] = $editor ? $editor.getContent() : false;
    } else {
      $id = $(e).attr('id');
      $data[$id] = $(e).val();
    }
  });
  if(typeof(grecaptcha) != "undefined" && typeof($grecaptcha_active) != "undefined" && $grecaptcha_active == true){
    $data.recaptcha = grecaptcha.getResponse();
  }




  d("AJAX | URL "+$url);
  d("AJAX | METHOD "+$method);
  d("AJAX | DATA:");
  d($data);

  $.ajax({
    url: $url,
    data: $data,
    type: $method,
  }).done(function(data){
    $form.find("p.error").text("");
    data = JSON.parse(data);
    d("AJAX | AJAX Data");
    d(data);

    if(data && data.close == true)    $(".modal").modal('hide');
    if(data && data.clear == true)    $("input:not([type='hidden'])").val("");
    if(data && data.reload == true)   location.reload();
    if(data && data.redirect) window.location = data.redirect;

    if(data && data.message) $.notify({'message': data.message}, {'type': data.success ? "success" : "danger"});


    if(data && data.errors){
      d(data.errors);
      $.map(data.errors, function(v, k) {
        $form.find("#"+k).nextAll(".error").text(v);
      });
    }

    captchaReset();
  }).fail(function($r){
    d($r.responseText);
    captchaReset();
  });
}

$s = "";
$ell = false;
