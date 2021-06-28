<?php namespace app\models;
      use Yii;
      use yii\db\Expression;

class Movie extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'movie';
    }

    public static function getById($id){
      if(!$id) return false;
      $movie = Movie::findOne(['id' => $id]);

      return $movie ? $movie : false;
    }
    public static function getNameById($id){
      if(!$id) return false;
      $movie = Movie::findOne(['id' => $id]);

      return $movie ? $movie->title : false;
    }
    public static function getMovies($records = 10, $page = 1, $search = [], $count_only = false){
      $movies = Movie::find()->where(['status' => 1])->orderBy(['premiere_date' => SORT_DESC]);

      if(!$count_only) $movies = $movies->limit($records)->offset(($page - 1) * $records);
      $movies = $movies->all();
      return $count_only ? count($movies) : $movies;
    }
    public static function getTotalCount(){
      $find = Movie::find()->where(['status' => 1])->all();
      return $find ? count($find) : 0;
    }
    public static function getByDirectorId($id){
      $movies = Movie::find()->where(['status' => 1])->andWhere(['director' => $id])->orderBy(['premiere_date' => SORT_DESC]);
      $movies = $movies->all();
      return $count_only ? count($movies) : $movies;
    }
    public static function getByGenreId($records = 5){
      $movies = Movie::find()->where(['status' => 1])->orderBy(['premiere_date' => SORT_DESC])->limit($records)->all();
      return $movies;
    }
    public static function getRandomMovies($records = 5){
      $movies = Movie::find()->where(['status' => 1])->orderBy(new Expression('rand()'))->limit($records)->all();
      return $movies;
    }

    public static function generateOptionList($default = 172){
      $movies = Movie::find()->where(['status' => 1])->all();
      $html = "";
      if($movies) foreach ($movies as $v) $html.= "<option ".($v['id'] == $default ? "selected" : "")." value='".$v['id']."'>".$v['title']."</option>";
      return $html;
    }
    public static function generateTypesOptionList($default = 1){
      $types = array(1 => "Film 2D, Lektor", 2 => "Film 2D, Napisy", 3 => "Film 2D, Dubbing", 4 => "Film 3D, Lektor", 5 => "Film 3D, Napisy", 6 => "Film 3D, Dubbing");
      $html = "";
      if($types) foreach ($types as $id => $t) $html.= "<option ".($id == $default ? "selected" : "")." value='".$id."'>".$t."</option>";
      return $html;
    }

    public static function getType($id){
      $types = array(1 => "Film 2D, Lektor", 2 => "Film 2D, Napisy", 3 => "Film 2D, Dubbing", 4 => "Film 3D, Lektor", 5 => "Film 3D, Napisy", 6 => "Film 3D, Dubbing");
      return $types[$id];
    }


    public static function addMovie($d = array()){
      $movie = new Movie;
      $fatal = false;
      $errors = [];

      $movie->title = $d['title'];
      $v = Tools::validate($d['title'], 'name', 2);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['title'] = "Podany tytuł jest nieprawidłowy";
      }

      $movie->description = $d['description'];

      $movie->required_age = $d['required_age'];
      $v = Tools::validate($d['required_age'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['required_age'] = "Podany wiek jest nieprawidłowy";
      }

      $movie->premiere_date = $d['premiere_date'];
      $v = Tools::validate($d['premiere_date'], 'date');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['premiere_date'] = "Podana data premiery jest nieprawidłowa";
      }

      $movie->duration = $d['duration'];
      $v = Tools::validate($d['duration'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['duration'] = "Podana długość jest nieprawidłowa";
      }

      $movie->genre = $d['genre'];
      $movie->production_country = $d['production_country'];
      $movie->director = $d['director'];
      $movie->additional_info = $d['additional_info'];


      $movie->poster_url = $d['poster_url'];
      $v = Tools::validate($d['poster_url'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['poster_url'] = "Plakat jest wymagany";
      }


      return !$fatal && $movie->save() ? array('succes' => true, 'redirect' => '/movie/index') : array('success' => false, 'errors' => $errors);
    }
    public static function updateMovie($id, $d = array()){
      $movie = Movie::getById($id);
      if(!$movie) return array('success' => false, 'message' => 'Nie znaleziono filmu o wskazanym ID');

      $fatal = false;
      $errors = [];

      $movie->title = $d['title'];
      $v = Tools::validate($d['title'], 'name', 2);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['title'] = "Podany tytuł jest nieprawidłowy";
      }

      $movie->description = $d['description'];

      $movie->required_age = $d['required_age'];
      $v = Tools::validate($d['required_age'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['required_age'] = "Podany wiek jest nieprawidłowy";
      }

      $movie->premiere_date = $d['premiere_date'];
      $v = Tools::validate($d['premiere_date'], 'date');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['premiere_date'] = "Podana data premiery jest nieprawidłowa";
      }

      $movie->duration = $d['duration'];
      $v = Tools::validate($d['duration'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['duration'] = "Podana długość jest nieprawidłowa";
      }

      $movie->genre = $d['genre'];
      $movie->production_country = $d['production_country'];
      $movie->director = $d['director'];
      $movie->additional_info = $d['additional_info'];


      $movie->poster_url = $d['poster_url'];
      $v = Tools::validate($d['poster_url'], 'number');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['poster_url'] = "Plakat jest wymagany";
      }


      return !$fatal && $movie->save() ? array('succes' => true, 'redirect' => '/movie/details?id='.$movie->id) : array('success' => false, 'errors' => $errors);
    }
    public static function deleteMovie($id){
      $movie = Movie::getById($id);
      if(!$movie) return array('success' => false, 'message' => 'Nie znaleziono filmu o wskazanym ID');

      $fatal = false;
      $errors = [];

      $movie->status = 0;

      return !$fatal && $movie->save() ? array('success' => true, 'id' => $movie->id) : array('success' => false, 'errors' => $errors);
    }
}
