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
<?php
if(isset($_GET["id"])){
if(file_exists("ids/" . $_GET["id"] . ".json")){
	// File exists
	$json = file_get_contents("ids/" . $_GET["id"] . ".json");
	$jsonD = json_decode($json, true);
	$jsonD["likes"] = $jsonD["likes"] + 1;
	$ldFix = json_encode($jsonD, true);
    file_put_contents("ids/" . $_GET["id"]. ".json", $ldFix);
} else {
	echo "[FAIL]: Video doesn't exist.";
}
} else {
	echo "Why are you here.";
}
?>