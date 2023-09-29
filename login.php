<?php
// (A) ALREADY SIGNED IN
session_start();
if (isset($_SESSION["token"])) {
  header("Location: index.php"); exit;
}

// (B) ON LOGIN - PUT TOKEN INTO SESSION
require "Config/config.php";
if (isset($_GET["code"])) {
  $token = $goo->fetchAccessTokenWithAuthCode($_GET["code"]);
  if (!isset($token["error"])) {
    $_SESSION["token"] = $token;
    header("Location: index.php"); exit;
  }  
}

// (C) SHOW LOGIN PAGE ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login With Google</title>
  </head>
  <body>
    <?php if (isset($token["error"])) { ?>
    <div><?= print_r($token); ?></div>
    <?php } ?>

    <a href="<?= $goo->createAuthUrl() ?>">Login with Google</a>
  </body>
</html>