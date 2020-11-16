<?php
session_start();
    if ( ! isset($_SESSION["name"]) ) {
        die('Not logged in');
      }
require_once "pdo.php";
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
</head>
<body style="font-family: sans-serif;">
<h1>Tracking Autos for <?php
if ( isset($_SESSIONT['name']) ) {
    echo htmlentities($_SESSION['name']);
} ?></h1>

<?php
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }?>
<h2>Automobiles</h2>

    <table border="1">
    <?php

    foreach ( $rows as $row ) {
      echo "<tr><td>";
      echo(htmlentities($row['make']));
      echo("</td><td>");
      echo(htmlentities($row['year']));
      echo("</td><td>");
      echo(htmlentities($row['mileage']));
      echo("</td></tr>\n");
    }
    ?>
    </table>
    <p><a href="add.php">Add New</a>  <a href="logout.php">Logout</a></p>
</body>
</html>
