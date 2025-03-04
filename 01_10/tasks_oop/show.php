<?php
//Typecast the id as an integer to prevent SQl injection

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
// 1. Create a database connection
$db = new mysqli("127.0.0.1", "mariadb", "mariadb", "mariadb", 3306);

// Test if connection succeeded (recommended)
if ($db->connect_errno) {
  $msg = "Database connection failed: ";
  $msg .= $db->connect_error;
  $msg .= " (" . $db->connect_errno . ")";
  exit($msg);
}

// 2. Perform database query
$sql = "SELECT * FROM tasks ";
$sql .= "WHERE id = {$id} ";
$sql .= "LIMIT 1";
$result = $db->query($sql);

// Test if query succeeded (recommended)
if (!$result) {
  exit("Database query failed.");
}

// 3. Use returned data (if any)
$task = $result->fetch_object();
if (is_null($task)) {
  exit("No task with id: " . $id . " was found.");
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

  <nav>
    <a href="index.php">Task List</a>
  </nav>

  <section>

    <h1>Show Task</h1>

    <dl>
      <dt>ID</dt>
      <dd><?= $task->id; ?></dd>
    </dl>
    <dl>
      <dt>Priority</dt>
      <dd><?= $task->priority; ?></dd>
    </dl>
    <dl>
      <dt>Completed</dt>
      <dd><?= $task->completed == 1 ? 'true' : 'false'; ?></dd>
    </dl>
    <dl>
      <dt>Description</dt>
      <dd><?= $task->description; ?></dd>
    </dl>

  </section>

</body>

</html>

<?php
// 4. Release returned data
$result->free();

// 5. Close database connection
$db->close();
?>