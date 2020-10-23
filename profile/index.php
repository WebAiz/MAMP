<?php
require_once "pdo.php";
session_start();
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

?>
<html>
<head><title>Aizada Turarova</title></head><body>
  <h1>Aizada Turarova's Resume Registry</h1>
  <?php
  if ( !isset($_SESSION['name'] ) ) {
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
