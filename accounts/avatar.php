<?php
    session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){

}
else {
    header("Location: ../");
    die();
}
if($_SERVER['REQUEST_METHOD'] === "POST") {

    
    
    $target_dir = "avatar/";
    $target_file = $target_dir . $_SESSION['username'] . ".png";
    $file = $target_file;
    // echo($file);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
     //  echo("Target file: " . $target_file . "<br>");
      setcookie("chat_path", $file, time()+3600);
      $imag = $target_file;
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        // echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
      // echo "Sorry, file already exists.";
    //  $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 50000000000000000000000000) {
      // echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "bmp" ) {
      // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      echo('<script>window.alert("This file type is not allowed. Please make sure your file is in format JPG, JPEG, PNG, or gif."></script>');
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
       /*
            header('Location: https://chromebookgang.tk/chat/uploadcontent.php'); # REDIRECT THAT SHIT
        header('HTTP/1.0 308 Permanent Redirect') # SET THE FUCKING STATUS CODE
        exit(); # EXIT THAT SHIT
        */
    
    // Just to cut your ass short, My shit didnt fucking work
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
       
        
         $imagePath = $imag;
    $newImagePath = $imag;
    $newImageQuality = 100; // The compression quality of the new image to be created from 0 (worst) to 100 (best).
    
    // Load the original image into memory.
    $image = imagecreatefromjpeg($imagePath);
    
    // If the image was loaded successfully, then recreate the image.
    if($image) {
       // Recreate the image without the EXIF metadata.
       // Print an error if it failed to create the new image.
       if(imagejpeg($image, $newImagePath, $newImageQuality))
          echo "The new image was created successfully without the EXIF metadata.";
       else
          echo "The new image failed to be created. Make sure that the new folder path has write permissions set properly.";
       
       // Clear the original image from memory.
       imagedestroy($image);
    
       // You can also delete the original image from file storage if it wasn't stored in the /tmp folder earlier.
    } else {
       // If the image failed to be created, then print an error message.
       echo "Unable to open the original image. Make sure that it exists.";
       header("Location: ?uploaded=true");
    }
           
      } else {
        // echo "Sorry, there was an error uploading your file.";
      }
    }

  //  die();
}
if(isset($_GET['uploaded'])) {
    if($_GET['uploaded'] === "true") {
         echo("Your avatar has been updated successfully.");
    }
}
?>
<form action="avatar.php" method="post" enctype="multipart/form-data">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>