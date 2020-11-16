<?php
require_once "pdo.php";
session_start();

if ( !isset($_SESSION['name'] ) ) {
    // Redirect the browser to game.php
    header("Location: welcome.php");
    return;
}
?>
<html>
<head><title>Aizada Turarova</title></head><body>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

$stmt = $pdo->query("SELECT make, model,year, mileage, autos_id FROM autos");
if($stmt->rowCount() == 0) {
  echo("No row found");
}

while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  echo('<table border="1 \n">');
    echo "<tr><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> /');
    echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
?>
</table>
<p><a href="add.php">Add New Entry</a></p>
<p><a href="logout.php">Logout</a></p>
