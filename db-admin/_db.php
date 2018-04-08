<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_cApp.php' ?>
<?php 

  require '_money_format.php';

  /* Include class file */
  //include ("medoo.php");
  require 'medoo.php';

  function createDb(){

  	//create new db connection
    $database = new medoo([
      // required
      'database_type' => 'mysql',
      'database_name' => AppConfig::$DB_NAME,
      'server' => 'localhost',
      'username' => AppConfig::$DB_USERNAME,
      'password' => AppConfig::DB_PASSWORD(),
      'charset' => 'utf8'
     
      // [optional]
      //'port' => 3306,
     
      // [optional] Table prefix
      //'prefix' => 'PREFIX_',
     
      // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
      //'option' => [
      //  PDO::ATTR_CASE => PDO::CASE_NATURAL
      //]
      ]);


    //sets the timezone for the connection
    $database->query("SET time_zone = '+10:00'")->fetchAll();

    return $database;
  }

  //function to  prettify boolean
  function ToYesNo($b){
    if ($b == 1 || $b || $b == "1" ) {
      return 'Yes';
    }   
    return 'No';
  }
  
  
  
?>
