<?php
require_once "pdo.php";
require_once "util.php";

session_start();


$stmt=$pdo->query('SELECT * FROM Profile');
$profiles=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head><title>Aizada Turarova</title></head><body>
<body>
  <h1>Aizada Turarova's Resume Registry with JQuery</h1>
  <div class="container">
  <?php require_once "head.php";
  flashMessages();

  if ( !isset($_SESSION['user_id'] ) ) {
      // Redirect the browser to game.php
    echo('<a href="login.php">Please log in</a><br>');
  }else{
    echo('<a href="logout.php">log out</a><br>');
    $stmt = $pdo->query("SELECT profile_id, user_id,first_name, last_name, headline FROM profile");

    if(!$stmt->rowCount() == 0) {
      echo('<table border="1 \n">');
      echo ("<tr><th>");
      echo("Firstname</th>");
      echo("<th>Headline</th>");
      echo("<th>Action</th></tr>");
    }

    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo("<tr><td>");
        echo('<a href="view.php?profile_id='.$row['profile_id'].'">');
        echo(htmlentities($row['first_name']));
        echo(" ");
        echo(htmlentities($row['last_name']));
        echo('</a>');

        echo("</a></td><td>");
        echo(htmlentities($row['headline']));
        echo("</td><td>");
        echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> /');
        echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
        echo("</td></tr>\n");


    }
    echo("</table\n");
    echo('<p><a href="add.php">Add New Entry</a></p>');
  }

?>
</div>
</body>