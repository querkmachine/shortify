<?php 
  if(!defined('TOTES_VALID_LOADING_HERE')) { exit; }
  if(!Session::isLoggedIn()) { die(header("Location: /login")); } 
  require 'parts/header.php';
?>

    <form action="" method="post" enctype="multipart/form-data" class="form">
      <header class="form__header">
        <h1 class="form__title">Upload file</h1>
        <p>Max upload size: <?php echo ini_get('upload_max_filesize'); ?>B</p>
      </header>
      <div class="form__row">
        <label for="shortify_file">File</label>
        <input type="file" name="shortify_file" id="shortify_file" required>
      </div>
      <div class="form__row">
        <label for="shortify_url">Shortcode (optional)</label>
        <input type="text" name="shortify_short" id="shortify_short" maxlength="50">
      </div>
      <div class="form__row form__row--no-label">
        <input type="submit" value="Shortify!">
      </div>
    </form>

<?php
  if(isset($_FILES['shortify_file']) && strlen(basename($_FILES['shortify_file']['name'])) > 0):
    $url_slug = (isset($_POST['shortify_short']) && strlen($_POST['shortify_short']) > 0) ? $_POST['shortify_short'] : generateNewSlug();
    $url_slug = validateSlug($url_slug);
    $newbie_file = $_FILES['shortify_file'];
    if(filesize($newbie_file['tmp_name']) > 0):
      $newbie_url = "stored/" . $url_slug;
      $the_nsa_for_files = finfo_open(FILEINFO_MIME_TYPE);
      $file_type = finfo_file($the_nsa_for_files, $newbie_file['tmp_name']);
      move_uploaded_file($newbie_file['tmp_name'], $newbie_url);
      $allow_me_to_introduce_myself = $connection->prepare("INSERT INTO main(short, notshort, isURL, filename, filetype) VALUES (:short, :notshort, 2, :filename, :filetype)");
      $allow_me_to_introduce_myself->execute(array(":short" => $url_slug, ":notshort" => $newbie_url, ":filename" => $newbie_file['name'], ":filetype" => $file_type));
      $url_slug = ROOT . "/" . $url_slug;
?>
    <div class="nice-shiny-new-url">
      <h2>Here's your newly uploaded file:</h2>
      <input type="text" value="<?php echo $url_slug; ?>" readonly>
    </div>
<?php
    else:
?>
    <div class="error">
      <p>That was not a valid file. You disappoint me.</p>
    </div>
<?php
    endif;
  endif;

  require 'parts/footer.php';
?>