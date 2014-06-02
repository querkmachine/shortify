<?php 
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }
  if(!Session::isLoggedIn()) { die(header("Location: /login")); } 
  require 'parts/header.php';
  $one_list_to_rule_them_all = $connection->query("SELECT * FROM main");
?>

    <ul>
<?php
  while($row = $one_list_to_rule_them_all->fetch()):
?>
      <li><?php echo $row['short'] . " -> " . $row['notshort']; ?></li>
<?php
  endwhile;
?>
    </ul>

<?php 
  require 'parts/footer.php';
?>