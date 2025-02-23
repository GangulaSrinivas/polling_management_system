<?php
	$link = $conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error($conn));
mysqli_select_db($conn,'poll') or die(mysqli_error($conn));

session_start();
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}
	$result=mysqli_query($conn,"SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysqli_error($conn)); 
if (mysqli_num_rows($result)<1){
    $result = null;
}
?>
<?php
if (isset($_POST['Submit']))
{
	$newPosition = addslashes( $_POST['position'] );
	$sql = mysqli_query($conn, "INSERT INTO tbPositions(position_name) VALUES ('$newPosition')" )
        or die("Could not insert position at the moment". mysqli_error($conn) );
 header("Location: positions.php");
}
?>
<?php
 if (isset($_GET['id']))
 {
	$id = $_GET['id'];
	$result = mysqli_query($conn,"DELETE FROM tbPositions WHERE position_id='$id'")
or die("The position does not exist ... \n"); 
header("Location: positions.php");
}
else
?>
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
		<h1>MANAGE POSITIONS</h1>
		<a href="admin.php">Home</a> | <a href="manage-admins.php">Manage Administrators</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="logout.php">Logout</a>
	</div>
	<div id="container">
	<table width="380" align="center">
	<CAPTION><h3>ADD NEW POSITION</h3></CAPTION>
	<form name="fmPositions" id="fmPositions" action="positions.php" method="post" onsubmit="return positionValidate(this)">
	<tr>
		<td>Position Name</td>
		<td><input type="text" name="position" /></td>
		<td><input type="submit" name="Submit" value="Add" /></td>
	</tr>
	</table>
	<hr>
	<table border="0" width="420" align="center">
	<CAPTION><h3>AVAILABLE POSITIONS</h3></CAPTION>
	<tr>
		<th>Position ID</th>
		<th>Position Name</th>
	</tr>
	<?php
	while ($row=mysqli_fetch_array($result)){
	echo "<tr>";
	echo "<td>" . $row['position_id']."</td>";
	echo "<td>" . $row['position_name']."</td>";
	echo '<td><a href="positions.php?id=' . $row['position_id'] . '">Delete Position</a></td>';
	echo "</tr>";
	}
	mysqli_free_result($result);
	mysqli_close($link);
	?>
	</table>
	<hr>
	</div>
</div>
</body>
</html>