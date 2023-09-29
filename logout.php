<?php
// (A) NOT LOGGED IN
session_start();
if (!isset($_SESSION["token"])) {
  header("Location: login.php"); exit;
}

// (B) REMOVE & REVOKE TOKEN
require "Config/config.php";
$goo->setAccessToken($_SESSION["token"]);
$goo->revokeToken();
unset($_SESSION["token"]);
// REMOVE YOUR OWN USER SESSION VARIABLES AS WELL
header("Location: login.php"); exit;