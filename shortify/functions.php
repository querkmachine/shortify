<?php
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }

  require 'session.class.php';

  function validateSlug($slimy_slug = false) {
    global $connection;
    do {
      $check_yourself = $connection->prepare("SELECT COUNT(*) FROM main WHERE short = :short");
      $check_yourself->execute(array(":short" => $slimy_slug));
      if($check_yourself->fetchColumn() > 0 || hasPrivilege($slimy_slug) == true || !preg_match('/^([a-z0-9-\+]+)\b/i', $slimy_slug)) {
        $special_snowflake = false;
        $slimy_slug = generateNewSlug();
      }
      else {
        $special_snowflake = true;
        return $slimy_slug;
      }
    } while(!$special_snowflake);
  }

  function generateNewSlug($length = URL_LENGTH) {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-+";
    $new_slug = '';
    while(strlen($new_slug) < $length) {
      $new_slug .= substr($characters, rand(0, strlen($characters) - 1), 1);
    }
    return $new_slug;
  }

  function hasPrivilege($check_your_privilege) {
    $has_privilege = array('', 'add', 'upload', 'list', 'shortify');
    if(in_array(strtolower($check_your_privilege), $has_privilege)) { return true; }
    else { return false; }
  }