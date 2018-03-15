<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

  $user_id = $_SESSION['user_id'];
 
  
  $db = new DB_CONNECT();
  
  $finalArray = array();
  
     if(isset($_GET['message'])){
         
     }

