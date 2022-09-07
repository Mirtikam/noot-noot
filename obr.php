<?php
session_start();
include("db.php");

$name = $_POST['name'];
$msg = $_POST['msg'];

$str = "INSERT INTO `chat` (`name`, `msg`, `date`) VALUES ('$name', '$msg', CURRENT_TIMESTAMP)";

$result = $db->query($str);

if($result){
  print "MSG_ADDED";
} else {
  print "MSG_ERROR";
}

?> 
