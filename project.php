<?php
session_start();
$a=$_SESSION["id"];
if($_SESSION["logged"]!=1) 
{header("Location: login.php");}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" media="screen" href="style.php">
    <link rel="stylesheet" href="./jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="./jqwidgets/styles/jqx.classic.css" type="text/css" />
     <link rel="stylesheet" href="./jqwidgets/styles/jqx.darkblue.css" type="text/css" />
      <link rel="stylesheet" href="./jqwidgets/styles/jqx.shinyblack.css" type="text/css" />
    <script type="text/javascript" src="./jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="./jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // prepare the data
            var data = {};
			var theme = 'shinyblack';
            var project_name = ["ProjectName", "ProjectName"];
            var project_description = ["ProjectDescription ", "ProjectDescription "];
            var project_issue_num = [0,0];
            var generaterow = function (id) {
                var row = {};
                var project_nameindex = Math.floor(Math.random() * project_name.length);     
                var k = project_nameindex ;

                row["project_id"] = id;
                row["project_name"] = project_name[project_nameindex];
                row["project_description"] = project_description[k];
                row["project_issue_num"] = project_issue_num[k];              
                return row;
            }

            var source =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'project_id'},
					 { name: 'project_name'},
					 { name: 'project_description'},
					 { name: 'project_issue_num'}
                ],
				id: 'project_id',
                url: 'data.php',
                addrow: function (rowid, rowdata) {
                    // synchronize with the server - send insert command
					var data = "insert=true&" + $.param(rowdata);
				       $.ajax({
                            dataType: 'json',
                            url: 'data.php',
                            data: data,
                            success: function (data, status, xhr) {
							   // insert command is executed.
							}
						});							
			    },
                deleterow: function (rowid) {
                    // synchronize with the server - send delete command
            		   var data = "delete=true&project_id=" + rowid;
				       $.ajax({
                            dataType: 'json',
                            url: 'data.php',
                            data: data,
                            success: function (data, status, xhr) {
								 // delete command is executed.
							}
						});							
			   },
                updaterow: function (rowid, rowdata) {
			        // synchronize with the server - send update command
            		   var data = "update=true&project_name=" + rowdata.project_name+ "&project_description=" + rowdata.project_description+ "&project_issue_num=" + rowdata.project_issue_num;
                               data = data + "&project_id=" + rowdata.project_id;
					      $.ajax({
                            dataType: 'json',
                            url: 'data.php',
                            data: data,
                            success: function (data, status, xhr) {
							    // update command is executed.
							}
						});		
                }
            };
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {
                width: 600,
                height: 350,
                selectionmode: 'singlecell',
                source: source,
                theme: theme,
                editable: true,
                columns: [
                      { text: 'project_id', datafield: 'project_id', width: 80 },
                      { text: 'name', datafield: 'project_name', width: 100 },
                      { text: 'description', datafield: 'project_description', width: 320 },
                      { text: 'issue numbers', datafield: 'project_issue_num', width: 100 }
                  ]
            });

            $("#addrowbutton").jqxButton({ theme: theme });
            $("#deleterowbutton").jqxButton({ theme: theme });
            $("#updaterowbutton").jqxButton({ theme: theme });

            // update row.
            $("#updaterowbutton").bind('click', function () {
                var datarow = generaterow();
                var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
                    var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                    $("#jqxgrid").jqxGrid('updaterow', id, datarow);
                }
            });

            // create new row.
            $("#addrowbutton").bind('click', function () {
                var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                var datarow = generaterow(rowscount + 1);
		         $("#jqxgrid").jqxGrid('addrow', null, datarow);
            });

            // delete row.
            $("#deleterowbutton").bind('click', function () {
                var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
                    var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                    $("#jqxgrid").jqxGrid('deleterow', id);
                }
            });
        });
    </script>
</head>
<body class='default'>
 <div id="container">
<?php require('header.php') ?>
<div id="main">
<div id="text">
<h1>Welcome. These are the projects</h1>
 <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
        <div style="float: left;" id="jqxgrid">
        </div>
       <br><br>
    </div>
<h1>Create project</h1>					
<?php
$quote = $_POST["quote"];
$title= $_POST["title"];
$dt1=date("Y-m-d"); 
if (!isset($_POST['submit'])) {
?>
<form method="post" action="<?php echo $PHP_SELF;?>">
<b>Input title of projects:</b>
<input type="text" name="title" /><br />
<b>Enter your description:</b>
<textarea rows="5" cols="20" name="quote" wrap="physical"></textarea>
<input type="submit" value="submit" name="submit"/>
</form>
<?
} else {
define('SQL_HOST','localhost');
define('SQL_USER','onehourb_tracker');
define('SQL_PASS','tracker');
define('SQL_DB','onehourb_itdb');

$con = mysql_connect(SQL_HOST,SQL_USER,SQL_PASS) or
	die('Couldn\'t connect to the DB:' . mysql_error());
mysql_select_db(SQL_DB,$con) or
	die ('Couldn\'t select the DB:' . mysql_error());

mysql_query("INSERT INTO it_project (project_description,project_issue_num,project_name )
VALUES ('$quote', '0','$title')");
mysql_close($con);
echo"You created a new project";
}
?> 
</div>
</div>
<!-- end main -->
<!-- footer -->
<?php require('footer.php')?>
<!-- end footer -->
</div>  
</body>
</html>