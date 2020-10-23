<?php
require_once "pdo.php";
session_start();

if ( !isset($_SESSION['name'] ) ) {
    // Redirect the browser to game.php
    header("Location: login.php");
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

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}?>

<!DOCTYPE html>
<html>
<head>
<title>Dr. Chuck's Profile View</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Profile information</h1>
<?php
  echo('<p>First Name: ');
    echo(htmlentities($row['first_name']));
    echo('</p>Last Name: ');
    echo(htmlentities($row['last_name']));
    echo('</p><p>Email: ');
    echo(htmlentities($row['email']));
    echo('</p><p>Headline: ');
    echo(htmlentities($row['headline']));
    echo('</p><p>Summary: ');
    echo(htmlentities($row['summary']));
    echo('</p>');
    echo('<a href="index.php?profile_id='.$row['profile_id'].'">Done</a>');

?>
</div>
</table>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
