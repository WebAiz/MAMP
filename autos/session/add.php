<?php
session_start();
require_once "pdo.php";


// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: login.php');
    return;
}

if (isset($_POST['mileage']) || isset($_POST['year'])|| isset($_POST['make'])){
  if (! is_numeric($_POST['mileage']) || ! is_numeric($_POST['year'])) {
    $_SESSION["error"] = "Mileage and year must be numeric";
    header('Location: add.php');
    return;
  }elseif (strlen($_POST['make']) < 1) {
    $_SESSION["error"] = "Make is required";
    header('Location: add.php');
    return;
  }elseif (isset($_POST['mileage']) && isset($_POST['year'])&&isset($_POST['make'])){

      $stmt = $pdo->prepare('INSERT INTO autos
          (make, year, mileage) VALUES ( :mk, :yr, :mi)');
      $stmt->execute(array(
          ':mk' => $_POST['make'],
          ':yr' => $_POST['year'],
          ':mi' => $_POST['mileage'])
      );
      $_SESSION['success'] = "Record inserted";
      header("Location: view.php");
      return;
    }
}
// $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
  <title>Aizada Turarova</title>
</head>
<body>

<p>Adding auto for <?php
if ( isset($_SESSION['name']) ) {
    echo htmlentities($_SESSION['name']);
}
?>
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
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

</body>
</html>
