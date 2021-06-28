<?php namespace app\models;
      use Yii;
      use app\models\Tools;

class Booking extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'booking';
    }

    public static function getById($id){
      if(!$id) return NULL;

      return Booking::findOne(['id' => $id]);
    }

    public static function getByParameters($params){
      $b = Booking::find();
      if($params) foreach ($params as $k => $v) {
        $b->andWhere([$k => $v]);
      }

      return $b->one();
    }


    public static function addBooking($id_seance, $d){
      $booking = new Booking;

      $booking->id_seance = $id_seance;
      $booking->first_name = $d['first_name'];
      $booking->last_name = $d['last_name'];
      $booking->email = $d['email'];
      $booking->booking_date = date("Y-m-d H:i:s");
      $booking->payment_hash = Tools::generateRandomString(32);
      $booking->access_token = Tools::generateRandomString(32);
      $booking->ip_address = $_SERVER['REMOTE_ADDR'];



      return $booking->save() ? array('success' => true, 'id' => $booking->id) : array('success' => false);
    }

    public static function deleteBooking($id_booking){
      return Booking::deleteAll(['id' => $id_booking, 'payment_status' => 1]);
    }

    public static function markAsPaid($id_booking){
      $booking = Booking::getById($id_booking);

      $booking->payment_status = 2;
      return $booking->save();
    }
}
