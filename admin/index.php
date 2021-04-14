<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include_once("../config.php");
      $title = 'Login';
      include_once(GLOBAL_URL."/components/header.php");
    ?>
</head>
<?php
  if(!empty($_SESSION["id"])) {
    // Rediect to home
    header('location: '.SITE_URL);
    exit;
  } else {
    echo '
    <body class="center">
    <form class="form-signin" action="'.SITE_URL.'/admin/submitLogin.php" method="POST">
      <div class="text-center mb-4">
        <img class="mb-4" src="'.SITE_URL.'/assets/images/logo.png" alt="DogeGarden Logo" width="120" height="120">
        <h1 class="h3 mb-3 font-weight-normal">'.SRV_NAME.' Login</h1>
      </div>';

        if(!empty($_SESSION["loginError"])) {
          echo '<strong><p class="text-center text-danger">Incorrect Credentials</p></strong>';
            //Get rid of message in session
            unset($_SESSION["loginError"]);
        };

      echo '
      <div class="form-label-group">
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
        <label for="inputEmail">Email address</label>
      </div>

      <div class="form-label-group">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
        <label for="inputPassword">Password</label>
      </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted text-center">&copy; '.date('Y').' '.SRV_NAME.' | <a href="'.SITE_URL.'">Homepage</a></p>
    </form>
</body>';
  };
?>
</html> 