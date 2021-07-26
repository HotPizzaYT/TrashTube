<?php
/*
session_start();
if(file_exists("../ids/" . $_POST['id'] . ".json")){
	// Video exists;
	$json = file_get_contents("../ids/" . $_POST['id'] . ".json");
	$jsonD = json_decode($json, true);
    echo("DEBUG: Decoded $jsonD<br>");
}
else {
die("Video does not exist.");
}
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){
echo("DEBUG: Logged in.<br>");
$usrname = $_SESSION["username"];
$usrjson = json_decode("../accounts/data/$usrname.json", true);
echo("DEBUG: usrname<br>");
} else {
    die("DEBUG: Not logged in.<br>");
    } 
    if($_SESSION["username"] === htmlspecialchars($jsonD["uploader"])) {
        $studid = $_POST['id'];
         unlink("../ids/$studid.json");
         unlink("../thb/$studid.jpg");
         unset($usrjson['videos'][$studid]);
         file_put_contents("../accounts/data/$username.json", json_encode($usrjson));
         echo("DEBUG: Deleted<br>");
    }
    else {
        die("DEBUG: Does not own<br>");
    }
    */
    die("Coming soon in a later version.");
    ?>
