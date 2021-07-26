<?php
session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["email"]) && !isset($_POST["old"]) && !isset($_POST["new"])){

?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TrashTube 2.0">
<title>Change password</title>
<form action="changePass.php" method="post" enctype="multipart/form-data">
<h1>Change your password</h1>
<p>Old password</p>
<input type="password" name="old" required>
<p>New password</p>
<input type="password" name="new" required>
<p><input type="submit" name="submit" value="Change password"></p>
</form>

<a href="acc.php">Nevermind</a>
<?php
} else {
if(isset($_POST["old"]) && isset($_POST["new"])){
// Code to change password!
$json = file_get_contents("data/" . $_SESSION["username"] . ".json");
$jsonD = json_decode($json, true);
$passHash = $jsonD["password"];
if(password_verify($_POST["old"], $passHash)){
// Password verified!
// Set the brand new password
$jsonD["password"] = password_hash($_POST["new"], PASSWORD_DEFAULT);
$newAccDetails = json_encode($jsonD);
file_put_contents("data/" . $_SESSION["username"] . ".json", $newAccDetails);
echo "Congratulations, your brand new password is \"" . $_POST["new"] . "\"!";
echo "<br />You will now be logged out for security reasons.";
echo "<br />" . $jsonD["password"];
unset($_SESSION["username"]);
unset($_SESSION["email"]);


} else {
echo "Wrong password. <a href='changePass.php'>Click here to try again</a>";
}

} else {
echo "x";
}
} ?>