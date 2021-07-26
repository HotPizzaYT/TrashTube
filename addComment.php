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
    if(isset($_POST["author"]) && isset($_POST["content"]) && isset($_POST["id"])){
    $id = $_POST["id"];
    $author = $_POST["author"];
    $content = $_POST["content"];
    
    $json = file_get_contents("ids/" . $id . ".json");
	$jsonD = json_decode($json, true);
    $cdata = $jsonD["comments"];
    $cid = count($jsonD["comments"]) + 1;

    $comArr = ["comments" =>["poster"=>$author, "content"=>$content, "likes"=>0, "dislikes"=>0, "cid"=>$cid]];
    // var_dump($comArr);


    // Need to push the ["comments"] to the other comments
    $commentFixed = $comArr["comments"];

    array_push($jsonD["comments"], $commentFixed);
    // These DO work!

    // var_dump($jsonD["comments"]);
    $commentFix = json_encode($jsonD, true);

    // That's SNAXOR!


    header("Location: view.php?id=" . $_POST["id"]);
    // echo "<br>Could not submit your comment. The code in our system simply doesn't work at the moment! Just look at the data above.<br /><a href='view.php?id=" . $_POST["id"] . "'>Go back to the video</a>";
    file_put_contents("ids/" . $_POST["id"]. ".json", $commentFix);
    } else {
        session_start();
        if(isset($_POST["content"]) && isset($_POST["id"]) && !isset($_POST["author"]) && isset($_SESSION["username"])){
        // session_start();
                $id = $_POST["id"];
    $author = $_SESSION["username"];
    $content = $_POST["content"];
    
    $json = file_get_contents("ids/" . $id . ".json");
	$jsonD = json_decode($json, true);
    $cdata = $jsonD["comments"];
    $cid = count($jsonD["comments"]) + 1;

    $comArr = ["comments" =>["poster"=>$author, "content"=>$content, "likes"=>0, "dislikes"=>0, "cid"=>$cid]];
    // var_dump($comArr);


    // Need to push the ["comments"] to the other comments
    $commentFixed = $comArr["comments"];

    array_push($jsonD["comments"], $commentFixed);
    // These DO work!

    // var_dump($jsonD["comments"]);
    $commentFix = json_encode($jsonD, true);

    // That's SNAXOR!


    header("Location: view.php?id=" . $_POST["id"]);
    // echo "<br>Could not submit your comment. The code in our system simply doesn't work at the moment! Just look at the data above.<br /><a href='view.php?id=" . $_POST["id"] . "'>Go back to the video</a>";
    file_put_contents("ids/" . $_POST["id"]. ".json", $commentFix);
        } else {
        echo "Error";
        }
    }
?>