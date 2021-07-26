<?php
session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){
header("Location: acc.php");
}
?>
<title>TrashTube Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="TrashTube Login">
<form action="log.php" method="post" enctype="multipart/form-data">
<h1>TrashTube Login</h1>
<p>Username:</p>
<input type="text" maxlength="16" required name="username" >
<p>Password:</p>
<input type="password" required name="password" > <input type="submit" name="submit" value="Log in" >
</form>
<a href="register.php">I don't have an account!</a>
<br/>
<a href="../">Quit</a>

<br />
<?php
if(isset($_GET["err"])){
	if($_GET["err"] === "1"){
		echo "Error: Why are you here?";
	}
	if($_GET["err"] === "2"){
		echo "Error: Invalid password";
	}
	if($_GET["err"] === "3"){
		echo "Error: User does not exist";
	}
}
?>