<?php namespace app\models;
      use Yii;
      use app\models\Seance;


class Hall extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'hall';
    }

    public static function getById($id){
      if(!$id) return NULL;

      return Hall::findOne(['id' => $id]);
    }
    public static function getNameById($id){
      if(!$id) return NULL;
      $d = Hall::findOne(['id' => $id]);
      return $d->name;
    }
    public static function getHalls($records = 10, $page = 1, $search = [], $count_only = false){
      $halls = Hall::find()->where(['status' => 1])->orderBy(['name' => SORT_ASC]);

      if(!$count_only) $halls = $halls->limit($records)->offset(($page - 1) * $records);
      $halls = $halls->all();

      return $count_only ? count($halls) : $halls;
    }

    public static function getTotalCount(){
      $find = Hall::find()->where(['status' => 1])->all();
      return $find ? count($find) : 0;
    }
    
    public static function isFree($id, $id_movie, $datetime, $exclude = []){
      if(!$id) return false;
      if(!$datetime) return false;

      $movie = Movie::getById($id_movie);
      $datetime_start = date("Y-m-d H:i", strtotime($datetime));
      $datetime_end = date("Y-m-d H:i", strtotime($datetime." + ".$movie->duration." minute"));

      $seances = Seance::getSeancesForHall($id);
      if($seances) {
        $free = true;
        foreach ($seances as $s) {
          if(!in_array($s->id, $exclude)){
            $movie = Movie::getById($s->id_movie);
            $s_start = date("Y-m-d H:i", strtotime($s->show_date));
            $s_end = date("Y-m-d H:i", strtotime($s->show_date." + ".$movie->duration." minute"));

            if($datetime_start >= $s_start && $datetime_start <= $s_end) $free = false;
            if($datetime_end >= $s_start && $datetime_end <= $s_end) $free = false;
          }
        }

        return $free;
      }

      return true;
    }

    public static function generateOptionList($default = 172){
      $halls = Hall::find()->where(['status' => 1])->all();
      $html = "";

      if($halls) foreach ($halls as $v) {
        $html.= "<option ".($v['id'] == $default ? "selected" : "")." value='".$v['id']."'>".$v['name']."</option>";
      }

      return $html;
    }
    public static function addHall($d){
      $falal = false;
      $erros = [];

      $hall = new Hall;

      $hall->name = $d['name'];
      $v = Tools::validate($d['name'], 'name', 2);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['name'] = "Podany tytuł jest nieprawidłowy";
      }

      $hall->description = $d['description'];

      $hall->size_x = $d['size_x'];
      $hall->size_y = $d['size_y'];

      return !$fatal && $hall->save() ? array('success' => true, 'hall' => $hall, 'redirect' => "/hall/index") : array('success' => false, 'errors' => $errors);
    }
    public static function deleteHall($id){
      $hall = Hall::getById($id);
      if(!$hall) return array('success' => false, 'message' => 'Nie znaleziono sali o wskazanym ID');

      $fatal = false;
      $errors = [];

      $hall->status = 0;

      return !$fatal && $hall->save() ? array('success' => true, 'id' => $hall->id) : array('success' => false, 'errors' => $errors);

    }

}
