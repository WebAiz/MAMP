<?php // Do not put any HTML above this line
require_once "pdo.php";
require_once "util.php";

session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

if ( isset($_POST["email"]) && isset($_POST["pass"]) ) {
    unset($_SESSION["name"]);  // Logout current user
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
      $_SESSION["error"] = "Email and password are required";
      header("Location: login.php");
      return;
    }
    if (strpos($_POST['email'], '@') === false ) {
      $_SESSION["error"] = "Email must have an at-sign (@)";
      header("Location: login.php");
      return;
    }
    $salt = 'XyZzy12*_';
    $check = hash('md5', $salt.$_POST['pass']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users
    WHERE email = :em AND password = :pw');
    $stmt->execute(array( ':em' => $_POST['email'], ':pw' =>$check ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ( $row !== false ) {
    $_SESSION['name'] = $row['name'];
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION["success"] = "Logged in.";
    header("Location: index.php");
    return;
    } else{
      $_SESSION["error"] = "Incorrect password.";
      error_log("Login fail ".$_POST['email']."$check");
      header( 'Location: login.php' ) ;
      return;
  }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Aizada Turarova Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php flashMessages(); ?>
<form method="POST">
<label for="email">User Name</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
      <script>function doValidate() {
      console.log('Validating...');
      try {
      pw = document.getElementById('id_1723').value;
      console.log("Validating pw="+pw);
      if (pw == null || pw == "") {
      alert("Both fields must be filled out");
      return false;
      }
      return true;
      } catch(e) {
      return false;
      }
      return false;

      }</script>
</div>
</body>

</html>
