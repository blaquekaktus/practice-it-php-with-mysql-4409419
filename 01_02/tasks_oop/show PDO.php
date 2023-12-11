<?php


$hostname = "127.0.0.1";
$username = "mariadb";
$password = "mariadb";
$database = "mariadb";
$port =    3306;

try{
  
//Define Data Source Name
$dsn = "mysql: host=$hostname; dbname=$database; port=$port";

//verify connection is established
if ($db->connect_errno) {
  $msg = "Database connection failed: ";
  $msg .= $db->connect_error;
  $msg .= " (" . $db->connect_errno . ").";
  exit($msg);
}

//perform database query
$sql = "SELECT * FROM tasks LIMIT 1";
$result = $db->query($sql);

//test if query was successful
if (!$result) {
  $msg = "Database query failed.";
  exit($msg);
}

//return query results if any
$task = $result->fetch_object();


?>

<!doctype html>
<html lang="en">

<head>
  <title>Task Manager: Show Task</title>
</head>

<body>

  <header>
    <h1>Task Manager</h1>
  </header>

  <section>

    <h1>Show Task</h1>

    <dl>
      <dt>ID</dt>
      <dd> <?= $task->id; ?></dd>
    </dl>
    <dl>
      <dt>Priority</dt>
      <dd><?= $task->priority; ?></dd>
    </dl>
    <dl>
      <dt>Completed</dt>
      <dd><?php echo $task->completed == 1 ? 'True' : 'False'; ?></dd>
    </dl>
    <dl>
      <dt>Description</dt>
      <dd><?= $task->description; ?></dd>
    </dl>

  </section>

</body>

</html>

<?php
//release returned data
$result->free();

//close database connection
$db->close();
