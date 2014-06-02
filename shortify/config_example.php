<?php
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }

  // Fill in the deets and save this file in the same directory as "config.php"

  define("ROOT",    "http://example.com");

  define("DB_HOST", "localhost");
  define("DB_USER", "DATABASE_USERNAME");
  define("DB_PASS", "DATABASE_PASSWORD");
  define("DB_NAME", "shortify");

  define("URL_LENGTH", 5);
  define("PASSWORD_SALT", "abcdefghijklmnopqrstuvwxyz0123456789");

  try {
    $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }
  catch(PDOException $e) {
    echo $e->getMessage();
  }