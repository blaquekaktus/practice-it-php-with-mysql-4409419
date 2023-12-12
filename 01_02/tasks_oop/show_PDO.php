<?php

$hostname = "127.0.0.1";
$username = "mariadb";
$password = "mariadb";
$database = "mariadb";
$port = 3306;

try {

  //Define Data Source Name
  $dsn = "mysql: host=$hostname; dbname=$database; port=$port";

  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
  ];

  $db = new PDO($dsn, $username, $password, $options);

  //perform database query
  $sql = "SELECT * FROM tasks LIMIT 1";
  $stmt = $db->query($sql);

  //test if query was successful
  if (!$stmt) {
    $msg = "Database query failed.";
    exit($msg);
  }

  //return query results if any
  $task = $stmt->fetch();
} catch (PDOException $e) {
  $msg =  "Database connection failed: " . $e->getMessage();
  exit($msg);
}

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
$stmt->closeCursor();

//close database connection
$db = null;
