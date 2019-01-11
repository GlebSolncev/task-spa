<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
global $logger;

//кофиги
define('DB_NAME', 'packreg_db');//Решил вывести сюда, потому что удобно. Можно сделать отдельно конфиг.
define('USE_CREATE_TABLE', 1);//Создать таблицу автоматически
define('INSER_VALUES', 1);//Заполнить демо товарами
define('WRITE_LOG', 0);//Вывести лог


include('app/helper.php');
include('routing/web.php');
include('app/migration/product.php');//Инклуд который создает Таблицу и заполняет ее.(демо товары)

if(!WRITE_LOG)
    ini_set('error_reporting', E_STRICT);
else
    logg();


if (empty($_SESSION['token']))
    $_SESSION['token'] = 'GlebSolncev'.bin2hex(random_bytes(32));


function __autoload( $className ) {
  $className = str_replace( "..", "", $className ).".php";
  require_once( "app/".$className );
}




