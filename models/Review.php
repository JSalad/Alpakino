<?php

namespace app\models;

use Yii;
use app\models\Tools;
use app\models\Recaptcha;

class Review extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'review';
    }

    public static function getById($id){
      if(!$id) return false;
      $review = Review::findOne(['id' => $id]);

      return $review ? $review : false;
    }

    public static function getTotalCount(){
      $find = Review::find()->where(['status' => 1])->all();
      return $find ? count($find) : 0;
    }

    public static function getReportedReviews($records = 99, $page = 1, $search = ['reported' => 1], $count_only = false){
      $reviews = Review::find()->where(['status' => 1])->orderBy(['date_created' => SORT_DESC]);

      if($search) foreach ($search as $k => $v) {
        $reviews = $reviews->andWhere(['=', $k, $v]);
      }

      if(!$count_only) $reviews = $reviews->limit($records)->offset(($page - 1) * $records);
      $reviews = $reviews->all();
      return $count_only ? count($reviews) : $reviews;
    }
    public static function getReviews($records = 10, $page = 1, $search = [], $count_only = false){
      $reviews = Review::find()->where(['status' => 1])->orderBy(['date_created' => SORT_DESC]);

      if($search) foreach ($search as $k => $v) {
        $reviews = $reviews->andWhere(['=', $k, $v]);
      }

      if(!$count_only) $reviews = $reviews->limit($records)->offset(($page - 1) * $records);
      $reviews = $reviews->all();
      return $count_only ? count($reviews) : $reviews;
    }

    public static function createReview($d){
      $review = new Review;

      $fatal = false;
      $errors = [];

      $v = Tools::validate($d['first_name'], 'name', 3);
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['first_name'] = "Podany pseudonim jest nieprawidłowy";
      }

      $v = Tools::validate($d['email'], 'email');
      if($v['status'] == "failed"){
        $fatal = true;
        $errors['email'] = "Podany email jest nieprawidłowy";
      }

      if(strlen($d['content']) < 10){
        $fatal = true;
        $errors['content'] = "Podany wiadomość jest nieprawidłowa";
      }

      $recaptcha = Recaptcha::validate($d['recaptcha']);
      $errors['r'] = $recaptcha;
      if(!$recaptcha){
        $fatal = true;
        $errors['recaptcha'] = "Weryfikacja bezpieczeństwa jest wymagana";
      }

      $review->id_movie = $d['id_movie'];
      $review->name = $d['first_name'];
      $review->email = $d['email'];
      $review->content = Tools::sanitize($d['content']);
      $review->ip_address = $_SERVER['REMOTE_ADDR'];

      return !$fatal && $review->save() ? array('success' => true, 'reload' => true) : array('success' => false, 'errors' => $errors);
    }

    public static function deleteReview($id){
      $review = Review::getById($id);
      if(!$review) return array('success' => false);

      $review->status = 0;
      $review->reported = 0;
      return $review->save() ? array('success' => true, 'id' => $review->id) : array('success' => false);
    }
    public static function reportReview($id){
      $review = Review::getById($id);
      if(!$review) return array('success' => false);

      $review->reported = 1;
      return $review->save() ? array('success' => true) : array('success' => false);
    }
    public static function approveReview($id){
      $review = Review::getById($id);
      if(!$review) return array('success' => false);

      $review->reported = 0;
      return $review->save() ? array('success' => true, 'id' => $review->id) : array('success' => false);
    }
}
