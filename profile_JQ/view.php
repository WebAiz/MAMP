<?php
require_once "pdo.php";
require_once "util.php";
session_start();

if ( !isset($_SESSION['name'] ) ) {
    header("Location: login.php");
    return;
}
?>
<html>
<head><title>Aizada Turarova</title></head><body>
<?php

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

//load up the position rows
$pos = $pdo->query("SELECT year, description FROM position");

?>

<!DOCTYPE html>
<html>
<head>
<title>Dr. Chuck's Profile View</title>
<?php
 require_once "head.php";
?>
</head>
<body>
<div class="container">
<h1>Profile information</h1>
<?php
 flashMessages();
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

    if(!$pos->rowCount() == 0) {
        echo("<p>Position</p><ul>");
      }
    while ( $positions = $pos->fetch(PDO::FETCH_ASSOC) ) {
        
        echo("<li>");
        echo(htmlentities($positions['year']));
        echo(": ");
        echo(htmlentities($positions['description']));
        echo("</li>");
    }
    if(!$pos->rowCount() == 0) {
        echo("</ul>");
      }
echo("</p>\n");
    echo('<a href="index.php?profile_id='.$row['profile_id'].'">Done</a>');

?>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
