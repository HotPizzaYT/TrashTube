<?php
if(isset($_GET['debug'])) {
$latest = file_get_contents("http://localhost/ttserver/latest.php");
}
else {
$latest = file_get_contents("http://sudaox.tech/ttserver/latest.php");
}
if($latest > $current) {
die("<p>You have an update available.<br>You are on version <span style="color:red;">$current</span>. The latest is <span style="color:green;>$latest</span></p>
    }
die("You are on the latest version.");
