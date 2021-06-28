<?php namespace app\models;
      use Yii;

class Rating extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'rating';
    }

    public static function getAverageForMovie($id){
      $rating = Rating::find()->where(['id_movie' => $id])->average('value');

      return $rating ? $rating : 5;
    }
    public static function getUserRatingForMovie($id, $ip = false){
      $rating = Rating::find()->where(['id_movie' => $id]);

      if($ip){
        $rating = $rating->andWhere(['ip_address' => $ip]);
      } else {
        $rating = $rating->andWhere(['ip_address' => $_SERVER['REMOTE_ADDR']]);
      }

      $rating = $rating->one();

      return $rating ? $rating : false;
    }

    public static function addRating($id, $value){
      $rating = new Rating;

      $rating->id_movie = $id;
      $rating->value = $value;
      $rating->ip_address = $_SERVER['REMOTE_ADDR'];


      return !$fatal && $rating->save() ? array('success' => true) : array('success' => false, 'errors' => $errors);
    }
    public static function updateRating($id, $value){
      $rating = Rating::getUserRatingForMovie($id);

      $rating->value = $value;

      return !$fatal && $rating->save() ? array('success' => true) : array('success' => false, 'errors' => $errors);
    }

}
