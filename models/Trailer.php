<?php namespace app\models;
      use Yii;
      use app\models\Tools;

class Trailer extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'trailer';
    }
    public static function getById($id){
      if(!$id) return false;
      $trailer = Trailer::findOne(['id' => $id]);

      return $trailer ? $trailer : false;
    }
    public static function getMovieTrailers($id){
      $trailers = Trailer::find()->where(['status' => 1])->andWhere(['id_movie' => $id])->orderBy(['premiere_date' => SORT_DESC]);

      if(!$count_only) $trailers = $trailers->limit($records)->offset(($page - 1) * $records);
      $trailers = $trailers->all();

      return $trailers;
    }

    public static function addTrailer($d = array()){
      $trailer = new Trailer;
      $fatal = false;
      $errors = [];

      $v = Tools::validate($d['title'], 'name', 2);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['title'] = "Podany tytuł jest nieprawidłowy";
      }
      $trailer->title = $d['title'];

      $v = Tools::validate($d['premiere_date'], 'date');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['premiere_date'] = "Podana data premiery jest nieprawidłowa";
      }
      $trailer->premiere_date = $d['premiere_date'];

      $trailer->description = $d['description'];
      $trailer->id_movie = $d['id_movie'];
      $trailer->source = $d['source'];
      $trailer->status = 1;


      return !$fatal && $trailer->save() ? array('succes' => true, 'redirect' => '/movie/details?id='.$d['id_movie']) : array('success' => false, 'errors' => $errors);
    }

    public static function deleteTrailer($id){
      $trailer = Trailer::getById($id);
      if(!$trailer) return array('success' => false, 'message' => 'Nie znaleziono trailera o wskazanym ID');

      $fatal = false;
      $errors = [];

      $trailer->status = 0;

      return !$fatal && $trailer->save() ? array('success' => true, 'id' => $trailer->id) : array('success' => false, 'errors' => $errors);
    }
}
