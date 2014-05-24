<?php
    include_once "dbconnect.php";
    include_once "myPhpFunctions.php";
    include_once "staticCalendar.php";
	    include_once "jfunctions.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Store</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
           	$username = $_SESSION['username'];
			$password = $_SESSION['password'];

			$designation = $_SESSION['designation'];

			
			$imageFileExten = '.jpg';
			$imageFileName = $username.$imageFileExten;
			
			  function getQuotation1(){
	            $maxQuery = "SELECT max(id) 'MV' FROM quotation";
	            $maxValue = mysql_fetch_array(mysql_query($maxQuery));
	            $randomNum = rand(1,$maxValue['MV']);
	            $quoteQuery = "SELECT * FROM quotation WHERE id='$randomNum'";
	            $quoteResult = mysql_fetch_assoc(mysql_query($quoteQuery));
	            return $quoteResult['quotation'].'  -  <font color="#BB0000"><i>'.$quoteResult['author'].'</i></font>';
	        }

			$imageFileExten = '.jpg';
			$imageFileName = $username.$imageFileExten;
			
			if($username){
			?>
            
           
<div>


 <?php
echo mainBar();
?>

</div>

<div id="main">
<div id="leftsidebar" >
 


</div>
 <?php
echo rightbar();
?>


<div id="middle" align="center">
<div class="pagegrey">
<div id="pageheader" class="headergrey">
				<p class="title">Inventory
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
 <ul>
								<li class="current_page_item"><a href="store.php">Store</a></li>
								<li><a href="requested.php">Requested</a></li>
								<li><a href="issued.php">Issued</a></li>
							</ul><br><br>
							<form id="searchform" method="post" action="store.php">
								<input type="text" name="s" size="20" value="<?php echo $_POST['s']; ?>">
								<?php
									if($_POST['mybox'] == 'resourceId') {
										echo '<input type="radio" name="mybox" value="resourceId" CHECKED>Resource Id&nbsp;&nbsp;';
									} else {
										echo '<input type="radio" name="mybox" value="resourceId">Resource Id&nbsp;&nbsp;';
									}
									if($_POST['mybox'] == 'resource') {
										echo '<input type="radio" name="mybox" value="resource" CHECKED>Resource&nbsp;&nbsp;';
									} else {
										echo '<input type="radio" name="mybox" value="resource">Resource&nbsp;&nbsp;';
									}
								?>
								<input type="submit" value="Search" id="z">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="reset" value="Reset" id="z">
							</form><br>
							<?php
								if($_POST) {
									$columnName = $_POST['mybox'];
									$columnValue = '%'.$_POST['s'].'%';
									$query = "SELECT * FROM inventory WHERE $columnName LIKE '$columnValue'";
									$queryResult = mysql_query($query);

									$fields_num = mysql_num_fields($queryResult);
									echo '<form method="post" action="requestResource.php"><br>';
									echo '<table cellpadding=5 cellspacing=1 style="color:rgb(19,77,91); font-size: 14px;  margin-left:0px; width:100%; float:left;">';
									echo '<tr><td width="0%"></td>';
									echo '<td width="10%" style="background-color: rgb(19,77,91); color:white;">&nbsp;</td>';
									echo '<td width="15%" style="background-color: rgb(19,77,91); color:white;" align="center"><b>Resource ID</b></td>';
									echo '<td width="25%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Resource Name</b></td>';
									echo '<td width="20%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Initial Inventory</b></td>';
									echo '<td width="20%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Available Copies</b></td></tr>';
									if(mysql_num_rows($queryResult) != 0) {
										while($row = mysql_fetch_assoc($queryResult)) {
											echo '<tr>';
											echo '<tr><td width="0%"></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="10%">';
											echo '<input type="checkbox" name="resource" value="'.$row['resourceId'].'"></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" width="15%" align="center">';
											echo '<b>'.$row['resourceId'].'</b></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" width="25%">';
											echo '<b>'.$row['resource'].'</b></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
											echo '<b>'.$row['total_copy'].'</b></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
											echo '<b>'.$row['avail_copy'].'</b></td>';
											echo '</tr>';
										}
									} else {
										echo '<tr><td width="0%"></td><td colspan=5 align="center" class="cell1"><b>No requests left.</b></td></tr>';
									}
									echo '</table><br>';
									if($designation == 'admin') {
										echo '</form>';
									} else {
										echo"<input type='submit' name='request' value='Request' id='z'>";
										echo"&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='reset' value='Reset' id='z'></form>";
									}

								} else {
									$query = "SELECT * FROM inventory";
									$queryResult = mysql_query($query);
									if(mysql_affected_rows() == 0){
										print "<table cellspacing=1><tr><td class='tab_mailbox'>No records found in the database !!!</td></tr></table>\n";
									} else {
										$fields_num = mysql_num_fields($queryResult);
										echo '<form method="post" action="requestResource.php"><br>';
										echo '<table cellpadding=5 cellspacing=1 style="color:rgb(19,77,91); font-size: 14px;  margin-left:0px; width:100%; float:left;">';
										echo '<tr><td width="0%"></td>';
										echo '<td width="10%" style="background-color: rgb(19,77,91); color:white;">&nbsp;</td>';
										echo '<td width="15%" style="background-color: rgb(19,77,91); color:white;" align="center"><b>Resource ID</b></td>';
										echo '<td width="25%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Resource Name</b></td>';
										echo '<td width="20%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Initial Inventory</b></td>';
										echo '<td width="20%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Available Copies</b></td></tr>';
										while($row = mysql_fetch_assoc($queryResult)) {
											echo '<tr><td width="0%"></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="10%">';
											echo '<input type="checkbox" name="resource" value="'.$row['resourceId'].'"></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" width="15%" align="center">';
											echo '<b>'.$row['resourceId'].'</b></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" width="25%">';
											echo '<b>'.$row['resource'].'</b></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
											echo '<b>'.$row['total_copy'].'</b></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
											echo '<b>'.$row['avail_copy'].'</b></td>';
											echo '</tr>';
										}
										echo '</table><br>';
										if($designation == 'admin') {
											echo '</form>';
										} else {
											echo"<input type='submit' name='request' value='Request' id='z'>";
											echo"&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='reset' value='Reset' id='z'></form>";
										}
									}
								}
							?>
</div>
</div>
		</div>
		<?php
			} else {
		?>
		 <?php
						 loginbox();
						 ?>
		<?php
			}
		?>
        
        <div class="quote" align="center">
                <?php
				echo getQuotation1();
				?>
                </div>
                
		    <div class="footer">
            Powered By ChrisTel Info Solutions (P) Ltd.
        </div>
</body>
</html>
