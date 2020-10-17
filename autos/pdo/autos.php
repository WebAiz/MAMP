  <?php
  require_once "pdo.php";
  $failure = false;

  // Demand a GET parameter
  if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
      die('Name parameter missing');
  }

  // If the user requested logout go back to index.php
  if ( isset($_POST['logout']) ) {
      header('Location: index.php');
      return;
  }

if (isset($_POST['mileage']) || isset($_POST['year'])|| isset($_POST['make'])){
    if (! is_numeric($_POST['mileage']) || ! is_numeric($_POST['year'])) {
      $failure = "Mileage and year must be numeric";
    }elseif (strlen($_POST['make']) < 1) {
      $failure = "Make is required";
    }elseif (isset($_POST['mileage']) && isset($_POST['year'])&&isset($_POST['make'])){

        $stmt = $pdo->prepare('INSERT INTO autos
            (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'])
        );
      echo('<p style="color: green;">'."Record inserted"."</p>\n");
      }
  }


  $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <html>
  <head>
    <title>Aizada Turarova</title>
  </head>
  <body>

  <p>Tracking auto for <?php
  if ( isset($_REQUEST['name']) ) {
      echo htmlentities($_REQUEST['name']);
  }
  ?>
  <?php
  // Note triple not equals and think how badly double
  // not equals would work here...
  if ( $failure !== false ) {
      // Look closely at the use of single and double quotes
      echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
  }
  ?>
  </p>
  <form method="POST">
  <p>Make:
  <input type="text" name="make" size="40"></p>
  <p>Year:
  <input type="text" name="year"></p>
  <p>Mileage:
  <input type="text" name="mileage"></p>
  <p>
    <input type="submit" value="Add">
    <input type="submit" name="logout" value="Logout"></p>
  </form>

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
  </body>
  </html>
