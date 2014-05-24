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
<title>Manage help Content</title>

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
				<p class="title">Manage Help Content
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
    <?php
							$roleListQuery = "SELECT * FROM mst_table WHERE type_id='ROLE'";
							$roleListResult = mysql_query($roleListQuery);
							$selectedRole = $_POST['selectRole'];
							echo '<br><form id="searchform" method="post"  action="manageHelpContent.php">';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;<select name="selectRole">';
							while($line = mysql_fetch_array($roleListResult)){
								$id = $line['value'];
								echo '<option value="'.$id.'"';
								if($id == $selectedRole){
									   echo ' selected';
								}
								echo '>'.$id.'</option>';
							}
							echo '</select>';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Get Help Content" id="z"></form><br>';
							if($_POST['subValue'] == 'Get Help Content'){
								$helpContentQuery = "SELECT * FROM help_content WHERE designation='$selectedRole'";
								$helpContentResult = mysql_query($helpContentQuery) or die ("Cannot find the required table in database");
								echo '<div class="entry">';
								echo '<br><table cellspacing=5px style="font-size:12px; color: #BB0000; font-weight:none; margin-left:10px; margin-right:10px">';
								while($line = mysql_fetch_assoc($helpContentResult)){
									echo '<tr><td><b><u>'.$line['link_name'].'</u></b>:</td>';
									echo '<td>'.$line['help_text'].'</td></tr><tr /><tr />';
								}
								echo '</table>';
								echo '<br><form id="searchform" method="post" style="" action="manageHelpContent.php">';
								echo '<input type="hidden" name="selectRole" value="'.$selectedRole.'">';
								echo '<input type="submit" name="subValue" value="Edit" id="z">';
								echo '</form>';
								echo '</div>';
							} elseif ($_POST['subValue'] == 'Edit' || $_POST['subValue'] == 'Add New Link'){
								if ($_POST['subValue'] == 'Add New Link'){
									$newRows = $_POST['newRows'] + 1;
								} else {
									$newRows = 0;
								}
								echo '<br><form id="searchform" method="post" style="margin-right:50px" action="manageHelpContent.php">';
								$helpContentQuery = "SELECT * FROM help_content WHERE designation='$selectedRole'";
								$helpContentResult = mysql_query($helpContentQuery) or die ("Cannot find the required table in database");
								echo '<div class="entry">';
								echo '<br><table cellspacing=5px style="font-size:12px; color: #BB0000; font-weight:none; margin-left:10px; margin-right:10px">';
								while($line = mysql_fetch_assoc($helpContentResult)){
									echo '<tr><td><b><u>'.$line['link_name'].'</u></b>:</td>';
									echo '<td><input type="text" name="'.$line['link_name'].'" size="80" value="'.$line['help_text'].'"/></td></tr><tr /><tr />';
								}
								$newlyAddedLinkName = $_POST['newLinkName'];
								$newlyAddedHelpText = $_POST['newHelpText'];
								for($j = 0; $j < $newRows; $j++){
									echo '<tr><td><input type="text" name="newLinkName[]" size="10" value="'.$newlyAddedLinkName[$j].'"/></td>';
									echo '<td><input type="text" name="newHelpText[]" size="80" value="'.$newlyAddedHelpText[$j].'"/></td></tr><tr /><tr />';									
								}
								echo '</table><br>';
								echo '<input type="hidden" name="selectRole" value="'.$selectedRole.'">';
								echo '<input type="hidden" name="newRows" value="'.$newRows.'">';
								echo '<input type="reset" name="Reset" value="Reset" id="z">';
								echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Store" id="z">';
								echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Add New Link" id="z">';
								echo '</form>';
								echo '</div>';
							} elseif ($_POST['subValue'] == 'Store'){
								$insertedRows = 0;
								$updatedRows = 0;
								$originaldatetime = date("Y-m-d H:i:s");
								$time = 19800;
								$creationDate= strtotime($originaldatetime) + $time;
								$createdOn = date("Y-m-d",$creationDate);
								while(list($key,$value) = each($_POST)) {
									$value = stringReplacement($value);
									$key = str_replace("_"," ",$key);
									if($key != 'selectRole' && $key != 'subValue' && $key != 'newLinkName' && $key != 'newHelpText' && $key != 'newRows') {
										$existingRows = mysql_num_rows(mysql_query("SELECT * FROM help_content WHERE designation='$selectedRole' AND link_name='$key'"));
										if($existingRows > 0){
											$updateQuery = "UPDATE help_content set help_text='$value' WHERE designation='$selectedRole' AND link_name='$key'";
											mysql_query($updateQuery) or die ('Cannot update the statement to database.');
											$updatedRows++;
										} else {
											$insertQuery = "INSERT INTO help_content (`designation`, `link_name`, `help_text`, `creation_date`) VALUES ('$selectedRole','$key','$value','$createdOn')";
											mysql_query($insertQuery) or die ('Cannot insert the statement into database.');
											$insertedRows++;
											$activityDate = date("Y-m-d G:i:s");
											$activityMsg = 'Updated Help Content for '.$selectedRole;
											$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
											mysql_query($userActivityQuery);
										}
									}
								}
								$arrayLength = count($_POST['newHelpText']);
								if ($arrayLength > 0) {
									$newLinkName = $_POST['newLinkName'];
									$newHelpText = $_POST['newHelpText'];
									for($j = 0; $j < $arrayLength; $j++){
										$linkName = $newLinkName[$j];
										$linkName = stringReplacement($linkName);
										$helpText = $newHelpText[$j];
										$helpText = stringReplacement($helpText);
										$insertQuery = "INSERT INTO help_content (`designation`, `link_name`, `help_text`, `creation_date`) VALUES ('$selectedRole','$linkName','$helpText','$createdOn')";
										mysql_query($insertQuery) or die ('Cannot insert the statement into database.');
										$insertedRows++;
									}
									$activityDate = date("Y-m-d G:i:s");
									$activityMsg = 'Updated Help Content for '.$selectedRole;
									$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
									mysql_query($userActivityQuery);
								}
								echo '<br><br><p style="font-size:15px; color:#BB0000; margin-left:80px; font-weight:bold">Updated '.$updatedRows.' records and inserted '.$insertedRows.' new records !!!</p>';
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
