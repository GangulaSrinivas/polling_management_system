<?php
	$conn = mysqli_connect("localhost","root","");
if (!$conn)
  {
  die('Could not connect: ' . mysqli_error($conn));
  }
mysqli_select_db($conn,"poll");
?>
<?php
    $candidate_arr = array();

if (isset($_POST['Submit'])){   
	$position = addslashes( $_POST['position'] );
	// echo "SELECT * FROM tbCandidates where candidate_position='$position'";
    $results = mysqli_query($conn,"SELECT * FROM tbcandidates where candidate_position='$position'");
    // $row1 = mysqli_fetch_array($results);
    // $row2 = mysqli_fetch_array($results);
// if ($row1){
//     $candidate_name_1=$row1['candidate_name'];
//     $candidate_1=$row1['candidate_cvotes'];
//     }
// if ($row2){
//     $candidate_name_2=$row2['candidate_name'];
//     $candidate_2=$row2['candidate_cvotes'];
//     }
    while($row = mysqli_fetch_assoc($results)){
    	$candidate_arr[$row['candidate_id']] = $row;
    }
}
    else
?> 
<?php
	$positions=mysqli_query($conn,"SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysqli_error($conn)); 
?>
<?php
session_start();
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}
?>
<?php// if(isset($_POST['Submit'])){$totalvotes=$candidate_1+$candidate_2;} ?>
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
		<h1>POLL RESULTS </h1>
		<a href="admin.php">Home</a> | <a href="manage-admins.php">Manage Administrators</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="logout.php">Logout</a>
	</div>
	<div id="container">
	<table width="420" align="center">
	<form name="fmNames" id="fmNames" method="post" action="refresh.php" onsubmit="return positionValidate(this)">
	<tr>
		<td>Choose Position</td>
		<td><SELECT NAME="position" id="position">
		<OPTION VALUE="select">select
		<?php
		while ($row=mysqli_fetch_array($positions)){
		echo "<OPTION VALUE='{$row['position_name']}' ".( isset($_POST['position'] ) && $row['position_name'] == $_POST['position'] ? 'selected' : '').">$row[position_name]"; 
		}
		?>
		</SELECT></td>
		<td><input type="submit" name="Submit" value="See Results" /></td>
	</tr>
	</form> 
	</table>
<?php 
$total_votes = 0;
foreach($candidate_arr as $row){
	$total_votes += $row['candidate_cvotes'];
}
foreach($candidate_arr as $k => $row){
	$perc = $row['candidate_cvotes'] >0 ? round($row['candidate_cvotes']/($total_votes)*100,2) : 2;
?>
<img src="images/candidate-1.gif"
width='<?php echo $perc ?>'
height='20'/> %
<br>
<?php echo (round($row['candidate_cvotes']/($total_votes)*100,2)) .'% / '. $row['candidate_cvotes'] .' votes for '. $row['candidate_name'] ?>
<br>
<br>
<?php } ?>

<!-- <?php if(isset($_POST['Submit'])){echo $candidate_name_1;} ?>:<br>
<img src="images/candidate-1.gif"
width='<?php if(isset($_POST['Submit'])){ if ($candidate_2 || $candidate_1 != 0){echo(100*round($candidate_1/($candidate_2+$candidate_1),2));}} ?>'
height='20'>
<?php if(isset($_POST['Submit'])){ if ($candidate_2 || $candidate_1 != 0){echo(100*round($candidate_1/($candidate_2+$candidate_1),2));}} ?>% of <?php if(isset($_POST['Submit'])){echo $totalvotes;} ?> total votes
<br>votes <?php if(isset($_POST['Submit'])){ echo $candidate_1;} ?>
<br>
<br>
<?php if(isset($_POST['Submit'])){ echo $candidate_name_2;} ?>:<br>
<img src="images/candidate-2.gif"
width='<?php if(isset($_POST['Submit'])){ if ($candidate_2 || $candidate_1 != 0){echo(100*round($candidate_2/($candidate_2+$candidate_1),2));}} ?>'
height='20'>
<?php if(isset($_POST['Submit'])){ if ($candidate_2 || $candidate_1 != 0){echo(100*round($candidate_2/($candidate_2+$candidate_1),2));}} ?>% of <?php if(isset($_POST['Submit'])){echo $totalvotes;} ?> total votes
<br>votes <?php if(isset($_POST['Submit'])){ echo $candidate_2;} ?> -->
	</div>
</div>
</body>
</html>