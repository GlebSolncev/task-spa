<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set('error_reporting', E_STRICT);

if (empty($_SESSION['token']))
    $_SESSION['token'] = 'GlebSolncev'.bin2hex(random_bytes(32));

include('app/helper.php');
include('routing/web.php');

function __autoload( $className ) {
  $className = str_replace( "..", "", $className ).".php";
  require_once( "app/".$className );
}




