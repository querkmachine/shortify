<?php
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }

  $retrieve_the_thing = $connection->prepare("SELECT * FROM main WHERE short = :short");
  $retrieve_the_thing->execute(array(":short" => $query));

  $rows = $retrieve_the_thing->fetchAll();
  $num_rows = count($rows);

  if($num_rows > 0) { 
    foreach($rows as $row) {
      $this_is_the_thing = $row['notshort'];
      if($row['isURL'] == 1) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:" . $this_is_the_thing);
        die;
      }
      elseif($row['isURL'] == 2) {
        header("Content-Length: " . filesize($this_is_the_thing));
        $performer_type = getimagesize($this_is_the_thing);
        if($performer_type) { $attachment = ""; }
        else { $attachment = "attachment;"; }
        header("Content-Disposition: " . $attachment . " filename=" . $row['filename']);
        if($performer_type) { header("Content-Type: " . $performer_type['mime']); }
        else { header("Content-Type: application/octet-stream"); }
        readfile($this_is_the_thing);
        die;
      }
    }
  }
  else {
    die("Nothing here :C");
  }