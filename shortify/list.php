<?php 
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }
  if(!Session::isLoggedIn()) { die(header("Location: /login")); } 
  require 'parts/header.php';
  $about_me = Session::getUserData($_COOKIE["session"]);
  $one_list_to_rule_them_all = $connection->prepare("SELECT * FROM main WHERE user = :user_id");
  $one_list_to_rule_them_all->execute(array(":user_id" => $about_me['id']));
?>

    <h1>List All</h1>
    <ul class="shortify-list">
<?php
  $output = '';
  while($row = $one_list_to_rule_them_all->fetch()):
    // print_r($row);
    $url = ROOT . "/" . $row['short'];
      $output .= '<li>';
        $output .= '<h4><a href="' . $url . '">' . $url . '</a></h4>';
        if($row['isURL'] == 1):
          $output .= '<small><strong>URL:</strong> ' . $row['notshort'] . '</small>';
        elseif($row['isURL'] == 2):
          $output .= '<small><strong>File:</strong> ' . $row['filename'] . '</small>';
        endif;
      $output .= '</li>';
  endwhile;
  echo $output;
?>
    </ul>

<?php 
  require 'parts/footer.php';
?>