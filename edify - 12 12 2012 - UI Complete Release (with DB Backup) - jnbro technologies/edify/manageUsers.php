<?php
    include_once "dbconnect.php";
    include_once "myPhpFunctions.php";
    include_once "staticCalendar.php";
	    include_once "jfunctions.php";
	require_once('classes/tc_calendar.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Users</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="calendar.js"></script>
       

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
				<p class="title">Manage Users
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <ul>
								<li class="current_page_item"><a href="manageUsers.php">Search User</a></li>
								<li><a href="addNewUser.php">Add New User</a></li>
							</ul><br>
							<?php
								if($designation == 'admin') {
									if($_POST['request'] == 'Get Details'){

										$userSelected = $_POST['userDetail'];
										$userDetailQuery = "SELECT * FROM users WHERE username='$userSelected' AND username <> 'vinod'";
										$userDetailResult = mysql_fetch_assoc(mysql_query($userDetailQuery));
										$userProfileQuery = "SELECT * FROM user_profile WHERE username = '$userSelected' AND username <> 'vinod'";
										$userProfileResult = mysql_fetch_assoc(mysql_query($userProfileQuery));
							?><br>
							<form method="post" name="manageUser">
								<table style="font-family:calibri; width:100%;  background: rgb(216,216,216); color:rgb(14,71,33);">
									<tr /><tr /><tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Username *:</b></td>
										<td width="23%"><b><?php echo $userDetailResult['username']; ?></b></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Password *:</b></td>
										<td width="23%"><input type="text" name="password" value="<?php echo $userDetailResult['password']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Class *:</b></td>
										<td width="23%"><input type="text" name="standard" value="<?php echo $userDetailResult['standard']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Section *:</b></td>
										<td width="23%"><input type="text" name="section" value="<?php echo $userDetailResult['section']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Designation *:</b></td>
										<td width="23%"><input type="text" name="designation" value="<?php echo $userDetailResult['designation']; ?>"></td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr><tr /><tr />
								</table><br>
								<table style="font-family:calibri; width:100%;  background: rgb(216,216,216); color:rgb(14,71,33);">
									<tr /><tr /><tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>First Name *:</b></td>
										<td width="23%"><input type="text" name="first" value="<?php echo $userProfileResult['first']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Middle Name :</b></td>
										<td width="23%"><input type="text" name="middle" value="<?php echo $userProfileResult['middle']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Last Name *:</b></td>
										<td width="23%"><input type="text" name="last_name" value="<?php echo $userProfileResult['last']; ?>"></td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Father's Name *:</b></td>
										<td width="23%"><input type="text" name="father_name" value="<?php echo $userProfileResult['father_name']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Mother's Name *:</b></td>
										<td width="23%"><input type="text" name="mother_name" value="<?php echo $userProfileResult['mother_name']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Email ID :</b></td>
										<td width="23%"><input type="text" name="email_id" value="<?php echo $userProfileResult['email_id']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Contact Number *:</b></td>
										<td width="23%"><input type="text" name="contact" value="<?php echo $userProfileResult['contact']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Address 1 *:</b></td>
										<td width="23%"><input type="text" size=30 name="address1" value="<?php echo $userProfileResult['address1']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Address 2 :</b></td>
										<td width="23%"><input type="text" size=30 name="address2" value="<?php echo $userProfileResult['address2']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Address 3 :</b></td>
										<td width="23%"><input type="text" size=30 name="address3" value="<?php echo $userProfileResult['address3']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>City *:</b></td>
										<td width="23%"><input type="text" name="city" value="<?php echo $userProfileResult['city']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>State *:</b></td>
										<td width="23%"><input type="text" name="state" value="<?php echo $userProfileResult['state']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Pincode *:</b></td>
										<td width="23%"><input type="text" name="pincode" value="<?php echo $userProfileResult['pincode']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Gender *:</b></td>
										<td width="23%"><input type="text" name="gender" value="<?php echo $userProfileResult['gender']; ?>"></td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>DOB <br>(YYYY-MM-DD) *:</b></td>
										<td colspan=2 width="28%">
											<?php
												echo '<b>'.$userProfileResult['dob'].'</b><br>';
												$myCalendar = new tc_calendar("date4", true);
												$myCalendar->setIcon("images/iconCalendar.gif");
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(1970, 2020);
												$myCalendar->writeScript();
											?>
										</td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td colspan=6><b>* required fields ...</b></td>
									</tr><tr /><tr />
								</table><br>
								<input type="hidden" name="userSelected" value="<?php echo $userSelected; ?>">
								<input type="hidden" name="dob" value="<?php echo $userProfileResult['dob']; ?>">
								<input type="hidden" name="flag">
								<input type="submit" onClick="return checkForm();"  name="save" value="Save Details" id="z">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value="Reset" id="z">
							</form>
							<?php
									} elseif ($_POST['flag']) {
										if($_POST['date4'] != '0000-00-00'){
											$dobNew = $_POST['date4'];
										} else {
											$dobNew = $_POST['dob'];
										}
										$userUpdateQuery = "UPDATE users SET password='".$_POST['password']."', standard='".$_POST['standard']."', section='".$_POST['section']."', designation='".$_POST['designation']."' WHERE username ='".$_POST['userSelected']."'";
										$userProfileUpdateQuery = "UPDATE user_profile SET first='".$_POST['first']."', middle='".$_POST['middle']."', last='".$_POST['last_name']."', father_name='".$_POST['father_name']."', mother_name='".$_POST['mother_name']."', email_id='".$_POST['email_id']."', contact='".$_POST['contact']."', address1='".$_POST['address1']."', address2='".$_POST['address2']."', address3='".$_POST['address3']."', city='".$_POST['city']."', state='".$_POST['state']."', pincode='".$_POST['pincode']."', gender='".$_POST['gender']."', standard='".$_POST['standard']."', section='".$_POST['section']."', designation='".$_POST['designation']."', dob='".$dobNew."' WHERE username ='".$_POST['userSelected']."'";
										if(mysql_query($userUpdateQuery)){
											echo "<table class='maintable'><tr class='mainrow'><td class='cell1'>User Detail has been successfully updated in users table.</td></tr></table>";
										} else {
											echo "<table class='maintable'><tr class='mainrow'><td class='cell1'>Cannot update the user detail in users table.</td></tr></table>";
										}
										if(mysql_query($userProfileUpdateQuery)){
											echo "<table class='maintable'><tr class='mainrow'><td class='cell1'>User Detail has been successfully updated in user profile table.</td></tr></table>";
										} else {
											echo "<table class='maintable'><tr class='mainrow'><td class='cell1'>Cannot update the user detail in user profile table.</td></tr></table>";
										}
										mysql_query($userProfileUpdateQuery) or die ('Cannot update the details into user profile table');
										mysql_query($userUpdateQuery) or die ('Cannot update the details into users table');
										$creationDate = date("Y-m-d G:i:s");
										$activityMsg = 'Updated Profile for user '.$_POST['userSelected'];
										$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationDate', '$activityMsg')";
										mysql_query($userActivityQuery);
									} else {
										if($_POST){
											$usersList = mysql_num_rows(mysql_query("SELECT * FROM users WHERE username LIKE '$studentName'"));
										} else {
											$usersList = mysql_num_rows(mysql_query("SELECT * FROM users"));
										}
										$noOfRecords = 10;
										$noOfPages = ceil($usersList/$noOfRecords);
										if($_GET['pageNo'] > 0) {
											$pageNo = $_GET['pageNo'];
											if($noOfPages > 0 && $pageNo >= $noOfPages){
											   $pageNo = $noOfPages - 1;
											}
											$nextPage = $pageNo + 1;
											$previousPage = $pageNo - 1;
											$startRow = ($pageNo*$noOfRecords);
										} else {
											$pageNo = 0;
											$nextPage = $pageNo + 1;
											$previousPage = 0;
											$startRow = 0;
										}
										$roleListQuery = "SELECT * FROM mst_table WHERE type_id='ROLE'";
										$roleListResult = mysql_query($roleListQuery);
										$selectedRole = $_POST['selectRole'];
										echo '<br><form id="searchform" method="post" action="manageUsers.php">';
										echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="s" size="20" value="'.$_POST['s'].'">';
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
										echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="search" value="Search User" id="z"></form><br>';
										echo "<div align='right'><a class='pagination' href='manageUsers.php?pageNo=$previousPage&selectedRole=$selectedRole'>Previous Page</a>";
										echo "&nbsp;&nbsp;<a class='pagination' href='manageUsers.php?pageNo=$nextPage&selectedRole=$selectedRole'>Next Page</a></div><br>";
										if($_POST['search'] == 'Search User'){
											if(strlen($_POST['s']) != 0){
												$studentName = $_POST['s'];
												$studentName=str_replace("*","%",$studentName);
												$userListQuery = "SELECT * FROM users WHERE designation = '$selectedRole' AND username <> 'vinod' AND username LIKE '$studentName' LIMIT ";
											} else {
												$userListQuery = "SELECT * FROM users WHERE designation = '$selectedRole' AND username <> 'vinod' LIMIT ";
											}

											$userListQuery .= $startRow.', '.$noOfRecords;
											$userListResult = mysql_query($userListQuery) or die ('Users table not replying');
										} else {
											$userListQuery = "SELECT * FROM users LIMIT ";
											$userListQuery .= $startRow.', '.$noOfRecords;
											$userListResult = mysql_query($userListQuery);
										}
										if (!$userListResult) {
											die("query to show fields from table failed");
										} else {
											echo '<form method="post" action="manageUsers.php">';
											echo "<table class='maintable'><tr class='headline'><td width='3%' align='center'>&nbsp;</td>";
											echo "<td width='30%' align='center'><b>Username</b></td>";
											echo "<td width='30%' align='center'><b>Full Name</b></td>";
											echo "<td width='15%' align='center'><b>Designation</b></td>";
											echo "<td width='12%' align='center'><b>Standard</b></td>";
											echo "<td width='10%' align='center'><b>Section</b></td>";
											echo "</tr>";

											if(mysql_num_rows($userListResult) > 0){
												while($row = mysql_fetch_array($userListResult)) {
													echo '<tr class="mainrow">';
													echo '<td class="cell1" width="3%" align="center">';
													echo '<input type="radio" name="userDetail" value="'.$row['username'].'"></td>';
													echo '<td class="cell1" width="30%"><b>'.$row['username'].'</b></td>';
													echo '<td class="cell1" width="30%"><b>'.$row['full_name'].'</b></td>';
													echo '<td class="cell1" width="15%" align="center"><b>'.$row['designation'].'</b></td>';
													if($row['designation'] == 'student'){
														echo '<td class="cell1" width="12%" align="center"><b>'.$row['standard'].'</b></td>';
														echo '<td class="cell1" width="10%" align="center"><b>&nbsp;'.$row['section'].'&nbsp;</b></td>';
													} else {
														echo '<td class="cell1" width="12%" align="center"><b>-</b></td>';
														echo '<td class="cell1" width="10%" align="center"><b>-</b></td>';
													}
													echo '</tr>';
												}
											} else {
												echo '<tr class="mainrow"><td colspan=6 align="center" class="cell1"><b>No records present.</b></td></tr>';
											}
											mysql_free_result($userListResult);
											echo '</table><br>';
											echo"<input type='submit' name='request' value='Get Details' id='z'>";
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
