<?php

require "../db/connector.php";
include '../classes/burger.php';

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
	echo "<head>";
	echo "<meta charset='utf-8' />";
	echo "<title>User Page</title>";
	echo "<script src=\"../javascript/sliding_menu.js\"></script>";
	echo "<link rel='stylesheet' type='text/css' media='screen' href='../css/styleb.css' />";
echo "</head>";
echo "<body>";
	createBurger();

	echo "<nav>";
	  echo "<span>";
		echo "<span style='font-size:30px;cursor:pointer;position:relative;' onclick='openNav()'>&#9776;";
		echo "</span>";
	  echo "</span>";
	echo "</nav>";

	echo "<main  class='centered'>";
	echo "<h2>User Page</h2>";


	if (isset($_SESSION["email"]) && isset($_SESSION["name"]) && isset($_SESSION["address"])) {
		// logged in
		showUserInfo();
	} elseif (isset($_POST["email"])) {
		// not logged in
		// post data
		$email = getDB()->escape_string($_POST["email"]);
		$pw = md5($_POST["password"]);

		if (login($email, $pw)) {
			$values = getUserData($email);

			$_SESSION["email"] = $email;
			$_SESSION["name"] = $values[0];
			$_SESSION["address"] = $values[1];
			showUserInfo();
		} else {
			echo "<p>".t("loginError")."<a href='./login.php".add_param($url,'lang',$_GET['lang'])."'>".t('tryAgain')."</a>";
			// login failure
		}
	} else {
		echo "<p>".t('inproperAccess')."</p>";
		// not logged in
		// no post data
	}


	echo "</main>";
echo "</body>";



function showUserInfo() {
	echo "<p>".t('logSucc')."</p>";

	echo "<h3>".t('name')."</h3>";
	echo "<p>".$_SESSION["name"]."</p>";
	echo "<h3>".t('address')."</h3>";
	echo "<p>".$_SESSION["address"]."</p>";

	echo "<form class='bottom' action='../home.php' method='post'>";
		echo "<input type='hidden' name='logout' value='1'>";
		echo "<input type='submit' value='Logout'>";
	echo "</form>";


}
