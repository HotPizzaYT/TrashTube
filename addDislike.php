<?php
if(isset($_GET["id"])){
if(file_exists("ids/" . $_GET["id"] . ".json")){
	// File exists
	$json = file_get_contents("ids/" . $_GET["id"] . ".json");
	$jsonD = json_decode($json, true);
	$jsonD["dislikes"] = $jsonD["dislikes"] + 1;
	$ldFix = json_encode($jsonD, true);
    file_put_contents("ids/" . $_GET["id"]. ".json", $ldFix);
	echo $jsonD["dislikes"];
} else {
	echo "[FAIL]: Video doesn't exist.";
}
} else {
	echo "Why are you here."
}
?>