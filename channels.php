<?php
        $dir = "accounts/data/";
        $videos = scandir($dir);
        // var_dump($videos);
        // echo $videos[2];
        $nov = count($videos);
        for($x = 2; $x < $nov; $x++){
            $jsonFile = $videos[$x];
           // if(!$jsonFile === ".htaccess") { 
            $id = str_replace(".json", "", $jsonFile);
           
            $jsonContents = file_get_contents("accounts/data/" . $jsonFile);
         $data = json_decode($jsonContents, true);
         $username = htmlspecialchars($data['username']);
         ///    $title = htmlspecialchars($data["title"]);
           // if(file_exists("thb/" . $id . ".jpg")){

            // Changed where link goes!
            echo "<div class='channel-tile'><a href='channel.php?id=" . $id . "'><img style='border-radius: 90000px;' width='50' height='50' src='avatar.php?id=$id'><span>$username</span></a></div>";
         //   } else {
            //    echo "<div class='video-tile'><a title='This video has no thumbnail!' href='view.php?id=" . $id . "'>" . $title . " (" . $data["views"] . " views)</a></div>";
          //  }
     //   }
    }
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrashTube 2.0">