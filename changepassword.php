<?php session_start()
?>
<!DOCTYPE HTML>
<html>
<body>
<h2><font face="sans-serif">Change Password</font></h2>
<!--on submit, the form will post to itself with act=true-->
<form action="changepassword.php?act=true" method="post">
	<table cellpadding="2" cellspacing="2" borde="0">
		<tr>
			<td>Existing Password</td>
			<td><input type="password" value="" name="old"/></td>
		</tr>
		<tr>
			<td>New Password</td>
			<td><input type="password" value="" name="new"/></td>
		</tr>
		<tr>
			<td>Retype New Password</td>
			<td><input type="password" value"" name="repeat"/></td>
		</tr>
		<tr>
			<td><input type="submit" value="change!" name="submit"/></td>
		</tr>
</table>
</form>

<?php
//include db.php that has secure info and connect to database
require'db.php';

try
	{
        $dbh = new PDO('mysql:host=localhost; dbname=mcurry_grcc', $dbuser, $dbpassword);
        echo "Connected to the Database.";  
    }
   		catch(PDOException $e) {
   		die("Error!:" .$e->getMessage());
    }
//if the user fills in all the information, the form posts to itself with act=true
//if act=true, then this script will begin
if ($_GET["act"] == "true")  
{
	
	//if submit was clicked
	if (isset($_POST["submit"]))
	{
		//varialbes defined with password with 
		$user=$_SESSION["username"];
		$old=($_POST["old"]);
		$new=($_POST["new"]);
		$repeat=($_POST["repeat"]);


		//if the old, new, and retyped new passwords all match...
		if ($old && $new && $repeat)
		{
			//...then we create a database object $dbh and a query, $sql, to query the database 
			$dbh = new PDO('mysql:host=localhost; dbname=mcurry_grcc', $dbuser, $dbpassword);
			$query1="SELECT * FROM members WHERE username= :user and password= :old LIMIT 1";

			//prepare the statement
			$statement=$dbh->prepare($query1);

			//bind parameters
			$statement->bindParam(':user', $user, PDO::PARAM_STR);
			$statement->bindParam(':old', $old, PDO::PARAM_STR);

			//execute
			$statement->execute();


			//fetch() returns the row
			$row=$statement->fetch();
			//or..not sure??
			//$row=$statement->fetch(PDO::FETCH_ASSOC);
			
			{
				//...name $dbpass...
				$dbpass = $row["password"];
			}
				//...and if the old password matches what the database has on record...
			if ($old == $dbpass)
			{
				//...and if the new password entered matches the retyped password entered...
				if($new == $repeat)
				{
					//...then we define the new query to update the database with the retyped password replacing the old
					//only where the username row matches user's
					$query2="UPDATE members SET password=:repeat WHERE username=:user";

					//prepare the statement
					$statement=$dbh->prepare($query2);

					//bind parameters
					//$statement->bindParam(':new', $new, PDO::PARAM_STR);
					$statement->bindParam(':user', $user, PDO::PARAM_STR);
					$statement->bindParam(':repeat', $repeat, PDO::PARAM_STR);

					//echo $old,$new,$repeat;
					//execute
					$statement->execute();

					
					//then we will echo a javascript alerting of the successfull change
					//this needs to be modified so it doesn't print if there's no password change
					//won't accept an if statement here for some reason
					echo "<script>
						alert('Your password has been successfully changed!');
						</script>
						<meta http=equiv='refresh' content='1;url=login_success.php'>";
						//header("location:main_login.php");
					//}	
					/*else
					{
						echo "Your password did not update.";
					}*/
				}

				//... if the new password and retyped don't match, this message will be displayed
				else
				{
					echo "Your new password and repeat password entries do not match.";
				}
			}

			//...if the password entered ($old) doesn't match the database records, this message will be displayed
			else
			{
				echo "The existing password you entered does not match our records.";
			}
		}

		//...if all fields are not filled in, then this message will be displayed
		else
		{
			echo "Please fill in all the fields.";
		}
	}
}


?>
</body>
</html>
