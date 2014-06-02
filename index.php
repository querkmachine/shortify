<?php
  define('TOTES_VALID_LOADING_HERE', true);

  require('shortify/config.php');
  require('shortify/functions.php');

  $query = str_replace('/', '', $_SERVER['REQUEST_URI']);

  switch($query) {
    case false:
      die("no url");
      break;
    case 'login':
      require('shortify/user.php');
      break;
    case 'add':
      require('shortify/add.php');
      break;
    case 'upload':
      require('shortify/upload.php');
      break;
    case 'list':
      require('shortify/list.php');
      break;
    default:
      require('shortify/retrieve.php');
      break;
  }

?>