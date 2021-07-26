<title>Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<form action="register.php" method="post" enctype="multipart/form-data">
<h1>Register for an account</h1>
<p>Username:</p>
<input type="text" maxlength="16" required name="username" >
<p>Password:</p>
<input type="password" required name="password" >
<p>Email:</p>
<input type="email" required name="email" >
<input type="submit" name="submit" value="Register" >
</form>
<a href="index.php">I already have an account!</a>

<?php

function genchannel($length = 16){
	$characters = "0123456789abcdef";
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++){
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


if(isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["password"]) && $_POST["password"] !== "" && isset($_POST["email"]) && $_POST["email"] !== ""){
	if(!file_exists("data/" . $_POST["username"] . ".json") && !preg_match_all('/([<>\[\]\(\).,\/\\&?$=!%^#* ])/', $_POST["username"])){
	$passHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
	$channame = ($_POST["username"]) . "_" . genchannel(16);
	$details = array("username" => $_POST["username"], "password" => $passHash, "email" => $_POST["email"], "cid" => $channame, "subs" => 0, "about" => "I have not yet filled this in!", "subscribers" => array(), "joined" => date("m/d/Y (M/D), H:i:s"), "pfp" => "accounts/default.png", "videos" => array());
	$detailsEncoded = json_encode($details, true);
	file_put_contents("data/" . $_POST["username"] . ".json", $detailsEncoded);
	echo "<p>SUCCESS: Account created successfully!</p>";
	} else {
		echo "<p>ERROR: That account already exists or contains symbols! (<>[]().,/\\&?$=!%^#*)</p>";
	}
}
?>