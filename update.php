<?php
$current = "1";
if(isset($_GET['debug'])) {
if(!file_get_contents("http://localhost/ttserver/latest.php")) {
die("The update server is down. Please try again later.");
}
$latest = file_get_contents("http://localhost/ttserver/latest.php");
if($latest > $current) {
    die("<p>You have an update available.<br>You are on version <span style='color:red;'>$current</span>. The latest is <span style='color:green;>$latest</span></p>");
        }
    die("You are on the latest version.");
}
else {
$latest = file_get_contents("http://sudaox.tech/ttserver/latest.php");
}
if($latest > $current) {
die("<p>You have an update available.<br>You are on version <span style='color:red;'>$current</span>. The latest is <span style='color:green;>$latest</span></p>");
    }
die("You are on the latest version.");
