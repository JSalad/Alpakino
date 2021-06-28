<?php namespace app\models;
      use Yii;

class Genre extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'genre';
    }

    public static function getNameById($id){
      if(!$id) return NULL;

      return Genre::findOne(['id' => $id])->name;
    }

    public static function getTotalCount(){
      $find = Genre::find()->all();
      return $find ? count($find) : 0;
    }

    public static function generateOptionList($default = 1){
      $genres = Genre::find()->all();
      $html = "";

      if($genres) foreach ($genres as $v) {
        $html.= "<option ".($v['id'] == $default ? "selected" : "")." value='".$v['id']."'>".$v['name']."</option>";
      }

      return $html;
    }

}
