<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION["name"]) ) {
    die("ACCESS DENIED");
  }
if (isset($_POST['mileage']) || isset($_POST['year'])|| isset($_POST['make'])){
  if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
          $_SESSION['error'] = "All values are required";
          header("Location: add.php");
          return;
      }
      if (! is_numeric($_POST['mileage']) || ! is_numeric($_POST['year'])) {
        $_SESSION["error"] = "Mileage and year must be numeric";
        header('Location: add.php');
        return;
      }

      if (isset($_POST['mileage']) && isset($_POST['year'])&& isset($_POST['make'])&& isset($_POST['model'])){

          $stmt = $pdo->prepare('INSERT INTO autos
              (make, model, year, mileage) VALUES ( :mk, :md,:yr, :mi)');
          $stmt->execute(array(
              ':mk' => $_POST['make'],
              ':md' => $_POST['model'],
              ':yr' => $_POST['year'],
              ':mi' => $_POST['mileage'])
          );
          $_SESSION['success'] = "Record added";
          header("Location: index.php");
          return;
        }

}



// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<p>Add New Entry</p>
<form method="post">
<p>Make:
<input type="text" name="make"></p>
<p>Model:
<input type="text" name="model"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p><input type="submit" value="Add">
<a href="index.php">Cancel</a></p>
</form>
