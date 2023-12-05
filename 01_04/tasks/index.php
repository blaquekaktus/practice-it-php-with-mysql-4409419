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
  exit("An error occurred during the database query!");
}


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

      <?php foreach ($result as $task) {; //foreach loop start 
      ?>
        <tr>
          <td><?= $task['id'] ?></td>
          <td><?= $task['priority'] ?></td>
          <td><?= $task['completed '] == 1 ? 'True' : 'False' ?></td>
          <td><?= $task['description'] ?></td>
        </tr>
      <?php } // end loop 
      ?>
    </table>

  </section>

</body>

</html>

<?php
//release the query result 
$result->free();

//close the database connection
$db->close();
?>