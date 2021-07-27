<?php
if(!isset($_GET['id'])) { die(); }
$id = $_GET['id'];
if(file_exists("accounts/avatar/$id.png")) {
    header("Content-Type: image/png");
    readfile("accounts/avatar/$id.png");
}
else {
    header("Content-Type: image/png");
    readfile("accounts/default.png");
}
die();