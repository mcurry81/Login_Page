<?php
session_start();

//define session variables to equal what post variable inputs are
$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];

//prints username in welcome message and has links to logout and to changepassword
if ($_SESSION['username']){
	echo "Welcome, ".$_SESSION['username']."!<br><a href = 'logout.php'>Logout</a><br><a href = 'changepassword.php'>Change Password</a><br><br> ";
	echo "The database would be here if this page were really connected to a database.";
}
else 
{
	die("You must be logged in");
}

?>
