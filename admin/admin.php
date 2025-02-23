<?php
$conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error($conn));
mysqli_select_db($conn,'poll') or die(mysqli_error($conn));

session_start();
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP Polling System</title>
	<link href="css/admin_styles.css" rel="stylesheet" type="text/css" />
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="tan">   
<center><b><font color="#000" size="6">PHP Polling System</font></b></center><br><br>
<div id="page">
	<div id="header">
		<h1>ADMINISTRATION CONTROL PANEL</h1><hr/>
		<ul class="nav navbar-nav"><li><a href="admin.php"><h1>Home</h1></a></li><li><a href="manage-admins.php"><h1>Manage Administrators</h1></a></li><li><a href="positions.php"><h1>Manage Positions</h1></a></li><li><a href="candidates.php"><h1>Manage Candidates</h1></a></li><li><a href="refresh.php"><h1>Poll Results</h1></a></li><li><a href="logout.php"><h1>Logout</h1></a></li></ul>
	</div>
<p align="center">&nbsp;</p>
	<div id="container">
		<p>Click a link above to perform an administrative operation.</p>
	</div>
</div>
</body>
</html>