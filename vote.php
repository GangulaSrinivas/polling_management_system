<?php
$conn = mysqli_connect('localhost', 'root', '') or die("Connection Failed");
mysqli_select_db($conn,'poll') or die(mysqli_error($conn));

session_start();
if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
}
?>
<?php
	$positions=mysqli_query($conn,"SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysqli_error($conn)); 
?>
<?php
if (isset($_POST['Submit']))
{
	$position = addslashes( $_POST['position'] );
	$result = mysqli_query($conn,"SELECT * FROM tbCandidates WHERE candidate_position='$position'")
or die(" There are no records at the moment ... \n"); 
}
else
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP Polling System</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/user_styles.css" rel="stylesheet" type="text/css" />   
	<script language="JavaScript" src="js/user.js"></script>
	<script language="JavaScript" src="js/jquery-1.2.6.min.js"></script>
<script type="text/javascript">
function getVote(int)
{
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

xmlhttp.open("GET","save.php?vote="+int,true);
xmlhttp.send();
}

function getPosition(String)
{
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

xmlhttp.open("GET","vote.php?position="+String,true);
xmlhttp.send();
}
</script>
<script type="text/javascript">
$(document).ready(function(){
   var $ = jQuery.noConflict();
    $(document).ready(function()
    {
       // setInterval(function(i){
       //      $.ajax({
       //        url: "admin/refresh.php",
       //        cache: false,
       //        success: function(html){
       //          $(".refresh").html(html);
       //        }
       //      })
       //  },1000)
        
    });
   $('.refresh').css({color:"green"});
});
</script>
</head>
<body bgcolor="tan">    
<center><b><font color="#000" size="6">PHP Polling System</font></b></center><br><br>
<div id="page">
	<div id="header">
		<h1>CURRENT POLLS</h1><hr/>
		<ul class="nav navbar-nav"><li><a href="student.php"><h1>Home</h1></a></li><li><a href="vote.php"><h1>Current Polls</h1></a></li><li><a href="manage-profile.php"><h1>Manage My Profile</h1></a></li><li><a href="logout.php"><h1>Logout</h1></a></li></ul>
	</div>
	<div class="refresh"></div>
	<div id="container">
		<table width="420" align="center">
		<form name="fmNames" id="fmNames" method="post" action="vote.php" onsubmit="return positionValidate(this)">
		<tr>
			<td>Choose Position</td>
			<td><SELECT NAME="position" id="position" onclick="getPosition(this.value)">
	 		<OPTION VALUE="select">select
		<?php 
		while ($row=mysqli_fetch_array($positions)){
		echo "<OPTION ".( isset($_POST['position'] ) && $row['position_name'] == $_POST['position'] ? 'selected' : '').">$row[position_name]"; 
		}
		?>
				</SELECT></td>
			<td><input type="submit" name="Submit" value="See Candidates" /></td>
		</tr>
		</form> 
		</table>
		<table width="270" align="center">
		<form>
		<tr>
			<th>Candidates:</th>
		</tr>
		<?php
		if (isset($_POST['Submit'])){
		while ($row=mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>" . $row['candidate_name']."</td>";
		echo "<td><input type='radio' name='vote' value='$row[candidate_name]' onclick='getVote(this.value)' /></td>";
		echo "</tr>";
		}
		mysqli_free_result($result);
		mysqli_close($conn);
		  }
		else
		?>
		</form>
		</table>
</div>

</body>
</html>