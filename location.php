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
          if(@$data['location'] === @$_GET['q']) {
            if(file_exists("thb/" . $id . ".jpg")){

                // Changed where link goes!
                echo "<div class='video-tile'><a href='view.php?id=" . $id . "'><img src='thb/" . $id . ".jpg' width='320' height='240' /><br />" . $title . " (" . $data["views"] . " views)</a></div>";
                } else {
                    echo "<div class='video-tile'><a title='This video has no thumbnail!' href='view.php?id=" . $id . "'>" . $title . " (" . $data["views"] . " views)</a></div>";
                }
          }
        }
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">