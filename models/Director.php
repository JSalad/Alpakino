<?php

namespace app\models;

use Yii;

class Director extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'director';
    }

    public static function getById($id){
      if(!$id) return NULL;

      return Director::findOne(['id' => $id]);
    }
    public static function getNameById($id){
      if(!$id) return NULL;
      $d = Director::findOne(['id' => $id]);
      return $d->name;
    }
    public static function getDirectors($records = 10, $page = 1, $search = [], $count_only = false){
      $directors = Director::find()->where(['status' => 1])->orderBy(['name' => SORT_ASC]);

      if(!$count_only) $directors = $directors->limit($records)->offset(($page - 1) * $records);
      $directors = $directors->all();


      return $count_only ? count($directors) : $directors;
    }

    public static function getTotalCount(){
      $find = Director::find()->where(['status' => 1])->all();
      return $find ? count($find) : 0;
    }

    public static function generateOptionList($default = 172){
      $genres = Director::find()->where(['status' => 1])->all();
      $html = "";

      if($genres) foreach ($genres as $v) {
        $html.= "<option ".($v['id'] == $default ? "selected" : "")." value='".$v['id']."'>".$v['name']."</option>";
      }

      return $html;
    }

    public static function addDirector($d = array()){
      $director = new Director;
      $fatal = false;
      $errors = [];

      $first_name = explode(" ", $d['name'])[0];
      $last_name = explode(" ", $d['name'])[1];

      $v = Tools::validate($first_name, 'first_name', 2);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['name'] = "Podane imię i nazwisko jest nieprawidłowe";
      }

      $v = Tools::validate($last_name, 'first_name', 2);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['name'] = "Podane nazwisko i nazwisko jest nieprawidłowe";
      }

      $director->name = $first_name." ".$last_name;

      $director->birth_place = $d['birth_place'];
      $v = Tools::validate($d['birth_place'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['birth_place'] = "Podane miejsce urodzenia jest nieprawidłowe";
      }

      $director->birth_date = $d['birth_date'];
      $v = Tools::validate($d['birth_date'], 'date');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['birth_date'] = "Podana data urodzenia jest nieprawidłowa";
      }

      $director->description = $d['description'];
      $director->picture = $d['picture'];


      return !$fatal && $director->save() ? array('succes' => true, 'redirect' => '/director/details?id='.$director->id) : array('success' => false, 'errors' => $errors);
    }
    public static function updateDirector($id, $d = array()){
      $director = Director::getById($id);
      if(!$director) return array('success' => false, 'message' => 'Nie znaleziono reżysera o wskazanym ID');

      $fatal = false;
      $errors = [];

      $first_name = explode(" ", $d['name'])[0];
      $last_name = explode(" ", $d['name'])[1];

      $v = Tools::validate($first_name, 'first_name', 2);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['name'] = "Podane imię i nazwisko jest nieprawidłowe";
      }

      $v = Tools::validate($last_name, 'first_name', 2);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['name'] = "Podane nazwisko i nazwisko jest nieprawidłowe";
      }

      $director->name = $first_name." ".$last_name;

      $director->birth_place = $d['birth_place'];
      $v = Tools::validate($d['birth_place'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['birth_place'] = "Podane miejsce urodzenia jest nieprawidłowe";
      }

      $director->birth_date = $d['birth_date'];
      $v = Tools::validate($d['birth_date'], 'date');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['birth_date'] = "Podana data urodzenia jest nieprawidłowa";
      }

      $director->description = $d['description'];
      $director->picture = $d['picture'];


      return !$fatal && $director->save() ? array('succes' => true, 'redirect' => '/director/details?id='.$director->id) : array('success' => false, 'errors' => $errors);
    }
    public static function deleteDirector($id){
      $director = Director::getById($id);
      if(!$director) return array('success' => false, 'message' => 'Nie znaleziono reżysera o wskazanym ID');

      $fatal = false;
      $errors = [];

      $director->status = 0;

      return !$fatal && $director->save() ? array('success' => true, 'id' => $director->id) : array('success' => false, 'errors' => $errors);
    }

}
