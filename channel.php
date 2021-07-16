<?php
if(isset($_GET['id'])) {
$chan = json_decode(file_get_contents("channel/$id.json"), true);
$name = $chan['name'];
$icon = $chan['icon'];
}
else {
header("Location: index.php");
die('You should have been redirected. If not, click <a href="index.php">here</a>.');
}
?>
<html>
<head>
  <title><?php echo($name); ?> - Overview</title>
  </head>
<body>
  <div id="overview>
           <center>
           <img src="<?php echo($icon); ?>" width="100" height="100">
                                                                    <p id="name"><?php echo($name); ?></p>
                                                                                </div>
                                                                                </body>
                                                                                </html>
