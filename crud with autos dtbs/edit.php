<?php
require_once "pdo.php";
session_start();

 if ( ! isset($_SESSION["name"]) ) {
     die("ACCESS DENIED");
  }

if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['autos_id'])&& isset($_POST['mileage']) ) {

    // Data validation
    // if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
    //     $_SESSION['error'] = 'Missing data';
    //     header("Location: edit.php?autos_id=".$_POST['autos_id']);
    //     return;
    // }
    // if (! is_numeric($_POST['mileage']) || ! is_numeric($_POST['year'])) {
    //   $_SESSION["error"] = "Mileage and year must be numeric";
    //   header('Location: add.php');
    //   return;
    // }


    $sql = "UPDATE autos SET make = :mk,
            model = :md, year = :yr, mileage = :mi
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$n = htmlentities($row['make']);
$e = htmlentities($row['model']);
$p = htmlentities($row['year']);
$s = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<p>Edit User</p>
<form method="POST">
<p>Make:
<input type="text" name="make" value="<?= $n ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $e ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $p ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $s ?>"></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
