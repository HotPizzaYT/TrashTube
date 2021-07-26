<?php
if(!file_exists("config.json")) {
    die("Error loading configuration. Please reinstall.");
}
else {
    $config = json_decode(file_get_contents("config.json"), true);
    if($config['installed'] === "no") {
        header("Location: install.php?page=welcome");
    }
    $name = $config['name'];
    $path = $config['path'];
}
    ?>
<?PHP
echo "Test";
$x = (isset($_GET["vid"]) && isset($_GET["cid"]) && isset($_GET["act"]));

if($x)
{
if(file_exists("ids/" . $_GET["vid"] . ".json")){
	// File exists
	$json = file_get_contents("ids/" . $_GET["vid"] . ".json");
	$jsonD = json_decode($json, true);
	if($_GET["act"] === "dislike"){
	$jsonD["comments"][$_GET["cid"]]["dislikes"] = $jsonD["comments"][$_GET["cid"]]["dislikes"] + 1;
	} else {
		if($_GET["act"] === "like"){
			$jsonD["comments"][$_GET["cid"]]["likes"] = $jsonD["comments"][$_GET["cid"]]["likes"] + 1;
		}
	}
	$ldFix = json_encode($jsonD, true);
    file_put_contents("ids/" . $_GET["vid"]. ".json", $ldFix);
} else {
	echo "[FAIL]: Video doesn't exist.";
}
} else {
	echo "Why are you here.";
}
?>