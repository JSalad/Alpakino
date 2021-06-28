$('#picture-drop').on('dragover', function(e) {
    e.stopPropagation();
    e.preventDefault();

    $(e.target).addClass("drop");
});
$('#picture-drop').on('dragleave', function(e) {
    e.stopPropagation();
    e.preventDefault();

    $(e.target).removeClass("drop");
});
$('#picture-drop').on('drop', function(e) {
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
                url: "/director/picture",
                data: {'name': ev.target.name, 'src': ev.target.result},
                type: "POST",
              }).done(function($data){
                $data = JSON.parse($data);
                if($data && $data.success == true){
                  $("#picture-drop").attr("src", "/uploads/directors/"+$data.url);
                  $("#picture").val($data.id);

                  var newOption = new Option($data.name, $data.id, false, false);
                  $('#picture_select').append(newOption)
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
    $("#picture_select").on("change", function(e){
        $val = $(e.target).val();
        $.ajax({
          url: "/director/picturedetails",
          data: {'id': $val},
          type: "POST",
        }).done(function($data){
          $data = JSON.parse($data);
          if($data && $data.success == true){
            $("#picture-drop").attr("src", "/uploads/directors/"+$data.url);
            $("#picture").val($data.id);
          }
        }).fail(function($r){
          d($r.responseText);
        });
    })
  }, 500)
})



function deleteDirector($id){
  $.ajax({
    url: "/director/delete",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    if($data && $data.success == true){
      $("tr[director-id='"+$data.id+"']").fadeOut(300, function(){
        $("tr[director-id='"+$data.id+"']").remove();
      });
    }
  }).fail(function($r){
    d($r.responseText);
  });
}


$(document).ready(function() {
  $('.slick-carousel-standard').slick({
    slidesToShow: 4,
    autoplay: true,
    autoplaySpeed: 500000,
    arrows: false,
    swipeToSlide: true,
    draggable: true,
    responsive: [{
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 360,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });
})
