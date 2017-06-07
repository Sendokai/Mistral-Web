<?php
session_start();

include("../config/dbconfig.php");
// Function to encrypt password from username:password to sha1 encryption
function encryptsha($user,$pass) {
  $user = strtoupper($user);
  $pass = strtoupper($pass);
  return sha1($user.':'.$pass);
}
// Setting up variables with a POST method from html form.
$username = $_POST['username'];
$password = encryptsha($username, $_POST['password']);
// Preparing the query
$stmt = $conn->prepare("SELECT username FROM account WHERE username = ? AND sha_pass_hash = ?");
// Binding the Parameters
$stmt->bind_param("ss", $username, $password);
// Execute Query
$stmt->execute();
// Store Result
$stmt->store_result();
// Check if row exist
if($stmt->num_rows > 0) {
  $_SESSION['username'] = $username;
  echo "<div class='alert alert-success'><strong>Success!</strong>Usted se conectará en la página siguiente</div>";
}else{
  echo "<div class='alert alert-danger'><strong>Failed to Login!</strong>El Usuario o Contraseña no es correcto !</div>";
}
?>