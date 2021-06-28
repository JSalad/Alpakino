function generateHall(){
  $width = $("#size_x").val();
  $height = $("#size_y").val();
  $container = $("#hall-selector tbody");
  $container.html("");

  $row = '<tr></tr>';
  $slot = '<td class="slot"></td>';

  for ($h = 1; $h <= $height; $h++) {
    $container.append($row);
    $new_row = $container.find("tr:last-child");
    $new_row.attr("row", $h);

    for ($w = 1; $w <= $width; $w++) {
      $new_row.append($slot);
      $new_slot = $new_row.find("td:last-child");
      $new_slot.attr("row", $h);
      $new_slot.attr("col", $w);

      $new_slot.css("width", "calc(100% / "+$width+" - 5px)");
      $new_slot.css("padding-bottom", "calc(100% / "+$width+")");

    }
  }
}

$current_mode = "none";
$start_x = -1;
$start_y = -1;
$end_x = -1;
$end_y = -1;

function createScreen(){
  $current_mode = "screen";
}
function deleteScreen(){
  // $current_mode = "none";
  $("td.screen").removeClass("screen");
}

function createSeat(){
  $current_mode = "seat";
}
function deleteSeat(){
  $("td.seat").removeClass("seat");
}

function createSeatVIP(){
  $current_mode = "seatvip";
}
function deleteSeatVIP(){
  // $current_mode = "none";
  $("td.seatvip").removeClass("seatvip");
}

function resetCords(){
  $start_x = -1;
  $start_y = -1;
  $end_x = -1;
  $end_y = -1;
}
function startDrag($el){
  if(!$el.hasClass("slot")) return false;

  $r = $el.attr("row");
  $c = $el.attr("col");

  if($r && $c){
    $start_x = parseInt($r);
    $start_y = parseInt($c);

    $end_x = -1;
    $end_y = -1;
  }

  // console.log("======");
  // console.log("$start_x: "+$start_x);
  // console.log("$start_y: "+$start_y);
  // console.log("======");
}
function stopDrag($el){
  if(!$el.hasClass("slot")) return false;

  $r = $el.attr("row");
  $c = $el.attr("col");

  if($r != -1 && $c != -1){
    $end_x = parseInt($r);
    $end_y = parseInt($c);
  }

  // console.log("======");
  // console.log("$start_x: "+$start_x);
  // console.log("$start_y: "+$start_y);
  // console.log("$end_x: "+$end_x);
  // console.log("$end_y: "+$end_y);
  // console.log("======");



  markSlots($start_x, $start_y, $end_x, $end_y);
};

function markSlots($start_x, $start_y, $end_x, $end_y){

  if($start_x > $end_x){
    $tmp = parseInt($start_x);
    $start_x = parseInt($end_x);
    $end_x = parseInt($tmp);
  }

  if($start_y > $end_y){
    $tmp = parseInt($start_y);
    $start_y = parseInt($end_y);
    $end_y = parseInt($tmp);
  }



  if($start_x == -1 || $start_x == -1 || $end_x == -1 || $end_y == -1) return false;

  if($current_mode == "none"){
    // console.log("No mode selected");
    return false;
  }
  // console.log($current_mode);
  for ($a = $start_x; $a <= $end_x; $a++) {
    // console.log("A: "+$a);
    // console.log($start_y);
    // console.log($end_y);
    // console.log($start_y <= $end_y);

    for ($b = $start_y; $b <= $end_y; $b++) {
      // console.log("B: "+$b);
      $el = $("tr[row='"+$a+"'] td[col='"+$b+"']");
      if(!$el.hasClass("screen") && !$el.hasClass("seatvip") && !$el.hasClass("seat")){
        if($current_mode == "screen") $el.addClass("screen");
        if($current_mode == "seatvip") $el.addClass("seatvip");
        if($current_mode == "seat") $el.addClass("seat");
      }
    }
  }
  // resetCords();
}

$slots = [];
function collectHallConfiguration(){
  $slots = [];
  $("#hall-selector td").each(function(i, e){
    $e = $(e);
    $row = $e.attr("row");
    $col = $e.attr("col");

    if($e.hasClass("seat")) $slots.push({'row': $row, 'col' : $col, 'type': 'seat' });
    if($e.hasClass("seatvip")) $slots.push({'row': $row, 'col' : $col, 'type': 'vip' });
    if($e.hasClass("screen")) $slots.push({'row': $row, 'col' : $col, 'type': 'screen' });
  });
  return $slots;
}


$("#hall-selector").mousedown(function(e){
  e.preventDefault();
  $e = $(e.target);
  startDrag($e);

})
$("body").mouseup(function(e){
  $e = $(e.target);
  stopDrag($e);

})
$(document).ready(function(){
  generateHall();
})

function addHall(){
  $slots = collectHallConfiguration();

  ajaxSend('movie-create', $slots);
}
function deleteHall($id){
  $.ajax({
    url: "/hall/delete",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    if($data && $data.success == true){
      $("tr[hall-id='"+$data.id+"']").fadeOut(300, function(){
        $("tr[hall-id='"+$data.id+"']").remove();
      });
    }
  }).fail(function($r){
    d($r.responseText);
  });
}
