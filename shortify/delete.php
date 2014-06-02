<?php
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }
  if(!Session::isLoggedIn()) { die(header("Location: /login")); } 

  if(isset($_POST['id'])) {
    $kill_it_with_fire = $_POST['id'];
    $about_me = Session::getUserData($_COOKIE["session"]);
    $find_out_more = $connection->prepare("SELECT * FROM main WHERE short = :sluggish AND user = :user_id LIMIT 1");
    $find_out_more->execute(array(":sluggish" => $kill_it_with_fire, ":user_id" => $about_me['id']));
    if($find_out_more->rowCount() > 0) {
      while($row = $find_out_more->fetch()) {
        if($row['isURL'] == 2) { 
          unlink($row['notshort']);
        }
        $killll = $connection->prepare("DELETE FROM main WHERE short = :sluggish");
        $killll->execute(array(":sluggish" => $kill_it_with_fire));
      }
    }
  }

  header("Location: " . $_SERVER['HTTP_REFERER']);