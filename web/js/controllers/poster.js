function deletePoster($id){
  $.ajax({
    url: "/poster/delete",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    console.log($data);
    if($data && $data.success == true){
      $("tr[poster-id='"+$data.id+"']").fadeOut(300, function(){
        $("tr[poster-id='"+$data.id+"']").remove();
      });
    }
  }).fail(function($r){
    d($r.responseText);
  });
}
