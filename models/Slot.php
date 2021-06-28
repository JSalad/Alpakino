<?php namespace app\models;
      use Yii;

class Slot extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'slot';
    }
    public static function getById($id){
      if(!$id) return false;
      $slot = Slot::findOne(['id' => $id]);

      return $slot ? $slot : false;
    }
    public static function addSlot($id_hall = -1, $type = "none", $row = 1, $col = 1){
      if($id_hall < 0) return array('success' => false);
      if($type == "none") return array('success' => false);

      $slot = new Slot;
      $slot->id_hall = $id_hall;
      $slot->type = $type;
      $slot->pos_x = $row;
      $slot->pos_y = $col;

      return $slot->save() ? array('success' => true, 'id' => $slot->id) : array('success' => false);
    }
    public static function deleteSlot($id){
      return Slot::deleteAll(['id' => $id]) ? array('success' => true) : array('success' => false);
    }

    public static function calculateSeatsForHall($id){
      $total = Slot::find()->where(['id_hall' => $id])->andWhere(['!=', 'type', 'screen'])->all();

      return $total ? count($total) : 0;
    }
    public static function getSlotAtPosition($id_hall = 0, $row = 0, $col = 0){
      $slot = Slot::find()->where(['id_hall' => $id_hall])->andWhere(['pos_x' => $row])->andWhere(['pos_y' => $col])->one();

      return $slot;
    }

}
