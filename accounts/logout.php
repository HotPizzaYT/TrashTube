<?php
session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){
unset($_SESSION["username"]);
unset($_SESSION["email"]);
header("Location: index.php");
} else {
// Already logged out.
header("Location: index.php");
}
?>