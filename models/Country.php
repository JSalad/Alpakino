<?php namespace app\models;
      use Yii;

class Country extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'country';
    }

    public static function getNameById($id){
      if(!$id) return NULL;

      return Country::findOne(['id' => $id])->name;
    }

    public static function getById($id){
      if(!$id) return NULL;

      return Country::findOne(['id' => $id]);
    }

    public static function generateOptionList($default = 172){
      $genres = Country::find()->all();
      $html = "";

      if($genres) foreach ($genres as $v) {
        $html.= "<option ".($v['id'] == $default ? "selected" : "")." value='".$v['id']."'>".$v['name']."</option>";
      }

      return $html;
    }

}
