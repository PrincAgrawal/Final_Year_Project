<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "Prince@2004@";
$db_name = "circuitfix_shop_db";
$db_port = 3306;

// Create Connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

// Checking Connection
if($conn->connect_error){
 die("Connection Failed");
} 
// else {
//  echo "Connect";
// }

?>