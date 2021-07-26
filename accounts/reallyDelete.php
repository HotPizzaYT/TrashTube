<?php
session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["email"])){

if(file_exists("data/" . $_SESSION["username"] . ".json")){
	unlink("data/" . $_SESSION["username"] . ".json");
}

unset($_SESSION["username"]);
unset($_SESSION["email"]);
?>
Account deleted.
<?php } else { ?>
You don't have an account!
<?php } ?>
