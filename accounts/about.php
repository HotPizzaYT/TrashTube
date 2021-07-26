<?php
session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){
	if(file_exists("data/" . $_SESSION["username"] . ".json")){
	$jsonFile = file_get_contents("data/" . $_SESSION["username"] . ".json");
	$jsonD = json_decode($jsonFile, true);
	if(isset($_POST) && isset($_POST["about"]) && $_POST["about"] !== ""){
		// Changing the stuff up.
		$jsonD["about"] = $_POST["about"];
		$finalContents = json_encode($jsonD, true);
		file_put_contents("data/" . $_SESSION["username"] . ".json", $finalContents);
		echo "Profile successfully changed!<br />";
	}
?>
<title>Your TrashTube profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrashTube 2.0">
<h1>Your TrashTube profile</h1>
<form action="about.php" method="post" enctype="multipart/form-data">
<textarea required name="about" style="width: 50%; height: 300px"><?php echo $jsonD["about"]; ?></textarea>
<p><input type="submit" name="submit" value="Update my profile" /></p>
</form>
<p><a href="index.php">Quit</a></p>
<p><a href="../channel.php?id=<?php echo $_SESSION["username"]; ?>">View my profile</a></p>
<?php
	}
} else {
	header("Location: index.php");
}