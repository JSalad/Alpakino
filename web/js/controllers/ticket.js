$seats = [];

function switchTo($step){
  $(".ticket-holder[step='"+($step-1)+"']").addClass("done");
  setTimeout(function(){
    $(".ticket-holder[step='"+($step-1)+"']").hide();

    $(".ticket-holder[step='"+$step+"']").show();
    $(".ticket-holder[step='"+$step+"']").removeClass("hidden");
  }, 500)
}
function initProcess(){
  switchTo(2)
}
function validateData(){
  $first_name = $("#first_name").val();
  $last_name = $("#last_name").val();
  $email = $("#email").val();

  $.ajax({
    url: "/ticket/validatedata",
    data: {'first_name': $first_name, 'last_name': $last_name, 'email': $email},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    console.log($data);
    if($data && $data.success == true){
      switchTo(3);
    }
    if($data && $data.errors){
      d($data.errors);
      $.map($data.errors, function(v, k) {
        $(".ticket-holder").find("#"+k).nextAll(".error").text(v);
      });
    }
  }).fail(function($r){
    d($r.responseText);
  });

}

$aaa = "";
function bookSeats(){
  $seats = [];
  $("p.schematic.selected").each(function(i, e){
      $e = $(e)
      $slot_id = $e.attr("slot-id")
      $seats.push($slot_id);
  });
  if($seats.length < 1){
    $("#seat-error").text("Aby kontynuować wybierz przynajmniej jedno miejsce");
    return false;
  }

  $first_name = $("#first_name").val();
  $last_name = $("#last_name").val();
  $email = $("#email").val();
  $aaa = "";
  $.ajax({
    url: "/ticket/booking",
    data: {'id_seance': getUrlParameter('id'), 'first_name': $first_name, 'last_name': $last_name, 'email': $email, 'seats': $seats},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    if($data && $data.success == true){
      $("#id_booking").val($data.id);

      if($data && $data.url){
        setTimeout(function(){
          $window = window.open(decodeURIComponent($data.url));
        }, 3000);

        checkPaymentStatus();


      }

      $(".hide-when-processing").fadeOut(function(){
        $(".show-when-processing").fadeIn();
      })


    }

  }).fail(function($r){
    d($r.responseText);
  });


}

function checkPaymentStatus($id = false){
  $id = $("#id_booking").val();




  setTimeout(function(){
    checkPaymentStatus();
  }, 5000);
}


$("p.schematic").on("click", function(e){
  $e = $(e.target);

  if($e.hasClass("seat") || $e.hasClass('vip')) $e.toggleClass("selected");

  $vip = $(".schematic.vip.selected").length;
  $standard = $(".schematic.seat.selected").length

  $price_vip = $("#price_vip").val() * $vip;
  $price_standard = $("#price_standard").val() * $standard;

  $(".seats-text.standard .highlighted, table .amount-standard").text($standard);
  $(".seats-text.vip .highlighted, table .amount-vip").text($vip);

  $(".seats-text.standard .seats-price, table .price-standard").text($price_standard+" zł");
  $(".seats-text.vip .seats-price, table .price-vip").text($price_vip+" zł");



})
$( window ).on('beforeunload', function() {
  if(typeof($window) != "undefined") $window.close()

  if($("#id_booking").val()){
    $.ajax({
      url: "/ticket/cancel",
      data: {'id': $("#id_booking").val()},
      type: "POST",
    }).done(function($data){
      console.log($data);
    }).fail(function($r){
      d($r.responseText);
    });
  }
});
