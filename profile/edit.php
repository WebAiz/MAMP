<?php
require_once "pdo.php";
session_start();

 if ( ! isset($_SESSION["name"]) ) {
     die("Not logged in");
  }

if ( isset($_POST['first_name']) && isset($_POST['last_name'])
     && isset($_POST['email']) && isset($_POST['headline'])&& isset($_POST['summary'])&& isset($_POST['profile_id']) ) {

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
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1|| strlen($_POST['summary']) < 1 ) {
            $_SESSION['error'] = "All fields are required";
            header("Location: edit.php?profile_id=" . $_POST["profile_id"]);
            return;
        }
        if (strpos($_POST['email'], '@') === false ) {
          $_SESSION["error"] = "Email address must contain @";
          header("Location: edit.php?profile_id=" . $_POST["profile_id"]);
          return;
        }

    $sql = "UPDATE profile SET first_name= :fn,
            last_name = :ln, email = :em, headline = :he, summary=:su
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':fn' => $_POST['first_name'],
      ':ln' => $_POST['last_name'],
      ':em' => $_POST['email'],
      ':he' => $_POST['headline'],
      ':su' => $_POST['summary'],
      ':profile_id' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$n = htmlentities($row['first_name']);
$e = htmlentities($row['last_name']);
$p = htmlentities($row['email']);
$s = htmlentities($row['headline']);
$h = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Dr. Chuck's Profile Edit</title>
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Editing Profile for Aizada Turarova</h1>
<p>Edit User</p>
<form method="POST" action="edit.php">
<p>First Name:
<input type="text" name="first_name" size="60"
value="<?= $n ?>"
/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"
value="<?= $e ?>"
/></p>
<p>Email:
<input type="text" name="email" size="30"
value="<?= $p ?>"
/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"
value="<?= $s ?>"
/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"><?= $h ?></textarea>
<p>
<input type="hidden" name="profile_id" value="<?= $profile_id ?>">
<p><input type="submit" value="Save"/>
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
