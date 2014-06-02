<?php 
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }
  if(!Session::isLoggedIn()) {
    if($_POST) {
      $remember_me = !empty($_POST["login_remember_me"]) ? true : false;
      if(Session::logIn($_POST["login_username"], $_POST["login_password"], $remember_me)) {
        die(header("Location: /add"));
      }
    }
  }
  else {
    Session::logOut($_COOKIE["session"]);
  }
  require 'parts/header.php';
?>

    <form action="/login" method="post" class="form">
      <header class="form__header">
        <h1 class="form__title">Log in</h1>
      </header>
      <div class="form__row">
        <label for="login_username">Username</label>
        <input type="text" name="login_username" id="login_username" required>
      </div>
      <div class="form__row">
        <label for="login_password">Password</label>
        <input type="password" name="login_password" id="login_password" required>
      </div>
      <div class="form__row">
        <input type="submit" value="Log in"> 
        <label><input type="checkbox" name="login_remember_me" value="true"> Remember me</label>
    </div>
    </form>

<?php 
  require 'parts/footer.php';
?>