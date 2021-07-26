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
if(isset($_GET["id"]) && file_exists("accounts/data/" . $_GET["id"] . ".json")){
    $channelFound = true;
} else {
    $channelFound = false;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>TrashTube - Channel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrashTube 2.0">
<style>
    .top-bar {
        background-color: #f0f0f0;
        top: 0;
        left: 0;
        width: 100%;
        height: 48px;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .logo {
        float: left;
        display: inline-block;
    }
    .block {
        display: inline-block;
        float: right;
    }
    .video-tile {
        background-color: #f0f0f0;
        width: 50%;
    }
</style>
    <script>
        function checkEnter(event, fun) {
            if (event.keyCode == 13) {
                fun();
            }
        }
        function search() {
            x = document.getElementById("sch").value;

            // Do something with X.
            console.log(x);
        }
    </script>
</head>
<body>
    <div class="top-bar">
        <div class="logo" href="/tt/" ><h1 title="Trash yourself!" href="/tt/">TrashTube</h1></div>
        
        <center class="block">
            Search : <input type="text" id="sch" class="search" style="width: 500px" onkeydown="checkEnter(event, search)" placeholder="Search for videos..." />
        </center>
    </div>
    <center>
 <?php
 session_start();
 if($channelFound){
      $json = file_get_contents("accounts/data/" . $_GET["id"] . ".json");
	  $jsonD = json_decode($json, true);
      $subs = $jsonD["subs"];
      $name = htmlspecialchars($jsonD["username"]);
      $jsonD["about"] = htmlspecialchars($jsonD["about"]);
      $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
      $jsonD["about"] = str_replace("\n", "\n<br />\n", $jsonD["about"]);
      $jsonD["about"] = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $jsonD["about"]);
      $about = $jsonD["about"];
      $joined = $jsonD["joined"];
      $userVideoCount = count($jsonD["videos"]);
      $edit = "";
      if(isset($_SESSION["username"]) && $_SESSION["username"] === $jsonD["username"]){
            $edit = "<a href='accounts/about.php'>(Edit me)</a> ";
      }
      echo "<p>&nbsp;</p><p><img style='border-radius: 128px;' width='128' height='128' src='" . $jsonD["pfp"] . "' /></p><h1>" . $name . "</h1>\n<p>" . $subs . " subscribers</p><p>Joined " . $joined . "</p><p>" . $edit . "<b>About me:</b><div style='text-align: left; padding: 10px; border-radius: 10px; background-color: #f0f0f0; width: 50%;'>" . $about . "</div></p><h2>" . $name . "'s videos</h2>";

      // $data = json_decode($jsonContents, true);
      for($x = 0; $x < $userVideoCount; $x++){
        
        $id = $jsonD["videos"][$x];
        $jsonFile = $id . ".json";
        $jsonContents = file_get_contents("ids/" . $jsonFile);
        $data = json_decode($jsonContents, true);
            if(file_exists("thb/" . $id . ".jpg")){

            // Changed where link goes!
            echo "<div class='video-tile'><a href='view.php?id=" . $id . "'><img src='thb/" . $id . ".jpg' width='320' height='240' /><br />" . htmlspecialchars($data["title"]) . " (" . $data["views"] . " views)</a></div>";
            } else {
                echo "<div class='video-tile'><a title='This video has no thumbnail!' href='view.php?id=" . $id . "'>" . htmlspecialchars($data["title"]) . " (" . $data["views"] . " views)</a></div>";
            }
      }
      echo "<p></p>";
 } else {
      echo "<h1>Oops! That channel doesn't exist</h1>";
 }
 ?>
<p><a href="index.php">Back to videos</a></p>
    </center>
    <font color="#808080">Copyright &copy; HxOr1337/(*DripDog*) 2021 - <?php echo date("Y"); ?></font>
</body>
</html>