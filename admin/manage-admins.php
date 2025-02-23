<!DOCTYPE html>
<html>
<head>
	<title>PHP Polling System</title>
	<link href="css/admin_styles.css" rel="stylesheet" type="text/css" />
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="js/admin.js"></script>
</head>
<body bgcolor="tan">
<center><b><font color="#000" size="6">PHP Polling System</font></b></center><br><br>
<div id="page">
	<div id="header">
		<h1>MANAGE ADMINISTRATORS </h1>
		<a href="admin.php">Home</a> | <a href="manage-admins.php">Manage Administrators</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="logout.php">Logout</a>
	</div>
	<div id="container">
	<?php
	$conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error($conn));
	mysqli_select_db($conn,'poll') or die(mysqli_error($conn));

	session_start();
	if(empty($_SESSION['admin_id'])){
	 header("location:access-denied.php");
	}
	if (isset($_POST['submit']))
	{
		$myFirstName = addslashes( $_POST['firstname'] );
		$myLastName = addslashes( $_POST['lastname'] );
		$myEmail = $_POST['email'];
		$myPassword = $_POST['password'];
		$newpass = md5($myPassword);
		$sql = mysqli_query($conn, "INSERT INTO tbAdministrators(first_name, last_name, email, password) VALUES ('$myFirstName','$myLastName', '$myEmail', '$newpass')" )
				or die( mysqli_error($conn) );
		die( "A new administrator account has been created." );
	}
	if (isset($_GET['id']) && isset($_POST['update']))
	{
		$myId = addslashes( $_GET['id']);
		$myFirstName = addslashes( $_POST['firstname'] );
		$myLastName = addslashes( $_POST['lastname'] );
		$myEmail = $_POST['email'];
		$myPassword = $_POST['password'];
		$newpass = md5($myPassword);
		$sql = mysqli_query($conn, "UPDATE tbAdministrators SET first_name='$myFirstName', last_name='$myLastName', email='$myEmail', password='$newpass' WHERE admin_id = '$myId'" )
				or die( mysqli_error($conn) );
		die( "An administrator account has been updated." );
	}
	?>
	<table align="center">
	<tr>
		<td>
		<form action="manage-admins.php?id=<?php echo $_SESSION['admin_id']; ?>" method="post" onsubmit="return updateProfile(this)">
			<table align="center">
			<CAPTION><h4>UPDATE ACCOUNT</h4></CAPTION>
				<tr>
				<td>First Name:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="firstname" maxlength="15" value=""></td>
				</tr>
				<tr>
				<td>Last Name:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="lastname" maxlength="15" value=""></td>
				</tr>
				<tr>
				<td>Email Address:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="email" maxlength="100" value=""></td>
				</tr>
				<tr>
				<td>New Password:</td><td><input type="password" style="background-color:#999999; font-weight:bold;" name="password" maxlength="15" value=""></td>
				</tr>
				<tr>
				<td>Confirm New Password:</td><td><input type="password" style="background-color:#999999; font-weight:bold;" name="ConfirmPassword" maxlength="15" value=""></td>
				</tr>
				<tr>
				<td>&nbsp;</td><td><input type="submit" name="update" value="Update Account"></td>
				</tr>
			</table>
		</form>
		</td>
		<td>
		<form action="manage-admins.php" method="post" onsubmit="return registerValidate(this)">
			<table align="center">
			<CAPTION><h4>CREATE ACCOUNT</h4></CAPTION>
				<tr>
				<td>First Name:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="firstname" maxlength="15" value=""></td>
				</tr>
				<tr>
				<td>Last Name:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="lastname" maxlength="15" value=""></td>
				</tr>
				<tr>
				<td>Email Address:</td><td><input type="text" style="background-color:#999999; font-weight:bold;" name="email" maxlength="100" value=""></td>
				</tr>
				<tr>
				<td>Password:</td><td><input type="password" style="background-color:#999999; font-weight:bold;" name="password" maxlength="15" value=""></td>
				</tr>
				<tr>
				<td>Confirm Password:</td><td><input type="password" style="background-color:#999999; font-weight:bold;" name="ConfirmPassword" maxlength="15" value=""></td>
				</tr>
				<tr>
				<td>&nbsp;</td><td><input type="submit" name="submit" value="Create Account"></td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
	</table>
	</div>
</div>
</body>
</html>