<?php


// Replace ffmpeg libraries.

require 'vendor/autoload.php';
$host = "unknown";
if(file_exists("bin/ffmpeg.exe") && file_exists("bin/ffprobe.exe"))
{
$ffmpeg = FFMpeg\FFMpeg::create(array(
    'ffmpeg.binaries'  => 'bin/ffmpeg.exe',
    'ffprobe.binaries' => 'bin/ffprobe.exe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    
));
$host = "windows";
} else {
if(file_exists("/opt/local/ffmpeg/bin/ffmpeg") && file_exists("/opt/local/ffmpeg/bin/ffprobe")){
    // Linux host detected.
    $ffmpeg = FFMpeg\FFMpeg::create(array(
    'ffmpeg.binaries'  => '/opt/local/ffmpeg/bin/ffmpeg',
    'ffprobe.binaries' => '/opt/local/ffmpeg/bin/ffprobe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    
));
$host = "linux";
} else {

    $host = "error";
}
}

if(isset($_GET["id"]) && file_exists("../ids/" . $_GET["id"] . ".json") && $host !== "error"){
	$jsonPath = "../ids/" . $_GET["id"] . ".json";
    $json = file_get_contents($jsonPath);
	$jsonD = json_decode($json, true);
    $src = "../" . $jsonD["src"];
    echo "Opening " . $src;
	// $ffmpeg = FFMpeg\FFMpeg::create();
    $video = $ffmpeg->open($src);
    $video
    ->filters()
    ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
    ->synchronize();
    $video
    ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(0.5))
    ->save($_GET["id"] . '.jpg');
    echo "<br />Saved the thumbnail. Here it is:<br /> <img src='" . $_GET["id"] . ".jpg' />";
} else {
    if(isset($_GET["id"]) && $host === "error"){
    echo "<font color='red'>[ERROR]:</font> FFMpeg and FFProbe libraries not found! Please install them. If you are using Windows, please put these libraries in bin/. These libraries on Windows are around 110MB each.";
    } else {
        if(isset($_GET["id"]) && $host !== "error"){
            echo "<font color='red'>[ERROR]:</font> That video ID has not been found!";
        } else {
        // Commented out due to being required in upload.php
        // echo "What are you doing here?";
        }
    }
}





// API
function thumbRequest($id){
    if(file_exists("bin/ffmpeg.exe") && file_exists("bin/ffprobe.exe"))
{
$ffmpeg = FFMpeg\FFMpeg::create(array(
    'ffmpeg.binaries'  => 'bin/ffmpeg.exe',
    'ffprobe.binaries' => 'bin/ffprobe.exe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    
));
$host = "windows";
} else {
if(file_exists("/opt/local/ffmpeg/bin/ffmpeg") && file_exists("/opt/local/ffmpeg/bin/ffprobe")){
    // Linux host detected.
    $ffmpeg = FFMpeg\FFMpeg::create(array(
    'ffmpeg.binaries'  => '/opt/local/ffmpeg/bin/ffmpeg',
    'ffprobe.binaries' => '/opt/local/ffmpeg/bin/ffprobe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    
));
$host = "linux";
} else {

    $host = "error";
}
}

if(isset($id) && file_exists("ids/" . $id . ".json") && $host !== "error"){
	$jsonPath = "ids/" . $id . ".json";
    $json = file_get_contents($jsonPath);
	$jsonD = json_decode($json, true);
    $src = $jsonD["src"];
    // echo "Opening " . $src;
	// $ffmpeg = FFMpeg\FFMpeg::create();
    $video = $ffmpeg->open($src);
    $video
    ->filters()
    ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
    ->synchronize();
    $video
    ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(0.5))
    ->save("/thb" . $id . '.jpg');
    // echo "<br />Saved the thumbnail. Here it is:<br /> <img src='" . $id . ".jpg' />";
} else {
    if(isset($_GET["id"]) && $host === "error"){
    echo "<font color='red'>[ERROR]:</font> FFMpeg and FFProbe libraries not found! Please install them. If you are using Windows, please put these libraries in bin/. These libraries on Windows are around 110MB each.";
    } else {
        if(isset($_GET["id"]) && $host !== "error"){
            echo "<font color='red'>[ERROR]:</font> That video ID has not been found!";
        } else {
        // echo "What are you doing here?";
        }
    }
}
}
