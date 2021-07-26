<?php
if(!isset($_GET['page'])) { die(""); }
if(file_exists("config.json")) {
    $config = json_decode(file_get_contents("config.json"), true);
    if($config['installed'] === "yes") { header("Location: " . $config['path']); die(); } // Check if TT is already installed
  if($_GET['page'] === "welcome") {
      echo("<title>EzSetup</title>");
      echo("<h3>Welcome to the TT EzSetup!</h3>");
      echo("<p>Click Next to go to the next page.</p>");
      echo("<a href='?page=configure'>Next</a>");
  }
  if($_GET['page'] === "configure") {
    echo("<title>EzSetup</title>");
      echo("<h3>TT EzSetup - Configure</h3>");
      echo("<form action='?page=install' method='POST'>");
      echo("<label for='path'>Path:</label> <input require name='path' placeholder='Path' value='" . dirname(htmlspecialchars($_SERVER['PHP_SELF'])) . "'><br>");
      echo("<label for='name'>Name:</label> <input require name='name' placeholder='Name'><br>");
      echo("<input type='submit' value='Install'>");
      echo("</form>");
  }
  if($_GET['page'] === "install") {
     if(empty($_POST['path'])) { die("Please put a path."); }
     if(empty($_POST['name'])) { die("Please put a name."); }
     
     $newconfig = array("installed" => "yes", "path" => $_POST["path"], "name" => $_POST["name"]);
     $json2 = json_encode($newconfig);
    // die($json2);
     file_put_contents("config.json", $json2);
     echo("Installed. Click <a href='index.php'>here</a> to go to your new TT");
     if(file_exists("ids/deleteme.txt")) { unlink("ids/deleteme.txt"); }
  }
}
else {
  die("Unable to find config.json. Please redownload from <a href='https://github.com/HotPizzaYT/TrashTube'>https://github.com/HotPizzaYT/TrashTube</a>");
}
