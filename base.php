<?php
session_start();
 
$dbhost = "oniddb.cws.oregonstate.edu"; //database host
$dbname = "sunstror-db"; // database name
$dbuser = "sunstror-db"; // username
$dbpass = "WxWvu6Z5j4Dq2neK"; // password
 
ini_set("display_errors", "On");
      $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
      if(!$mysqli || $mysqli->connect_errno)
      {
        echo "Connection Error ". $mysqli->connect_errno . " " . $mysqli->connect_error;
      }else
      	
        
?>