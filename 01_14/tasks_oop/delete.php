<?php

// Helper function
function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

// typecast the value as an integer to prevent SQL injection
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $hostname = "127.0.0.1";
  $username = "mariadb";
  $password = "mariadb";
  $database = "mariadb";
  $port =     3306;

  $db = new mysqli ($hostname, $username, $password, $database, $port);

  if($db->errno){
    $msg = "Database connection error: ";
    $msg .= $db->error;
    $msg .= "(". $db->errno . ")";
    exit($msg);
  }

  $sql = "DELETE FROM tasks ";
  $sql .= "WHERE id = {$id} ";
  $sql .= "LIMIT 1";
  $stmt = $db->query($sql);

  if(!$stmt){
    $msg= "Task deletion failed!";
    exit($msg);
  }

}

$db->close();

redirect_to('index.php');

?>
