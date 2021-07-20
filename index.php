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
<!DOCTYPE html>
<html>
<head>
<title><?php echo($name); ?> - Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo($name); ?> 2.0">
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
    try {
        x = document.getElementById("sch").value;

// Do something with X.
console.log(x);
window.location = `search.php?q=${x}`
    }
    catch {
        window.location = "error.php?c=3";
    }
        }
    </script>
</head>
<body>
    <div class="top-bar">
        <div class="logo" href="<?php echo($path); ?>" ><h1 title="<?php echo($name); ?>" href="<?php echo($path); ?>"><?php echo($name); ?></h1></div>
        
        <center class="block">
            Search : <input type="text" id="sch" class="search" style="width: 500px" onkeydown="checkEnter(event, search)" placeholder="Search for videos..." />
        </center>
    </div>
    <center>
    <h2>Here is a list of videos we currently have available for watch.</h2>
        <?php
        $dir = "ids/";
        $videos = scandir($dir);
        // var_dump($videos);
        // echo $videos[2];
        $nov = count($videos);
        for($x = 2; $x < $nov; $x++){
            $jsonFile = $videos[$x];
            $id = str_replace(".json", "", $jsonFile);
           
            $jsonContents = file_get_contents("ids/" . $jsonFile);
            $data = json_decode($jsonContents, true);
             $title = htmlspecialchars($data["title"]);
            if(file_exists("thb/" . $id . ".jpg")){

            // Changed where link goes!
            echo "<div class='video-tile'><a href='view.php?id=" . $id . "'><img src='thb/" . $id . ".jpg' width='320' height='240' /><br />" . $title . " (" . $data["views"] . " views)</a></div>";
            } else {
                echo "<div class='video-tile'><a title='This video has no thumbnail!' href='view.php?id=" . $id . "'>" . $title . " (" . $data["views"] . " views)</a></div>";
            }
        }

        ?>
        
        <br />
        <h3>Want to upload your own video?</h3>
        <a href="upload.php">Go to this link to upload your video!</a>
        <br>
        <div style="background-color: #f0f0f0; width: 50%; border-radius: 16px;">
        <h1>News</h1>
        <?php
        $x = file_get_contents("news.txt");
        $x = str_replace("\n", "<br >", $x);
        echo $x;
        ?>
        </div>
    </center>
    <font color="#808080">Copyright &copy; HxOr1337/(*DripDog*) 2021 - <?php echo date("Y"); ?></font>
</body>
</html>
