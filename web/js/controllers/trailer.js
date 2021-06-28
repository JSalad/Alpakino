function loadVideo(){
  $video_code = $("#source").val();

  $video_code = $video_code.includes("youtu.be") ? $video_code.split("/")[3] : $video_code;
  $("#source").val($video_code);

  $poster = "https://img.youtube.com/vi/"+$video_code+"/0.jpg";
  $source = "https://www.youtube.com/embed/"+$video_code;

  $("#source_poster").attr("src", $poster);
  $("#source_frame").attr("src", $source);
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
