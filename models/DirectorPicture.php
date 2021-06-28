<?php

namespace app\models;

use Yii;

class DirectorPicture extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'director_picture';
    }

    public static function getById($id){
      $picture = DirectorPicture::findOne(['id' => $id]);

      return $picture ? array('success' => true, 'id' => $picture->id, 'name' => $picture->name, 'url' => $picture->url) : array('success' => false);
    }
    public static function getPictureUrl($id){
      $picture = DirectorPicture::findOne(['id' => $id]);

      return $picture ? "/uploads/directors/".$picture->url : "/images/avatar.png";
    }

    public static function generateOptionList(){
      $pictures = DirectorPicture::find()->all();
      $html = "";

      if($pictures) foreach ($pictures as $v) {
        $html.= "<option ".($v['id'] == $default ? "selected" : "")." value='".$v['id']."'>".$v['name']."</option>";
      }

      return $html;
    }

    public function addDirectorPicture($name, $src = false){
      if(!$src || !$name) return false;
      $picture = new DirectorPicture;
      $dir = getcwd()."/uploads/directors";

      $orig_name = $name;
      $ext = pathinfo($name, PATHINFO_EXTENSION);
      $new_name = md5(pathinfo($name, PATHINFO_FILENAME).time()).".".$ext;

      list($type, $src) = explode(';', $src);
      list(, $src)      = explode(',', $src);
      $result = file_put_contents($dir."/".$new_name, base64_decode($src));

      $picture->url = $new_name;
      $picture->name = $orig_name;

      return $picture->save() ? array('success' => true, 'id' => $picture->id, 'url' => $picture->url, 'name' => $picture->name) : (unlink($dir."/".$new_name) ? array('success' => false, 'deleted' => true) : array('success' => false, 'deleted' => false));
    }
    public function deleteDirectorPicture($id){
      if(!$id) return false;
      $picture = DirectorPicture::getById($id);
      if(!$picture) return array('success' => false, 'message' => 'Nie znaleziono plakatu o wskazanym ID');

      $dir = getcwd()."/uploads/posters";

      $deleted = file_exists($dir."/".$picture['url']) ? unlink($dir."/".$picture['url']) : true;
      return $deleted && DirectorPicture::deleteAll(['id' => $id]) ? array('success' => true, 'id' => $id) : array('success' => false);
    }

}
