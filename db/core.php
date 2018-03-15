<?php

ob_start();
session_start();

function loggedIn(){
      if(isset($_SESSION['user_id']) ){
          return true;
      }else{
          return false;
      }
}
