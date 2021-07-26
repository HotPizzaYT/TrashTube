<!-- Special thanks to Sudaox uwu -->
<!-- seen --> 
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
<h1>CREDITS</h1>
<?php
$people = array();
$people['0'] = "HxOr1337./HotPizzaYT/(*DripDog*) - Making most things";
$people['1'] = "Sudaox - Helping out";
$pcount = count($people);
for($x = 0; $x < $pcount; $x++){
  echo $people[$x] . "<br />";
}
?>
