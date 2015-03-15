<?php
//connect to database
require 'db.php';

	try
	{
        $dbh = new PDO('mysql:host=localhost; dbname=mcurry_grcc', $dbuser, $dbpassword);
        echo "Connected to the Database.";  
    }
   		catch(PDOException $e) {
   		die("Error!:" .$e->getMessage());
    }

$tbl_name = "members"; // table name

// if the  username field is filled in...
if (isset($_POST['username'])) 
{
	//username and password sent from form
	$username = $_POST['username'];
	$password = $_POST['password'];

	//.. then create a query that returns information for the members table
	$sql = "SELECT * FROM $tbl_name WHERE username=$username and password=$password LIMIT 1";
	$result->query($sql);

	//count the number of rows returned by the select query
	$count = PDOStatement::rowCount($sql);

		//if the number of rows returned is only one (only one member of the table)...
		if ($count == 1) 
		{

			//register $username, $password and redirect to file "login_success.php" if information is valid
			// else it gets error message and script stops
			session_register("username");
			session_register("password");
			header("location:login_success.php");
		} 
		else 
		{
			echo "Invalid login information. Please return to the previous page.";
			exit();
		}
}

?>

<!DOCTYPE HTML>
<html>
<table width = "300" border = "0" align = "center" cellpadding = "0" cellspacing = "1" bgcolor = "#CCCCCC">
	<tr>
	<form name = "form1" method = "post" action = "login_success.php">
		<td>
		<table width = "100%" border = "0" cellpadding = "3" cellspacing = "1" bgcolor = "#FFFFFF">

			<tr>
				<td colspan = "3"> <strong>Admin Login</strong></td>
			</tr>

			<tr>
				<td width = "78">Username</td>
				<td width = "6">:</td>
				<td width = "294"><input name = "username" type = "text" id = "username">
				</td>
			</tr>

			<tr>
					<td>Password</td>
					<td>:</td>
					<td><input name = "mypassword" type = "password" id = "password"></td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input type = "submit" name = "submit" value = "Login"></td>
			</tr>
</table>
		</td>
	</form>
	</tr>
</table>
</html>
