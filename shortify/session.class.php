<?php

/**
 * Session managing class
 *
 * @author Grey Hargreaves
 * @copyright 2014 Grey Hargreaves
 */

class Session {
  
  public function __construct() { }

  // Simple logged in check
  public static function isLoggedIn() {
    if(isset($_COOKIE["session"])) {
      return true;
    }
    else {
      return false;
    }
  }

  // Log me in
  public static function logIn($username, $password, $remember = false) {
    global $connection;
    $query = $connection->prepare("SELECT * FROM users WHERE username = :username AND password = :password"); 
    $query->execute(array(":username" => $username, ":password" => self::encryptPassword($password)));
    if($query->rowCount() == 1) {
      $session_id = self::generateSessionID($username);
      $query = $connection->prepare("UPDATE users SET session_id = :session_id WHERE username = :username"); 
      $query->execute(array("session_id" => $session_id, "username" => $username));
      $expire = ($remember === false) ? 0 : time()+60*60*24*365; // 1 year
      setcookie("session", $session_id, $expire, "/", preg_replace('#^https?://#', '', ROOT));
      return true;
    } 
    else {
      return false;
    }
  }

  // Log me out
  public static function logOut() {
    if(self::isLoggedIn()) {
      setcookie("session", "", time()-3600, "/", preg_replace('#^https?://#', '', ROOT));
      return true;
    }
    else {
      return false;
    }
  } 

  // Creates unique session IDs
  private static function generateSessionID($identifier) {
    return md5($identifier . time());
  }

  // Returns user data based on session ID
  public static function getUserData($session_id) {
    global $connection;
    $query = $connection->prepare("SELECT * FROM users WHERE session_id = :session_id LIMIT 1"); 
    $query->execute(array(":session_id" => $session_id));
    if($query->rowCount() > 0) {
      $results = $query->fetch();
      return $results;
    }
    else {
      return false;
    }
  }

  public static function encryptPassword($string) {
    if(!empty($string)) {
      return sha1(md5(crypt($string, PASSWORD_SALT)));
    }
    else {
      return false;
    }
  }

}

