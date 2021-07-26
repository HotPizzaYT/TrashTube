<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>TrashTube - Home</title>
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
<form action="upload.php" method="post" enctype="multipart/form-data">
Select a video to upload:
<input type="file" name="video" id="video">
<br>
<p>Uploader (Optional)</p>

<input type="text" name="uploader" value="<?php
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){
// You can't disable this or it won't go through!
// Good thing though is that it'll still add to user acc.
echo $_SESSION["username"] . "\" disabled=\"true";
} else {
echo "Anonymous";
} ?>" />
<p>Title (Required)</p>
<input type="text" required name="title" >
<p>Description (Required)</p>
<textarea required name="desc" style="width: 50%; height: 300px"></textarea>
<p>Location (Optional)</p>
<input type="text" name="location">
<p><input type="submit" value="Upload video" name="submit"></p>
</form>
<button onclick="document.location = '/tt'">Nevermind</button>
</center>
<?PHP
require_once 'thb/generateTN.php';
$iplogging = false;

// It won't hurt to leave this enabled, even when you don't have the proper libraries to do so.
// It'll show up as a button and will have to be clicked on user end anyway.

$generateTN = true;
function generateVideoID($length = 16){
	$characters = "01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++){
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
   

  if(!empty($_FILES['video']) && !empty($_POST["title"]) && !empty($_POST["desc"]))
  {

    // Set this to true to bypass.
    $isConfirmedVideo = false;
    if(isset($_FILES['video']['tmp_name']) && !empty(FILEINFO_MIME_TYPE)) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['video']['tmp_name']);
        $extension = explode(".", $_FILES['video']['name']);
        $end = count($extension) - 1;
        $ext = $extension[$end];
        // echo $ext;
        $filetype = explode("/", $mime);
        
        // Insert all supported video types.

        // Added m4v for converted HandBrake videos.
        if ($ext == 'mp4' || $ext == 'mov' || $ext == 'avi' || $ext == 'mkv' || $ext == 'mpeg4' || $ext == 'mpeg' || $ext == 'm4v') {
        // This measure prevents hackings from happening. It also limits users on what type of video they can post.    
        $isConfirmedVideo = true;
        }
    finfo_close($finfo);
    } else {
        echo "No video selected";
    }

    if($_POST["location"] !== ""){
        // That's fine.
    } else {
        $_POST["location"] = "Not set";
    }
    if($isConfirmedVideo){
    $path = "videos/";
    $path = $path . basename( $_FILES['video']['name']);

    // $comments = array();
    // Create a blank array with no comments.
    $commentData = array();
    if(isset($_POST["uploader"]) && $_POST["uploader"] !== ""){
        $uploader = $_POST["uploader"];
    } else {
        if(isset($_SESSION["username"])){
            $uploader = $_SESSION["username"];
        } else {
            $uploader = "Anonymous";
        }
    }
 
    $videoData = array("title"=>$_POST["title"], "desc"=>$_POST["desc"], "location"=>$_POST["location"], "src"=>$path, "uploader" => $uploader, "likes"=>0, "dislikes"=>0, "views"=>0, "comments"=>$commentData);

    $idlength = rand(8, 16);

    $videoId = generateVideoID($idlength);
    $vidDstring = json_encode($videoData);
    file_put_contents("ids/". $videoId . ".json", $vidDstring);
    if(isset($_SESSION["username"]) && isset($_SESSION["email"])){
        // Add video to profile.
        $vidarr = ["videos"=>[$videoId]];
        $accTxt = file_get_contents("accounts/data/" . $_SESSION["username"] . ".json");
        $accJson = json_decode($accTxt, true);
        // Add video to array of videos.
        array_push($accJson["videos"], $videoId);
        // Save to file.
        $accFinal = json_encode($accJson);
        file_put_contents("accounts/data/" . $_SESSION["username"] . ".json", $accFinal);
    }

    } else {
        echo "Your video has not been uploaded. REASON: ";
    }
    
    if($isConfirmedVideo){
        if(move_uploaded_file($_FILES['video']['tmp_name'], $path)) {
        // I have no idea if this will work.
        $th = ". Thumbnail generation is turned off.";
        if($generateTN){
        $gurl = "thb/generateTN.php?id=" . $videoId;

        // Function to generate thumbnail!
        // thumbRequest($videoId);
        // Purposely error so we can run a script immediately
        $th = ". <img src='purposeerror.png' onerror='fetch(\"" . $gurl . "\")' alt='Generated a thumbnail.' />";
        }
        

            echo "Video uploaded <a href='view.php?id=". $videoId . "'>here</a>" ;
            echo $th;
        } else{
            echo "There was an error uploading the file, please try again!";
        }
    } else {
        echo "You either have not added a video to upload or that format is unsupported by TrashTube.";
    }
  } else {
        if(!empty($_FILES['video']) && (!empty($_POST["title"]) || !empty($_POST["desc"]))){
            echo "Not all fields have been filled in.";
        }
  }
?>
</body>
</html>