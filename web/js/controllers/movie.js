$('#poster-drop').on('dragover', function(e) {
    e.stopPropagation();
    e.preventDefault();

    $(e.target).addClass("drop");
});
$('#poster-drop').on('dragleave', function(e) {
    e.stopPropagation();
    e.preventDefault();

    $(e.target).removeClass("drop");
});
$('#poster-drop').on('drop', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $files = e.originalEvent.dataTransfer.files;

    for (var i=0, $f; $f=$files[i]; i++) {
        if ($f.type.match(/image.*/)) {
            var $r = new FileReader();
            $r.name = $f.name;
            $r.size = $f.size;
            $r.onload = function(ev) {
              $.ajax({
                url: "/movie/poster",
                data: {'name': ev.target.name, 'src': ev.target.result},
                type: "POST",
              }).done(function($data){
                $data = JSON.parse($data);
                if($data && $data.success == true){
                  $("#poster-drop").attr("src", "/uploads/posters/"+$data.url);
                  $("#poster_url").val($data.id);

                  var newOption = new Option($data.name, $data.id, false, false);
                  $('#poster_select').append(newOption)
                }
              }).fail(function($r){
                d($r.responseText);
              });

            }

            $r.readAsDataURL($f);

        }
    }

    $("#gallery-list").removeClass("drop");
});

$(document).ready(function(){
  setTimeout(function(){
    $("#poster_select").on("change", function(e){
        $val = $(e.target).val();
        $.ajax({
          url: "/movie/posterdetails",
          data: {'id': $val},
          type: "POST",
        }).done(function($data){
          $data = JSON.parse($data);
          if($data && $data.success == true){
            $("#poster-drop").attr("src", "/uploads/posters/"+$data.url);
            $("#poster_url").val($data.id);
          }
        }).fail(function($r){
          d($r.responseText);
        });
    })
  }, 500)
})

function deleteMovie($id){
  $.ajax({
    url: "/movie/delete",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    if($data && $data.success == true){
      $("#movie_"+$data.id).fadeOut();
    }
  }).fail(function($r){
    d($r.responseText);
  });
}
function deleteTrailer($id){
  $.ajax({
    url: "/trailer/delete",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    if($data && $data.success == true){
      $("div[trailer-id='"+$id+"']").remove();
    }
  }).fail(function($r){
    d($r.responseText);
  });
}
function deleteSeance($id){
  $.ajax({
    url: "/seance/delete",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    if($data && $data.success == true){
      $("div[seance-id='"+$id+"']").remove();
    }
  }).fail(function($r){
    d($r.responseText);
  });
}

function restoreRating(){
  $rating = $(".rating:not(.disabled)").attr("rating");
  $(".rating:not(.disabled) i").removeClass("fas").removeClass("far");
  $(".rating:not(.disabled) i").each(function(i, e){
    $n_e = $(e);
    if($n_e.attr("rating") <= $rating){
      $n_e.addClass("fas");
    } else {
      $n_e.addClass("far");
    }
  })
}
function rateMovie($id, $value){
  $.ajax({
    url: "/movie/rate",
    data: {'id': $id, 'value': $value},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    console.log($data);
    if($data && $data.success == true){
      console.log($data.recalculated);
      $(".rating:not(.disabled)").attr("rating", $data.recalculated);
      restoreRating();

      $.notify({'message': "Twoja ocena została zarejestrowana"}, {'type': 'success'});
    }
  }).fail(function($r){
    d($r.responseText);
  });
}

function deleteReview($id){
  $.ajax({
    url: "/review/delete",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    if($data && $data.success == true){
      $("div[review-id='"+$data.id+"']").fadeOut();
      $.notify({'message' : 'Recenzja została usunięta'});
    }
  }).fail(function($r){
    d($r.responseText);
  });
}
function reportReview($id){
  $.ajax({
    url: "/review/report",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    d($data);
    if($data && $data.success == true){
      $.notify({'message' : 'Recenzja została zgłoszona jako nieodpowiednia'});
    }
  }).fail(function($r){
    d($r.responseText);
  });
}
function approveReview($id){
  $.ajax({
    url: "/review/approve",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    d($data);
    if($data && $data.success == true){
      $("tr[review-id='"+$data.id+"']").fadeOut();
      $.notify({'message' : 'Recenzja została zweryfikowana'});
    }
  }).fail(function($r){
    d($r.responseText);
  });
}


$(".rating:not(.disabled) i").on("mouseover", function(e){
  $e = $(e.target);
  $rating = $e.attr("rating");

  $(".rating:not(.disabled) i").removeClass("fas").removeClass("far");
  $(".rating:not(.disabled) i").each(function(i, e){
    $n_e = $(e);
    if($n_e.attr("rating") <= $rating){
      $n_e.addClass("fas");
    } else {
      $n_e.addClass("far");
    }
  })
})
$(".rating:not(.disabled)").on("mouseleave", function(e){
  restoreRating();
})
