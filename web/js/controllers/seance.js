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

function resizeMobileSeancesToPosterSize(){
  $(".seances-vertical").each(function(i, e){
    $e = $(e);
    $p = $e.prev();
    $e.css("max-height", $p.height()+"px");

  })
}

$(window).resize(function(){
  resizeMobileSeancesToPosterSize();
});

$(document).ready(function(){
  setTimeout(function(){
    resizeMobileSeancesToPosterSize();
  }, 1500);
})
