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
		<title>Manage User Activity</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>
<script language="javascript">
			function selectRole() {
				var selRole = window.document.userActivityForm.selRole.value;
				window.location.replace(location.pathname+"?selRole="+selRole);
			}
		</script>

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
				<p class="title">Manage User Activity
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <?php
								$selectedRole = $_GET['selRole'];
								$selectedUser = $_POST['selUser'];
								echo userActivities($selectedRole, $selectedUser);
								if($_POST) {
									if($_POST['submit'] == 'Delete') {
										$activityArray = $_POST['id'];
										$arrayLength = count($activityArray);
										for($i = 0; $i < $arrayLength; $i++){
											$currentId = $activityArray[$i];
											$deleteQuery = "DELETE FROM useractivities WHERE id='$currentId'";
											mysql_query($deleteQuery);
										}
									}
									$selectedUser = $_POST['selUser'];
									$userActivityQuery = "SELECT * FROM useractivities WHERE username = '$selectedUser' ORDER BY creationdate DESC";
									$userActivityResult = mysql_query($userActivityQuery);
									$userActivityRows = mysql_num_rows($userActivityResult);
									if($userActivityRows != 0) {
										echo '<form method="post" name="search">';
										if($_POST['submit'] == 'Suggestions') {
											echo '<table style="font-family:calibri; width:100%; margin-left:30px; background: rgb(216,216,216); color:rgb(14,71,33);">';
											echo '<tr /><tr /><tr /><tr /><tr /><tr /><tr>';
											echo '<td width="5%"></td>';
											echo '<td width="20%"><b>Suggestions: </b></td>';
											echo '<td width="70%"><textarea cols="60" rows="10" name="message"></textarea></td>';
											echo '<td width="5%"></td></tr><tr /><tr /><tr /><tr /><tr /><tr />';
											echo '<tr><td colspan=2 width="25%"></td>';
											echo '<td style="text-align:right" width="70%"><input type="submit" value="Store" name="submit" id="z" /></td>';
											echo '<td width="5%"></td></tr><tr /><tr /><tr /><tr /><tr /><tr />';
											echo '</table><br>';
										}
										if($_POST['submit'] == 'Store'){
											$touser = $_POST['selUser'];
											$fromuser = $_SESSION['username'];
											$fromuserfullname = $_SESSION['fullName'];
											$creationDate = date("Y-m-d G:i:s");
											$suggestion = $_POST['message'];
											$suggestion = str_replace("'","\'",$suggestion);
											$suggestionsQuery = "INSERT INTO ua_suggestions (touser, fromuser, fromuserfullname, creationdate, suggestion) VALUES ('$touser', '$fromuser', '$fromuserfullname', '$creationDate', '$suggestion')";
											mysql_query($suggestionsQuery) or die ("Your suggestion was not registered");
											echo '<p style="font-family: Calibri; padding: 0px; color: #BB0000; font-size: 18px; line-height: 30px; font-weight: bold;">&emsp;&emsp;&emsp;Your Suggestion is registered successfully !!!</p>';
										}
										echo '&emsp;&emsp;&emsp;<input type="submit" value="Delete" name="submit" id="z" />';
										echo '&emsp;<input type="submit" value="Suggestions" name="submit" id="z" /><br><br>';

										echo '<table style="cellspacing:0px; cellpadding:0px; border:0px; width:100%"><tr>';
										echo '<td width="5%"></td>';
										echo '<td class="tab_facultyheader" width="5%">&nbsp;</td>';
										echo '<td class="tab_facultyheader" width="25%"><u><center>Date and Time</center></u></td>';
										echo '<td class="tab_facultyheader" width="60%"><u><center>Activity</center></u></td>';
										echo '<td width="15%"></td></tr>';
										for($i = 0;$i < $userActivityRows;$i++) {
											$activityArray = mysql_fetch_array($userActivityResult);
											echo '<tr><td width="5%"></td>';
											echo '<td width="5%" class="tab_faculty"><center><input name="id['.$id.']" type="checkbox" value="'.$activityArray['id'].'"></center></td>';
											echo '<td class="tab_faculty" width="25%">&nbsp;&nbsp;'.$activityArray['creationdate'].'</td>';
											echo '<td class="tab_faculty" width="60%">&nbsp;&nbsp;'.$activityArray['activity'].'</td>';
											echo '<td width="15%"></td></tr>';
										}
										echo '</table><br>';
										echo '&emsp;&emsp;&emsp;<input type="hidden" value="'.$selectedUser.'" name="selUser" id="z" />';
										echo '<input type="submit" value="Delete" name="submit" id="z" />';
										echo '&emsp;<input type="submit" value="Suggestions" name="submit" id="z" /><br><br>';
										echo '</form>';
									} else {
									
									}	
									echo "<b>&nbsp;&nbsp;&nbsp;</b>";
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
