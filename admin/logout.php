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
		<h1>Logged Out Successfully </h1>
		<p align="center">&nbsp;</p>
	</div>
<?
session_start();
session_destroy();
?>
You have been successfully logged out of your control panel.<br><br><br>
Return to <a href="login.html">Login</a>
</div>
</body>
</html>