<?php
session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){

}
else {
    header("Location: ../");
    die();
}
if(isset($_GET['category'])) {
    if($_GET['category'] === "appearance") {
        echo('
        <html>
<head>
<title>HxLogin Settings</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrashTube 2.0">
</head>
<body>
<center><h3>Appearance - TrashTube Settings</h3>
<form action="actions.php?action=category" method="POST">
<label>Coming soon</label>
</form>
</center>
</body>
</html>
        ');
        die();
    }
}
?>
<html>
<head>
<title>HxLogin Settings</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrashTube 2.0">
</head>
<body>
<center><h3>TrashTube Settings</h3>
<form action="actions.php?action=category" method="POST">
<input type="submit" name="action" value="Appearance">
</form>
</center>
</body>
</html>