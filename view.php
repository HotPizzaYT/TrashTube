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
session_start();
    ?>
<!DOCTYPE html>
<html>
<head>
	<?php
    if(isset($_GET['action'])) {
        if($_GET['action'] === "share") {
            $id = htmlspecialchars($_GET['id']);
if(!isset($_GET['id'])) { die("No video ID specified."); }
if(!file_exists("ids/$id.json")) {
die("Video does not exist.");
}
$videoinfo = json_decode(file_get_contents("ids/$id.json"), true);
$title = htmlspecialchars($videoinfo['title']);
function getUrlScheme() {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { 
        return("https");
        } 
        else {
            return("http");
        }
}
if(isset($_SERVER['HTTPS']) && 
            $_SERVER['HTTPS'] === 'on')
    $link = "https";
    else
        $link = "http";
  
$link .= "://";
$link .= $_SERVER['HTTP_HOST'];
$link .= $_SERVER['PHP_SELF'];
$link .= "?id=$id&ref=share";
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){
    $username = $_SESSION["username"];
    $link .= "&user=$username";
}
$linknew = htmlspecialchars($link);
//echo $link;
        echo("
        <html>
        <head>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Share Video</title>
        </head>
        <body>
        <center>
        <h3>Share this video ($title)</h3>
        <p>URL:</p>
        <input value='$linknew'>
        <p>Email:</p>
        <a href='mailto:friend@example.com?subject=You have recieved a TrashTube Video&body=$link'>Send Email</a>
        ");
die();
        }
    }
	if(isset($_GET["id"])){

if(file_exists("ids/" . $_GET["id"] . ".json")){
	// Video exists;
	$json = file_get_contents("ids/" . $_GET["id"] . ".json");
	$jsonD = json_decode($json, true);
} else {
		$jsonD = array("title" => "Video not found", "desc" => "Unfortunately, we could not find that video.");
}
	} else {
		$jsonD = array("title" => "ID not set", "desc" => "The ID is not set, therefore we cannot display a video.");
	}
	?>
<title><?php echo htmlspecialchars($jsonD["title"]); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($jsonD["desc"]); ?>">

<!-- Insert polyfill -->
	<script src="http://api.html5media.info/1.1.8/html5media.min.js"></script>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
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
            // Disable logging in search for the sake of old browsers.
		// console.log(x);
        }
        function x(){
            <?php
            if(isset($_GET["s"])){
                echo 'document.getElementsByTagName("video")[0].currentTime = "' . $_GET["s"] . '";';
                
            } else {
		// Comment that out for the sake of old browsers.
                echo "// console.log('No time.');";
            }
            ?>
            
            // Remember the video's time
            loadTime();
            window.ct = setInterval(function(){
                window.cur = document.getElementsByTagName("video")[0].currentTime;
                window.neverExpire = "; expires=Fri, 31 Dec 9999 23:59:59 GMT;";
                document.cookie = "time=" + window.cur + window.neverExpire;
            }, 100)


            
        }

                function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
            // console.error("Tried to read undefined cookie.")
        }

        function loadTime(){
        x = getCookie("time");
        y = eval(x);
            document.getElementsByTagName("video")[0].currentTime = y;
        }
    </script>
</head>
<body onload="x()">
    <div class="top-bar">
        <a href="." style="color: #000;"><div class="logo" href="/tt/" ><h1 title="Trash yourself!" href="/tt/">TrashTube</h1></div></a>
        
        <center class="block">
            Search : <input type="text" id="sch" class="search" style="width: 500px" onkeydown="checkEnter(event, search)" placeholder="Search for videos..." />
        </center>
    </div>
<?php

$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
if(isset($_GET["id"])){

if(file_exists("ids/" . $_GET["id"] . ".json")){
	// Video exists;
	$json = file_get_contents("ids/" . $_GET["id"] . ".json");
	$jsonD = json_decode($json, true);
    
    // Add a view

    $jsonD["views"] = $jsonD["views"] + 1;
    $viewFix = json_encode($jsonD, true);
    file_put_contents("ids/" . $_GET["id"]. ".json", $viewFix);

    // End add a view.

	$vt = $jsonD["title"];
    $desc = htmlspecialchars($jsonD["desc"]);
	$vd = str_replace("\n", "<br />", $desc);
    // AutoHyperLink
    $vd = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $vd);
	$src = $jsonD["src"];
	$dislikes = $jsonD["dislikes"];
	$likes = $jsonD["likes"];
	$views = $jsonD["views"];
    $loc = htmlspecialchars($jsonD["location"]);
    if($loc === ""){
        $loc = "No location set for this video.";
    }
    $commentsSet = false;
    if(isset($jsonD["comments"])){
    $comments = $jsonD["comments"];
    // var_dump($comments);

    $commentsSet = true;
    }
    $dlfun = 'fetch("\/tt\/addDislike.php?id=' . $_GET["id"] . '")';
    $lfun = 'fetch("\/tt\/addLike.php?id=' . $_GET["id"] . '")';

    $percentOfLikes = 0;
    $percentOfDislikes = 0;
    $noLD = true;
    if($jsonD["likes"] !== 0 && $jsonD["dislikes"] !== 0){
    $percentOfLikes = ($jsonD["likes"] / ($jsonD["likes"] + $jsonD["dislikes"])) * 100;
    $percentOfDislikes = ($jsonD["dislikes"] / ($jsonD["likes"] + $jsonD["dislikes"])) * 100;
    $noLD = false;
    
    } else {
        if($jsonD["likes"] >= 1 && $jsonD["dislikes"] == 0){
            $percentOfLikes = 100;
            $percentOfDislikes = 0;
            $noLD = false;
        } else {
            if($jsonD["likes"] == 0 && $jsonD["dislikes"] >= 1){
                $percentOfLikes = 0;
                $percentOfDislikes = 100;
                $noLD = false;
            } else {
                if($jsonD["likes"] == 0 && $jsonD["dislikes"] == 0){
                    $noLD = true;
                }
            }
        
        }
    }

    if($percentOfLikes == 0 && $percentOfDislikes == 0){
        $noLD = true;
    }
    // var_dump($noLD);

    // BUG: This doesn't work!
    // Fixed.

    // If likes to dislike ratio are both 0:0, then display a gray bar below the likes and dislikes. Otherwise, show one or two bars comparing them.

    if(!$noLD){
    $likeBar = "<div style='width: " . $percentOfLikes . "px; height: 5px; background-color: #00ff00; display: inline-block;' class='like-ratio'></div><div style='width: " . $percentOfDislikes . "px; height: 5px; background-color: #ff0000; display: inline-block;' class='dislike-ratio'></div>";
    } else {
        $likeBar = "<div style='width: 100px; height: 5px; background-color: #808080; display: inline-block;' class='no-ld'></div>";
    }











    $converted = str_replace("videos/", "videos/conv_", $src);
    if(file_exists($converted)){
    $src = $converted;
    }




    if(file_exists("accounts/data/" . $jsonD["uploader"] . ".json")){
    // Yes!
    $uploader = "<a href='channel.php?id=" . htmlspecialchars($jsonD["uploader"]) . "'>" . htmlspecialchars($jsonD["uploader"]) . "</a>";
    } else {
        $uploader = htmlspecialchars($jsonD["uploader"]);
    }


	$htmlcontent = "<h1>" . htmlspecialchars($vt) . "</h1><div style='text-align: center;'><video style='width: 50%; height: 50%; text-align: center;' src='" . $src . "' controls='' uk-video=''>Whoops! Your browser doesn't support video files.</video></div><br /><br /><br /><div style='float: right; text-align: right;'>Likes: " . $likes . ", Dislikes: " . $dislikes . "<br />" . $likeBar . "<br />"
    
    . $views . " views<br /><button onclick='" . $lfun . "'>Like</button> - <button onclick='" . $dlfun . "'>Dislike</button></div><b>Uploader:</b> " . $uploader . "<br /><b>Location:</b> <a href='location.php?q=$loc'>" . $loc . "</a><br /><b>Description:</b> <br />" . $vd;
    echo $htmlcontent;
    if(@$_SESSION["username"] === htmlspecialchars($jsonD["uploader"])) {
        $studid = $_GET["id"];
        echo("<form action='studio/delete_video.php' method='POST'><input type='text' hidden style='display:none;' name='id' value='$studid'><input type='submit' value='Delete Video'></form>");
    }
    ?>
   <br> <a href="javascript:var popup=window.open('view.php?action=share&id=<?php echo($_GET['id']); ?>', 'share',            'width=600, height=600, location=no, menubar=no,            status=no, toolbar=no, scrollbars=yes, resizable=yes');" tabindex="-1"><button>Share</button></a>
    <?php
    if($commentsSet){
        $commentAmount = count($comments);
        $commentSection = "<h1>Comments (" . $commentAmount . ")</h1><hr>";
        for($x = 0; $x < $commentAmount; $x++){
        // Nobody can hijack comment section.
        $content = htmlspecialchars($comments[$x]["content"]);
        // Hyperlink parser
        // $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
        
        $conurl = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $content);
        $conurl = str_replace("\n", "<br />", $conurl);
            $commentSection .= "<hr><div style='float: right; text-align: right;'><b>Likes:</b> " . $comments[$x]["likes"] . "<br /><b>Dislikes:</b> "  . $comments[$x]["dislikes"] .  "<br /><button onclick=\"fetch('cmtFun.php?vid=" . $_GET["id"] . "&cid=" . ($x) . "&act=like')\">Like</button> - <button onclick=\"fetch('cmtFun.php?vid=" . $_GET["id"] . "&cid=" . ($x) . "&act=dislike')\">Dislike</button></div><h3>" . htmlspecialchars($comments[$x]["poster"]) . "</h3>" . $conurl;
        }
        echo $commentSection;

    } else {
        echo "<h1>Comments on this video have been disabled</h1>";
    }

} else {
	echo "We're sorry, but that video does not exist.";
    $commentsSet = false;
}
} else {
    // Edit this if you want a default video for introduction on the site.
	header("Location: view.php?id=default");
}
?>

<?php if($commentsSet){
?>
<h1>Add a comment</h1>
<form action="addComment.php" method="post" enctype="multipart/form-data">
<p>Your name (required)</p>
<input type="text" required value="<?php if(isset($_SESSION["username"])){ echo $_SESSION["username"] . "\" disabled title=\"You are logged in!"; } else { echo "Anonymous"; } ?>" name="author" id="author">
<input type="hidden" value="<?php echo $_GET["id"]; ?>" name="id">
<br>
<p>Text (Required)</p>
<textarea required name="content" style="width: 50%; height: 300px"></textarea>
<p><input type="submit" value="Post comment" name="submit"></p>
</form>
<?php } else { ?>


<?php } ?>


<center>
<a href="/tt">Back to homepage</a>
</center>
</body>
</html>
