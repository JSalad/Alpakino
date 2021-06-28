<?php namespace app\models;
      use Yii;

class BookingSeat extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'booking_seat';
    }
    public static function getById($id){
      if(!$id) return NULL;

      return BookingSeat::findOne(['id' => $id]);
    }
    public static function getByBooking($id){
      if(!$id) return NULL;

      return BookingSeat::find()->andWhere(['id_booking' => $id])->all();
    }
    public static function addBookingSeat($id_booking, $id_seance, $id_seat){
      // id	id_booking	id_seance	id_seat
      $seat = new BookingSeat;

      $seat->id_booking = $id_booking;
      $seat->id_seance = $id_seance;
      $seat->id_seat = $id_seat;


      return $seat->save() ? array('success' => true) : array('success' => false);
    }

    public static function isFreeSeat($id_seance, $id_seat){
      if(!$id_seance) return false;
      if(!$id_seat) return false;

      $free = BookingSeat::findOne(['id_seance' => $id_seance, 'id_seat' => $id_seat]) ? true : false;

      return $free;
    }
    public static function deleteSeatsForBooking($id_booking){
      return BookingSeat::deleteAll(['id_booking' => $id_booking]);
    }


}
