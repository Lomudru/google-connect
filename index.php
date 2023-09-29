<?php
// (A) NOT LOGGED IN
session_start();
if (!isset($_SESSION["token"])) {
  header("Location: login.php"); exit;
}

// (B) TOKEN EXPIRED - TO LOGIN PAGE
require "Config/config.php";
$goo->setAccessToken($_SESSION["token"]);
if ($goo->isAccessTokenExpired()) {
  unset($_SESSION["token"]);
  header("Location: login.php"); exit;
}

// (C) GET USER PROFILE
$google_oauth = new Google_Service_Oauth2($goo);
if($google_oauth){
  $google_account_info = $google_oauth->userinfo->get();
  $userinfo = [
      "oauth_provider" => "google",
      "oauth_uid" => $google_account_info["id"],
      "first_Name" => $google_account_info["givenName"],
      "last_Name" => $google_account_info["familyName"],
      "email" => $google_account_info["email"],
      "gender" => $google_account_info["gender"],
      "locale" => $google_account_info["locale"],
      "picture" => $google_account_info["picture"],
  ];
}

$sql = "SELECT * FROM users WHERE email = '{$userinfo['email']}'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
    $userdata = mysqli_fetch_assoc($result);
    $token = $userinfo['oauth_uid'];
}else{
    $sql = "INSERT INTO users (oauth_provider, oauth_uid, first_Name, last_Name, email, gender, locale, picture, created) 
    VALUES ('{$userinfo['oauth_provider']}', '{$userinfo['oauth_uid']}', '{$userinfo['first_Name']}', '{$userinfo['last_Name']}', '{$userinfo['email']}','{$userinfo['gender']}', '{$userinfo['locale']}', '{$userinfo['picture']}', NOW())";
    $result = mysqli_query($conn, $sql);
    if($result){
        $token = $userinfo['oauth_uid'];
    }else{
        echo "user not created";
        die();
    }
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenue <?php echo $userinfo["first_Name"] ?></title>
</head>
<body>
  <div>
    <img src="<?php echo $userinfo["picture"] ?>">
    <h1><?php echo $userinfo["first_Name"] . " " . $userinfo["last_Name"]?></h1>
    <h2><?php echo $userinfo["email"] ?></h2>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>