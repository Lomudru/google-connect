<?php
// (A) LOAD GOOGLE CLIENT LIBRARY
require("vendor/autoload.php");

// (B) NEW GOOGLE CLIENT
$goo = new Google\Client();
$httpClient = new GuzzleHttp\Client([
    'verify' => false, // Désactive la vérification du certificat
    'curl' => [
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
    ],
]);
$goo->setHttpClient($httpClient);
$goo->setClientId("723853566608-6fiqm8sau8pib1g7s6tpufiqv231abs1.apps.googleusercontent.com");
$goo->setClientSecret("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");
$goo->addScope("email");
$goo->addScope("profile");
$goo->setRedirectUri("http://localhost/test/login.php");


$hostname = "localhost";
$username = "root";
$password = "";
$database = "googleConnect";

$conn = mysqli_connect($hostname, $username, $password, $database);