<?php
  /*Se reporteaza toate erorile cu exceptia celor de tip NOTICE si DEPRECATED */
  error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
  //error_reporting(E_ALL);
  ini_set('display_errors', 'on');

  /** DIR_BASE va retine locatia pe disk unde este stocata aplicatia web */
  define('DIR_BASE', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

  /** Datele de conectare la baza de date */
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'db_clinica');
  define('DB_USER', 'userclinica');
  define('DB_PASS', 'changeit');
?>