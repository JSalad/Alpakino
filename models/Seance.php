<?php namespace app\models;
      use Yii;
      use app\models\Movie;

class Seance extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'seance';
    }
    public static function getById($id){
      if(!$id) return NULL;

      return Seance::findOne(['id' => $id]);
    }
    public static function getSeances($records = 10, $page = 1, $search = [], $count_only = false){
      $seance = Seance::find()->where(['status' => 1])->andWhere(['>=', 'show_date', date("Y-m-d 00:00:00")])->groupBy(['id_movie'])->orderBy(['show_date' => SORT_ASC]);

      if(!$count_only) $seance = $seance->limit($records)->offset(($page - 1) * $records);
      $seance = $seance->all();


      return $count_only ? count($seance) : $seance;
    }
    public static function getSeancesForMovie($id){
      $seance = Seance::find()->where(['status' => 1])->andWhere(['>=', 'show_date', date("Y-m-d 00:00:00")])->andWhere(['id_movie' => $id])->orderBy(['show_date' => SORT_ASC])->limit($records)->all();

      return $seance;
    }
    public static function getSeancesForHall($id){
      $seance = Seance::find()->where(['status' => 1])->andWhere(['id_hall' => $id])->orderBy(['show_date' => SORT_ASC])->all();

      return $seance;
    }

    public static function getTotalCount(){
      $find = Seance::find()->where(['status' => 1])->all();
      return $find ? count($find) : 0;
    }

    public static function addSeance($d = array()){
      $seance = new Seance;
      $fatal = false;
      $errors = [];



      $v = Tools::validate($d['id_movie'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['name'] = "Podany film jest nieprawidłowy";
      }
      $seance->id_movie = $d['id_movie'];

      $v = Tools::validate($d['show_date_time'], 'time');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['show_date_time'] = "Podana godzina seansu jest nieprawidłowa";
      }
      $v = Tools::validate($d['show_date_date'], 'date');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['show_date_date'] = "Podana data seansu jest nieprawidłowa";
      }

      $seance->show_date = date("Y-m-d H:i", strtotime($d['show_date_date']." ".$d['show_date_time']));
      if($seance->show_date <= date("Y-m-d H:i")){
        $fatal = true;
        $errors['show_date_time'] = "Podana godzina seansu jest nieprawidłowa - nie można ustalać premier na minione dni.";
        $errors['show_date_date'] = "Podana data seansu jest nieprawidłowa - nie można ustalać premier na minione dni.";
      }

      $movie = Movie::getById($seance->id_movie);
      if(date("Y-m-d", strtotime($movie->premiere_date)) > date("Y-m-d", strtotime($seance->show_date))){
        $fatal = true;
        $errors['show_date_time'] = "Podana godzina seansu jest nieprawidłowa - przed premierą filmu";
        $errors['show_date_date'] = "Podana data seansu jest nieprawidłowa - przed premierą filmu";
      }

      $v = Tools::validate($d['projection_type'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['birth_date'] = "Rodzaj filmu jest nieprawidłowy";
      }

      $v = Tools::validate($d['id_hall'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['id_hall'] = "Podana sala jest nieprawidłowa";
      }

      $free = Hall::isFree($d['id_hall'], $d['id_movie'], $seance->show_date);
      if(!$free){
        $fatal = true;
        $errors['id_hall'] = "Podana sala jest już zajęta w czasie trwania wybranego filmu.";
      }

      $seance->id_hall = $d['id_hall'];


      $seance->projection_type = $d['projection_type'];

      $seance->price_standard = $d['price_standard'];
      $seance->price_vip = $d['price_vip'];


      return !$fatal && $seance->save() ? array('success' => true, 'redirect' => '/seance/index') : array('success' => false, 'errors' => $errors);
    }
    public static function updateSeance($id, $d = array()){
      $seance = Seance::getById($id);
      $fatal = false;
      $errors = [];

      $v = Tools::validate($d['id_movie'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['name'] = "Podany film jest nieprawidłowy";
      }
      $seance->id_movie = $d['id_movie'];

      $v = Tools::validate($d['show_date_time'], 'time');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['show_date_time'] = "Podana godzina seansu jest nieprawidłowa";
      }
      $v = Tools::validate($d['show_date_date'], 'date');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['show_date_date'] = "Podana data seansu jest nieprawidłowa";
      }

      $seance->show_date = date("Y-m-d H:i", strtotime($d['show_date_date']." ".$d['show_date_time']));
      if($seance->show_date <= date("Y-m-d H:i")){
        $fatal = true;
        $errors['show_date_time'] = "Podana godzina seansu jest nieprawidłowa - nie można ustalać premier na minione dni.";
        $errors['show_date_date'] = "Podana data seansu jest nieprawidłowa - nie można ustalać premier na minione dni.";
      }

      $movie = Movie::getById($seance->id_movie);
      if(date("Y-m-d", strtotime($movie->premiere_date)) > date("Y-m-d", strtotime($seance->show_date))){
        $fatal = true;
        $errors['show_date_time'] = "Podana godzina seansu jest nieprawidłowa - przed premierą filmu";
        $errors['show_date_date'] = "Podana data seansu jest nieprawidłowa - przed premierą filmu";
      }

      $free = Hall::isFree($d['id_hall'], $d['id_movie'], $seance->show_date, array((int)$id));
      if(!$free){
        $fatal = true;
        $errors['id_hall'] = "Podana sala jest już zajęta w czasie trwania wybranego filmu.";
      }


      $v = Tools::validate($d['projection_type'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['projection_type'] = "Rodzaj filmu jest nieprawidłowy";
      }

      $v = Tools::validate($d['id_hall'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['id_hall'] = "Podana sala jest nieprawidłowa";
      }


      $seance->id_hall = $d['id_hall'];
      $seance->projection_type = $d['projection_type'];
      $seance->price_standard = $d['price_standard'];
      $seance->price_vip = $d['price_vip'];

      return !$fatal && $seance->save() ? array('success' => true, 'redirect' => '/seance/index') : array('success' => false, 'errors' => $errors);
    }
    public static function deleteSeance($id){
      $seance = Seance::getById($id);
      if(!$seance) return array('success' => false, 'message' => 'Nie znaleziono seansu o wskazanym ID');

      $fatal = false;
      $errors = [];

      $seance->status = 0;

      return !$fatal && $seance->save() ? array('success' => true, 'id' => $seance->id) : array('success' => false, 'errors' => $errors);
    }

}
