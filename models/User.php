<?php namespace app\models;
      use Yii;
      use app\models\Tools;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface{
    public static function tableName(){
        return 'user';
    }

    public static function findIdentity($id){
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        return static::findOne(['access_token' => $token]);
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){
        return $this->auth_key;
    }

    public function validateAuthKey($authKey){
        return $this->getAuthKey() === $authKey;
    }

    public static function getByEmail($email){
      if(!$email) return NULL;

      $user = User::findOne(['email' => $email]);
      return $user ? $user : NULL;
    }

    public static function getById($id){
      if(!$id) return NULL;

      $user = User::findOne(['id' => $id]);
      return $user ? $user : NULL;
    }

    public function validatePassword($password){
        return $this->password === md5($password);
    }

    public static function getCurrentIdentity(){
      return Yii::$app->user->identity;
    }

    public static function isAdmin(){
      if(!Yii::$app) return false;
      if(!Yii::$app->user) return false;
      if(!Yii::$app->user->identity) return false;

      return true;
    }

    public static function updateLoginDetails(){
      $u = User::getCurrentIdentity();

      $u->date_login = date("Y-m-d H:i:s");
      $u->ip_address = $_SERVER['REMOTE_ADDR'];
      return $u->save();
    }

    public static function getUsers($records = 10, $page = 1, $search = [], $count_only = false){
      $users = User::find();
      if(!$count_only) $users = $users->limit($records)->offset(($page - 1) * $records);

      $users = $users->all();

      return $count_only ? count($users) : $users;
    }

    public static function createUser($d){
      $u = new User;
      $fatal = false;
      $errors = [];


      if(User::getByEmail($d['email'])){
        $fatal = true;
        $errors['email'] = "Na podany email zostało już założone konto";
      }

      $test = Tools::validate($d['email'], 'email');
      if($test['status'] != "success"){
        $fatal = true;
        $errors['email'] = "Podany adres e-mail nie wydaje się być poprawnym adresem";
      }

      $test = Tools::validate($d['first_name'], 'first_name');
      if($test['status'] != "success"){
        $fatal = true;
        $errors['first_name'] = "Podane imię nie jest prawidłowe";
      }

      $test = Tools::validate($d['last_name'], 'last_name');
      if($test['status'] != "success"){
        $fatal = true;
        $errors['last_name'] = "Podane nazwisko nie jest prawidłowe";
      }

      $test = Tools::validate($d['password'], 'password', 8);
      if($test['status'] != "success"){
        $fatal = true;
        $errors['password'] = "Podane hasło musi składać się z minimum jednej wielkiej litery, cyfry, znaku specjalnego i łącznej długości minimum 8 znaków";
      }

      if($d['repeat-password'] == "" || $d['password'] != $d['repeat-password']){
        $fatal = true;
        $errors['repeat-password'] = "Hasła, które zostały podane są różne od siebie";
      }

      $u->email = $d['email'];
      $u->password = md5($d['password']);
      $u->first_name = $d['first_name'];
      $u->last_name = $d['last_name'];
      $u->access_token = Tools::generateRandomString(32);
      $u->auth_key = Tools::generateRandomString(32);

      return !$fatal && $u->save() ? array('success' => true, 'redirect' => "/admin/index") : array('success' => false, 'errors' => $errors);
    }

    public static function deleteUser($id){
      $user = User::getById($id);
      if(!$user) return false;

      return User::deleteAll(['id' => $id]);
    }
}
