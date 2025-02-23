<?php
	$link = $conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error($conn));
mysqli_select_db($conn,'poll') or die(mysqli_error($conn));

session_start();
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}
	$result=mysqli_query($conn,"SELECT * FROM tbCandidates")
or die("There are no records to display ... \n" . mysqli_error($conn)); 
if (mysqli_num_rows($result)<1){
    $result = null;
}
?>
<?php
	$positions_retrieved=mysqli_query($conn,"SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysqli_error($conn)); 
?>
<?php
if (isset($_POST['Submit']))
{
	$newCandidateName = addslashes( $_POST['name'] );
	$newCandidatePosition = addslashes( $_POST['position'] );
	$sql = mysqli_query($conn, "INSERT INTO tbCandidates(candidate_name,candidate_position) VALUES ('$newCandidateName','$newCandidatePosition')" )
        or die("Could not insert candidate at the moment". mysqli_error($conn) );

 header("Location: candidates.php");
}
?>
<?php
if (isset($_GET['id']))
 {
 $id = $_GET['id'];
 $result = mysqli_query($conn,"DELETE FROM tbCandidates WHERE candidate_id='$id'")
 or die("The candidate does not exist ... \n");
 header("Location: candidates.php");
 }
 else
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP Polling System</title>
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/admin_styles.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="js/admin.js"></script>
</head>
<body bgcolor="tan">
<center><b><font color="#000" size="6">PHP Polling System</font></b></center><br><br>
<div id="page">
	<div id="header">
		<h1>MANAGE CANDIDATES</h1><hr/>
		<a href="admin.php">Home</a> | <a href="manage-admins.php">Manage Administrators</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="logout.php">Logout</a><hr/>
	</div>
	<div id="container">
	<table width="380" align="center">
	<CAPTION><h3>ADD NEW CANDIDATE</h3></CAPTION>
	<form name="fmCandidates" id="fmCandidates" action="candidates.php" method="post" onsubmit="return candidateValidate(this)">
	<tr>
		<td>Candidate Name</td>
		<td><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td>Candidate Position</td>
		<?php// echo $positions_retrieved; ?></td>
		<td><SELECT NAME="position" id="position">select
		<OPTION VALUE="select">select
		<?php
		while ($row=mysqli_fetch_array($positions_retrieved)){
		echo "<OPTION>$row[position_name]";
		}
		?>
		</SELECT>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="Submit" value="Add" /></td>
	</tr>
	</table>
	<hr>
	<table border="0" width="620" align="center">
	<CAPTION><h3>AVAILABLE CANDIDATES</h3></CAPTION>
	<tr>
		<th>Candidate ID</th>
		<th>Candidate Name</th>
		<th>Candidate Position</th>
	</tr>
	<?php
	while ($row=mysqli_fetch_array($result)){
	echo "<tr>";
	echo "<td>" . $row['candidate_id']."</td>";
	echo "<td>" . $row['candidate_name']."</td>";
	echo "<td>" . $row['candidate_position']."</td>";
	echo '<td><a href="candidates.php?id=' . $row['candidate_id'] . '">Delete Candidate</a></td>';
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