<?php 
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }
  if(!Session::isLoggedIn()) { die(header("Location: /login")); } 
  require 'parts/header.php';

  if(isset($_POST['shortify_url'])):
    if(strlen($_POST['shortify_url']) > 0):
      $url_slug = (isset($_POST['shortify_short']) && strlen($_POST['shortify_short']) > 0) ? $_POST['shortify_short'] : generateNewSlug();
      $url_slug = validateSlug($url_slug);
      $about_me = Session::getUserData($_COOKIE["session"]);
      $allow_me_to_introduce_myself = $connection->prepare("INSERT INTO main(short, notshort, isURL, user) VALUES (:short, :notshort, 1, :user_id)");
      $allow_me_to_introduce_myself->execute(array(":short" => $url_slug, ":notshort" => $_POST['shortify_url'], ":user_id" => $about_me['id']));
      $url_slug = ROOT . "/" . $url_slug;
?>
    <div class="nice-shiny-new-url">
      <h2>Here's your freshly shortified URL:</h2>
      <input type="text" value="<?php echo $url_slug; ?>" readonly>
    </div>
<?php
    else:
?>
    <div class="error">
      <p>That was not a valid URL. You disappoint me.</p>
    </div>
<?php
    endif;
  endif;
?>

    <form action="" method="post" class="form">
      <header class="form__header">
        <h1 class="form__title">Shorten URL</h1>
      </header>
      <div class="form__row">
        <label for="shortify_url">URL</label>
        <input type="url" name="shortify_url" id="shortify_url" value="http://" required>
      </div>
      <div class="form__row">
        <label for="shortify_short">Shortcode (optional)</label>
        <input type="text" name="shortify_short" id="shortify_short" maxlength="50">
      </div>
      <div class="form__row form__row--no-label">
        <input type="submit" value="Shortify!">
      </div>
    </form>

<?php
  require 'parts/footer.php';
?>