<?php
if(!isset($_GET['q'])) {
    echo('<html>
   <head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search</title><script>
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
<center class="block">
Search : <input type="text" id="sch" class="search" style="width: 500px" onkeydown="checkEnter(event, search)" placeholder="Search for videos..." />
</center>
</body>
</html>');
die();
}
$s = substr($_GET['q'], 0, 4);
$chn = substr($_GET['q'], 0, 9);
$chn2 = substr($_GET['q'], 0, 8);
if($s === "loc:") {
    $newquery = $_GET['q'];
    $newquery = str_ireplace("loc:", "?q=", $newquery);
  header("Location: location.php$newquery");
 //  $cn = file_get_contents("location.php$newquery");
    die();
}
if($chn === "channels:") {
    $newquery = $_GET['q'];
    $newquery = str_ireplace("channels:", "", $newquery);
    if($newquery === "all") {
        header("Location: channels.php");
    }
    else {
        die("No results.");
    }
}
if($chn === "channel:") {
    $newquery = $_GET['q'];
    $newquery = str_ireplace("channel:", "", $newquery);
       if(file_exists("accounts/data/$newquery.json")) {
           header("Location: channel.php?id=$newquery");
       }
       else {
           die("No results.");
       }
}
//die($s);
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
           // Search for string in video     
          // echo $num;
          // $x2 = $num;
          // echo($x2);
     //     $data['title'] = str_ireplace("'", "", $data['title']);
        //  $data['title'] = str_ireplace(" ", "", $data['title']);
        $data['title'] = str_replace(array("\r", "\n", "\r\n", "\v", "\t", "\0","\x"), "", $data['title']);
        $q = $data['title'];
if (strpos($data['title'], $_GET['q']) !== false) {
   // echo $id . ": " . $data['title'] . "<br>";
   $GLOBALS['result'] = "yes";
   if(file_exists("thb/" . $id . ".jpg")){

    // Changed where link goes!
    echo "<div class='video-tile'><a href='view.php?id=" . $id . "'><img src='thb/" . $id . ".jpg' width='320' height='240' /><br />" . $data["title"] . " (" . $data["views"] . " views)</a></div>";
    } else {
        echo "<div class='video-tile'><a title='This video has no thumbnail!' href='view.php?id=" . $id . "'>" . $data["title"] . " (" . $data["views"] . " views)</a></div>";
    }
}

else {
    if(@$GLOBALS['result'] === "yes") {

    }
    else {
        die("No results.");
    }
   // $x2 = count($videos);
  //  echo($x2);
   // $x2 = $x2 - 1;
 //  echo($x2);
   // if($x2 === 0) {
     //   die("No results.");
   // }
  //  echo $id . ": No results.<br>";
}
       }
/*
       foreach ($json->people as $item) {
    if ($item->id == "8097") {
        echo $item->content;
    }
}
*/