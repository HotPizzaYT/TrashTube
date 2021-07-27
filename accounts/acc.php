<?php
session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){

?>
<!DOCTYPE html>
<html>
<head>
<title>HxLogin Accounts</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrashTube 2.0">
</head>
<body>
<h1>Welcome to HxLogin Accounts</h1>
<p>Username: <?php echo $_SESSION["username"]; ?></p>
<p>Email: <?php echo $_SESSION["email"]; ?></p>
<li>&#149; <a href="changePass.php">Change password</a></li>
<li>&#149; <a href="about.php">Change my profile</a></li>
<li>&#149; <a href="avatar.php">Change my avatar</a></li>
<li>&#149; <a href="../channel.php?id=<?php echo($_SESSION['username']); ?>">View My Profile</a></li>
<li>&#149; <a href="delete.php">Delete my account</a></li>
<li>&#149; <a href="logout.php">Log out</a></li>
<li>&#149; <a href="../">Quit</a></li>

</body>
<?php
} else {
header("Location: index.php");
} ?>