function deleteUser($id){
  $.ajax({
    url: "/admin/delete",
    data: {'id': $id},
    type: "POST",
  }).done(function($data){
    $data = JSON.parse($data);
    if($data && $data.success == true){
      $("tr[admin-id='"+$data.id+"']").fadeOut(300, function(){
        $("tr[admin-id='"+$data.id+"']").remove();
      });
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
      $("tr[review-id='"+$data.id+"']").fadeOut();
      $.notify({'message' : 'Recenzja została usunięta'});
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
