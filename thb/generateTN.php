<?php
$generateSWF = false;

// Replace ffmpeg libraries.

require 'vendor/autoload.php';
$host = "unknown";
if(file_exists("bin/ffmpeg.exe") && file_exists("bin/ffprobe.exe"))
{
// Import FFMpeg
$ffmpeg = FFMpeg\FFMpeg::create(array(
    'ffmpeg.binaries'  => 'bin/ffmpeg.exe',
    'ffprobe.binaries' => 'bin/ffprobe.exe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    
));
// Import FFProbe
$ffprobe = FFMpeg\FFProbe::create(array(
    'ffmpeg.binaries'  => 'bin/ffmpeg.exe',
    'ffprobe.binaries' => 'bin/ffprobe.exe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    
));
$mpegpath = dirname(__FILE__) . "/bin/ffmpeg.exe";
$probepath = dirname(__FILE__) . "/bin/ffprobe.exe";
$host = "windows";
} else {
if(file_exists("/opt/local/ffmpeg/bin/ffmpeg") && file_exists("/opt/local/ffmpeg/bin/ffprobe")){
    // Linux host detected.

    // Import FFMpeg
    $ffmpeg = FFMpeg\FFMpeg::create(array(
    'ffmpeg.binaries'  => '/opt/local/ffmpeg/bin/ffmpeg',
    'ffprobe.binaries' => '/opt/local/ffmpeg/bin/ffprobe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    
));
    
    // Import FFProbe
    $ffprobe = FFMpeg\FFProbe::create(array(
    'ffmpeg.binaries'  => '/opt/local/ffmpeg/bin/ffmpeg',
    'ffprobe.binaries' => '/opt/local/ffmpeg/bin/ffprobe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    
));
$mpegpath = "/opt/local/ffmpeg/bin/ffmpeg";
$probepath = "/opt/local/ffmpeg/bin/ffmpeg";

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

    // Does request have custom timecode?
    if(isset($_GET["tc"])){

    // Custom timecode has been set.
    
        $video
        ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($_GET["tc"]))
        ->save($_GET["id"] . '.jpg');

    } else {  
        // $ffprobe = FFMpeg\FFProbe::create();
        $duration = $ffprobe->format($src)->get('duration');
        // Try to get frame that's in the middle of the video
        $middle = $duration / 2;
        echo $middle;
        $video
        ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($middle))
        ->save($_GET["id"] . '.jpg');


        // Save MP4 as SWF
        // This is done for devices such as the Nintendo Wii.
        $relativeSrc = dirname(__FILE__) . "/../" . $jsonD["src"];
        $csrc = str_replace("videos/", "videos/conv_", dirname(__FILE__) . "/../" . $jsonD["src"]);
        // echo $csrc;
/*
// This code is changing extension, but it isn't used, so I'll comment it out.
        $extension = explode(".", $csrc);
        $extlast = count($extension) - 1;
        $extfinal = $extension[$extlast];
*/
        $convertedName = $csrc;
        $videosRelative = dirname(__FILE__) . "/../videos";
        $outputRelative = dirname(__FILE__) . "/";

        // Check if SWF conversion is turned on
        if($generateSWF){
        $videotoswf = $mpegpath . " -i \"". $relativeSrc . "\" -ar 44100 \"" . $outputRelative . $_GET["id"] . ".swf\"";
        echo($videotoswf);
        exec($videotoswf, $output, $return_var);
        var_dump($output);
        var_dump($return_var);
        }
        // Convert to the H.264 codec
        echo "<br/>Converting video...<br />";
        $conversion = $mpegpath . " -i \"" . $relativeSrc . "\" -d libx264 -ar 44100 \"" . $csrc . "\"";
        exec($conversion, $cout, $cret);
        var_dump($cout);
        var_dump($cret);
        echo "<br />" . $conversion;

    }
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