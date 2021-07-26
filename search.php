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