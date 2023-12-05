<?php

// hostname: "127.0.0.1"
// username: "mariadb"
// password: "mariadb"
// database: "mariadb"
// port:     3306

//create the database connection
$db = new mysqli("127.0.0.1", "mariadb", "mariadb", "mariadb", 3306);

//check that the connection was successful
if ($db->connect_errno) {
  $msg = "The database connection failed: ";
  $msg .= $db->connect_error;
  $msg .= "( " . $db->connect_errno . ").";
  exit($msg);
}

// perform the query
$sql = "SELECT * FROM tasks ORDER BY priority";
$result = $db->query($sql);


//check if query was successful
if (!$result) {
  exit("An error occurred during the database query!" . $db->connect_error);
}

//fetch all rows into an array
//$tasks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Task Manager: Task List</title>
</head>

<body>

  <header>
    <h1>Task Manager</h1>
  </header>

  <section>

    <h1>Task List</h1>

    <table>
      <tr>
        <th>ID</th>
        <th>Priority</th>
        <th>Completed</th>
        <th>Description</th>
      </tr>

      <?php while ($task = $result->fetch_object()) {  ?>
        <tr>
          <td><?php echo $task->id ?></td>
          <td><?php echo $task->priority ?></td>
          <td><?php echo $task->completed == 1 ? 'True' : 'False' ?></td>
          <td><?php echo $task->description ?></td>
        </tr>
      <?php } ?>
    </table>

  </section>

</body>

</html>

<?php
//release the returned data 
$result->free();

//close the database connection
$db->close();
?>