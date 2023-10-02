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
$goo->setClientId("Client Id Here");
$goo->setClientSecret("Secret Client Here");
$goo->addScope("email");
$goo->addScope("profile");
$goo->setRedirectUri("http://localhost/test/login.php");


$hostname = "localhost";
$username = "root";
$password = "";
$database = "googleConnect";

$conn = mysqli_connect($hostname, $username, $password, $database);
