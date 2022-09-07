<?php
error_reporting(E_ERROR); 
ini_set("display_errors", 1);

include ("db.php");

$str = "SELECT name, msg FROM chat ORDER BY date DESC LIMIT 40";

$result = $db->query($str);

if($result){
  $res = $result->fetch_all();
  $res = json_encode($res); 
  print $res;
} else {
  print "LOADING_CANCEL";
}
?> 
