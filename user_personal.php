<?php
require_once "conn.php";
session_start();
$id=$_SESSION['id']; ?>
<html>
<head>
<title>Personal Information</title>
</head>
<body>
<h1>Welcome to your personal information area</h1>
<p>
	Here you can update your personal information,
	or delete your account.<br>
	Your information as you currently have it is shown below:<br>
	<a href="index.php">Click here</a> to return to the home page<br><br>
<?php

$query = "SELECT * FROM it_people WHERE person_id= '" .$id . "' ";
$result = mysql_query($query)
  or die(mysql_error());
$row = mysql_fetch_array($result);
?>
	First Name: <?php echo $id; ?><br>
	First Name: <?php echo $row['person_firstname']; ?><br>
	Last Name: <?php echo $row['person_firstname']; ?><br>
	Email: <?php echo $row['person_firstname']; ?><br><br>
	<a href="update_account.php">Update Account</a> |
	<a href="delete_account.php">Delete Account</a>
</p>
</body>
</html>