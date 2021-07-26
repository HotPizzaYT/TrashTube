<?php
if(!isset($_GET['action'])) { die(); }
if($_GET['action'] === "category") {
    if(!isset($_POST['action'])) { die(); }
    if($_POST['action'] === "Appearance") { header("Location: index.php?category=appearance"); die(); }
}