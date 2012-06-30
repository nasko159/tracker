<?php
#Include the connect.php file
include('conn.php');
// get data and store in a json array
$query = "SELECT * FROM it_project";

if (isset($_GET['insert']))
{
	// INSERT COMMAND 
	$insert_query = "INSERT INTO `it_project`(`project_name`, `project_description`, `Title`) VALUES ('".$_GET['project_name']."','".$_GET['project_description']."','".$_GET['project_issue_num']."')";
	
   $result = mysql_query($insert_query) or die("SQL Error 1: " . mysql_error());
   echo $result;
}
else if (isset($_GET['update']))
{
	// UPDATE COMMAND 
	$update_query = "UPDATE `it_project` SET `project_name`='".$_GET['project_name']."',
	`project_description`='".$_GET['project_description']."',
	`project_issue_num`='".$_GET['project_issue_num']."' WHERE `project_id`='".$_GET['project_id']."'";
	 $result = mysql_query($update_query) or die("SQL Error 1: " . mysql_error());
     echo $result;
}
else if (isset($_GET['delete']))
{
	// DELETE COMMAND 
	$delete_query = "DELETE FROM `it_project` WHERE `project_id`='".$_GET['project_id']."'";	
	$result = mysql_query($delete_query) or die("SQL Error 1: " . mysql_error());
    echo $result;
}
else
{
    // SELECT COMMAND
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$employees[] = array(
			'project_id' => $row['project_id'],
			'project_name' => $row['project_name'],
			'project_description' => $row['project_description'],
			'project_issue_num' => $row['project_issue_num']
		  );
	}
	 
	echo json_encode($employees);
}
?>