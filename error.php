<?php
if(isset($_GET['c'])) {
    $enum = $_GET['c'];
}
else {
    $enum = "2";
}
// Errors
$errorj = '{"1":"Your device does not support upload.","2":"An unknown error has occurred.","3":"Your device does not support search."}';
$errors = json_decode($errorj, true);
?>
<html>
<head>
<title>Error</title>
</head>
<body>
<center>
<h1>An error has occurred.</h1>
<h3><?php echo(@$errors[$enum]); ?></h3>
</center>
</body>
</html>