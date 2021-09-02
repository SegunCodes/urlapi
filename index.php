<?php
//redirect user to original link using shorten link
include "php/config.php";
$new_url = "";
if (isset($_GET)) {
  foreach ($_GET as $key => $val) {
    $u = mysqli_real_escape_string($conn, $key);
    $new_url = str_replace('/', '', $u);
    //removing / from url
  }
  //get the full url of the short url from db
  $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
  if (mysqli_num_rows($sql) > 0) {
    $sql2 = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'");
    if ($sql2) {
      //redirect user
      $full_url = mysqli_fetch_assoc($sql);
      header("Location:" . $full_url['full_url']);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>URL Shortener by SegunCodes</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
  <script src="https://kit.fontawesome.com/dd68711fa6.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="wrapper">
    <form action="#" autocomplete="off">
      <input type="text" spellcheck="false" name="full_url" placeholder="Enter or paste a long url" required>
      <i class="url-icon uil uil-link"></i>
      <button>Shorten</button>
    </form>
    <?php
    $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC LIMIT 1");
    if (mysqli_num_rows($sql2) > 0) {;
    ?>
      <div class="statistics">
        <?php
        $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
        $res = mysqli_fetch_assoc($sql3);

        $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
        $total = 0;
        while ($count = mysqli_fetch_assoc($sql4)) {
          $total = $count['clicks'] + $total;
        }
        ?>
        <span><span><?php //echo end($res) ?></span> <span></span></span>
        <a class="btn btn-danger clear" href="php/delete.php?delete=all">Clear</a>
      </div>
      <div class="urls-area">
        <div class="title">
          <li>Shorten URL</li>
          <li>Original URL</li>
          <li>Clicks</li>
          <li>Action</li>
        </div>
        <?php
        while ($row = mysqli_fetch_assoc($sql2)) {
        ?>
          <div class="data">
            <li>
              <a href="http://localhost/url/<?php echo $row['shorten_url'] ?>" target="_blank" rel="noopener noreferral">
                <?php
                if ('localhost/url/' . strlen($row['shorten_url']) > 50) {
                  echo 'localhost/url/' . substr($row['shorten_url'], 0, 50) . '....';
                } else {
                  echo 'localhost/url/' . $row['shorten_url'];
                }
                ?>
              </a>
            </li>
            <li>
              <?php
              if (strlen($row['full_url']) > 60) {
                echo substr($row['full_url'], 0, 60) . '...';
              } else {
                echo $row['full_url'];
              }
              ?>
            </li>
            <li><?php echo $row['clicks'] ?></li>
            <li><a href="php/delete.php?id=<?php echo $row['shorten_url'] ?>"><i class="fas fa-trash-alt"></i></a></li>
          </div>
        <?php
        }
        ?>
      </div>
    <?php
     }
    ?>
   </div>

  <div class="blur-effect"></div>
  <div class="popup-box">
    <div class="info-box">Your short link is ready. You can also edit your short link now but can not edit once you have saved it.</div>
    <form action="#" class="popup-form" autocomplete="off">
      <label>Edit your shorten url</label>
      <input type="text" class="shorten-url" spellcheck="false" required>
      <i class="copy-icon uil uil-copy-alt"></i>
      <button>Save</button>
    </form>
  </div>

  <div class=" footer-div">
    <footer class="blockquote-footer">
      <p>
        <span>Created by SegunCodes</span> | &copy;2021 |
        <span><a href="https://github.com/Seguncodes" target="_blank" rel="noopener noreferral"><i class="fab fa-github"></i></a></span> |
        <!-- <span><a href="https://facebook.com/SM-Tech-105188518124796" target="_blank" rel="noopener noreferral"><i class="fab fa-facebook"></i></a></span> | -->
        <span><a href="https://www.linkedin.com/in/olusegun-joe-alabi-8b89a420a" target="_blank" rel="noopener noreferral"><i class="fab fa-linkedin"></i></a></span> |
        <span><a href="https://www.instagram.com/Olusegun_shegstix/" target="_blank" rel="noopener noreferral"><i class="fab fa-instagram"></i></a></span>
      </p>
    </footer>
  </div>
  <script src="js/script.js"></script>

</body>

</html>