<?php

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

session_start();

if(!isset($_SESSION['email'])){
    header("Location: index.php");
}

include "config.php";
include "vendor/autoload.php";

$username = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789';
$username = str_shuffle($username);
$username = substr($username, 0, 8);

$password = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789';
$password = str_shuffle($password);
$password = substr($password, 0, 8);

// Create config object with parameters
$config =
    (new Config())
        ->set('host', $ROS1Host)
        ->set('port', $ROS1Port)
        ->set('pass', $ROS1Password)
        ->set('user', $ROS1Username);

// Initiate client with config object
$client = new Client($config);

// Build query
$query =
    (new Query('/ip/hotspot/user/add'))
        ->equal('name', $username)
        ->equal('password', $password)
        ->equal('profile', $profilouser);

// Add user
$out = $client->query($query)->read();

header("Location: http://$hsip/login?username=$username&password=$password");

session_destroy();

?>