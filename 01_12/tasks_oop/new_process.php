<?php

// Helper function
function redirect_to($location)
{
  header("Location: " . $location);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $task = [];
  $task['description'] = $_POST['description'] ?? '';
  $task['priority'] = $_POST['priority'] ?? '10';
  $task['completed'] = $_POST['completed'] ?? '0';

  $hostname = "127.0.0.1";
  $username = "mariadb";
  $password = "mariadb";
  $database = "mariadb";
  $port =     3306;

  //create new database connection
  $db = new mysqli($hostname, $username, $password, $database, $port);

  if ($db->connect_errno) {
    $msg = "Database connection error: ";
    $msg .= $db->connect_error;
    $msg .= " (" . $db->connect_errno . ").";
    exit($msg);
  }

  $sql = "INSERT INTO tasks (description, priority, completed) VALUES ";
  $sql .= "(";
  $sql .= "'" . mysqli_real_escape_string($db, $task['description']) . "',";
  $sql .= "'" . mysqli_real_escape_string($db, $task['priority']) . "',";
  $sql .= "'" . mysqli_real_escape_string($db, $task['completed']) . "'";
  $sql .= ")";

  $result = $db->query($sql);

  if (!$result) {
    exit("New Task creation failed: " . $db->connect_error);
  }

  $new_id = $db->insert_id;

  redirect_to('show.php?id=' . $new_id);

  $db->close();
}
