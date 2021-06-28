<?php

namespace app\models;

use Yii;

class Poster extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'poster';
    }

    public static function getById($id){
      $poster = Poster::findOne(['id' => $id]);

      return $poster ? array('success' => true, 'id' => $poster->id, 'name' => $poster->name, 'url' => $poster->url) : array('success' => false);
    }
    public static function getPosterUrl($id){
      $poster = Poster::findOne(['id' => $id]);

      return $poster ? "/uploads/posters/".$poster->url : false;
    }
    public static function getPosters($records = 10, $page = 1, $search = [], $count_only = false){
      $posters = Poster::find();
      if(!$count_only) $posters = $posters->limit($records)->offset(($page - 1) * $records);

      $posters = $posters->all();

      return $count_only ? count($posters) : $posters;
    }

    public static function getTotalCount(){
      $find = Poster::find()->all();
      return $find ? count($find) : 0;
    }

    public static function generateOptionList(){
      $posters = Poster::find()->all();
      $html = "";

      if($posters) foreach ($posters as $v) {
        $html.= "<option ".($v['id'] == $default ? "selected" : "")." value='".$v['id']."'>".$v['name']."</option>";
      }

      return $html;
    }

    public function addPoster($name, $src = false){
      if(!$src || !$name) return false;
      $poster = new Poster;
      $dir = getcwd()."/uploads/posters";

      $orig_name = $name;
      $ext = pathinfo($name, PATHINFO_EXTENSION);
      $new_name = md5(pathinfo($name, PATHINFO_FILENAME).time()).".".$ext;

      list($type, $src) = explode(';', $src);
      list(, $src)      = explode(',', $src);
      $result = file_put_contents($dir."/".$new_name, base64_decode($src));

      $poster->url = $new_name;
      $poster->name = $orig_name;

      return $poster->save() ? array('success' => true, 'id' => $poster->id, 'url' => $poster->url, 'name' => $poster->name) : (unlink($dir."/".$new_name) ? array('success' => false, 'deleted' => true) : array('success' => false, 'deleted' => false));
    }
    public function deletePoster($id){
      if(!$id) return false;
      $poster = Poster::getById($id);
      if(!$poster) return array('success' => false, 'message' => 'Nie znaleziono plakatu o wskazanym ID');

      $dir = getcwd()."/uploads/posters";

      $deleted = file_exists($dir."/".$poster['url']) ? unlink($dir."/".$poster['url']) : true;
      return $deleted && Poster::deleteAll(['id' => $id]) ? array('success' => true, 'id' => $id) : array('success' => false);
    }

}
