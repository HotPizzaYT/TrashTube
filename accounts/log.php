<?php
if(isset($_POST["username"]) && isset($_POST["password"])){
	if(file_exists("data/" . $_POST["username"] . ".json")){
		// echo "User exists<br />";
		$json = file_get_contents("data/" . $_POST["username"] . ".json");
		$jsonD = json_decode($json, true);
		if(password_verify($_POST["password"], $jsonD["password"])){
// Initiate page.
			session_start();
			$_SESSION["username"] = $jsonD["username"];
			$_SESSION["email"] = $jsonD["email"];
			header("Location: acc.php");
		} else {
			header("Location: index.php?err=2");
		}
		
	} else {
		header("Location: index.php?err=3");
	}
	
} else {
	header("Location: index.php?err=1");
}