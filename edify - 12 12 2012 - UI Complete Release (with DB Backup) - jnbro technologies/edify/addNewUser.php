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
<title>Contact Us</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="calendar.js"></script>
       

</head>

<body>
<script language="JavaScript">
			function checkForm() {
				var username, password, father_name, mother_name, address1, address2, city, state, pincode, designation, standard, section, contact, last_name, parent;

				username = trim(window.document.addNewUser.username.value);
				parent = trim(window.document.addNewUser.parent.value);
				password = trim(window.document.addNewUser.password.value);
				father_name = trim(window.document.addNewUser.father_name.value);
				mother_name = trim(window.document.addNewUser.mother_name.value);
				last_name = trim(window.document.addNewUser.last_name.value);
				designation = trim(window.document.addNewUser.designation.value);
				email_id = trim(window.document.addNewUser.email_id.value);
				contact = trim(window.document.addNewUser.contact.value);
				standard = trim(window.document.addNewUser.standard.value);
				section = trim(window.document.addNewUser.section.value);
				pincode = trim(window.document.addNewUser.pincode.value);
				address1 = trim(window.document.addNewUser.address1.value);
				state = trim(window.document.addNewUser.state.value);
				city = trim(window.document.addNewUser.city.value);
				dobSelected = window.document.addNewUser.date4.value;	

				if(password.length == 0 || username.length == 0 || designation.length == 0 || last_name.length == 0 || contact.length == 0 || address1.length == 0 || state.length == 0 || city.length == 0) {
					alert('Please fill in the required fields');
					window.document.addNewUser.flag.value = 'false';
					return false;
				} else if(designation == 'select') {
					alert('Please select designation of user to  be added');
					window.document.addNewUser.flag.value = 'false';
					return false;
				} else if(designation == 'student' && (father_name.length == 0 || mother_name.length == 0 || dobSelected == '0000-00-00')) {
					alert('Please enter parents name and date of birth if the User designation is student');
					window.document.addNewUser.flag.value = 'false';
					return false;
				} else if(designation == 'student' && (standard.length == 0 || section.length == 0)) {
					alert('Class and section should not be null if the designation is student');
					window.document.addNewUser.flag.value = 'false';
					return false;
				} else if(designation == 'student' && parent.length == 0) {
					alert('Please enter username of the parent if the User designation is student');
					window.document.addNewUser.flag.value = 'false';
					return false;
				} else {
					window.document.addNewUser.flag.value = 'true';
					return true;
				}
			}

			function trim(str) {
				return str.replace(/^\s+|\s+$/g,'');
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
				<p class="title">Manage Users
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
 
      <ul>
								<li><a href="manageUsers.php">Search User</a></li>
								<li class="current_page_item"><a href="addNewUser.php">Add New User</a></li>
							</ul><br>
							<?php								
								if($designation == 'admin') {
									if($_POST['flag']){
										$newUserName = $_POST['username'];
										$newUserValidation = mysql_num_rows(mysql_query("SELECT * FROM users WHERE username='$newUserName'"));
										if ($newUserValidation == 0 ) {
											$fullName = $_POST['first'];
											if(strlen($_POST['middle']) > 1) {
												$fullName .= ' '.$_POST['middle'];
											}
											$fullName .= ' '.$_POST['last_name'];
											$userInsertQuery = "INSERT INTO users (username,password,designation,standard,section,full_name,parent) VALUES ('".$_POST['username']."','".$_POST['password']."','".$_POST['designation']."','".$_POST['standard']."','".$_POST['section']."','".$fullName."','".$_POST['parent']."')";
											$userProfileInsertQuery = "INSERT INTO user_profile (username, first, middle, last, father_name, mother_name, email_id, contact, address1, address2, address3, city, state, pincode, standard, section, dob, gender, designation) VALUES ('".$_POST['username']."','".$_POST['first']."','".$_POST['middle']."','".$_POST['last_name']."','".$_POST['father_name']."','".$_POST['mother_name']."','".$_POST['email_id']."','".$_POST['contact']."','".$_POST['address1']."','".$_POST['address2']."','".$_POST['address3']."','".$_POST['city']."','".$_POST['state']."','".$_POST['pincode']."','".$_POST['standard']."','".$_POST['section']."','".$_POST['date4']."','".$_POST['gender']."','".$_POST['designation']."')";
											
											mysql_query($userInsertQuery) or die ('Cannot insert into users table');
											mysql_query($userProfileInsertQuery) or die ('Cannot insert into user profile table');
											
											$creationDate = date("Y-m-d G:i:s");
											$activityMsg = 'Created a new user with username '.$_POST['username'];
											$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationDate', '$activityMsg')";
											mysql_query($userActivityQuery);
							?>
							<br><br>
							<table >
								<tr /><tr /><tr /><tr>
									<td width="5%">&nbsp;</td>
									<td colspan="95%"><b>User has been added successfully !!!</b></td>
								</tr><tr /><tr /><tr />
							</table>
							<?php
										} else {
							?>
							<br><br>
							<form method="post" name="addNewUser">
								<table >
									<tr>
										<td width="5%">&nbsp;</td>
										<td colspan=6><b>Username already exists ...</b></td>
									</tr>
								</table><br><br>

								<table >
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Username *:</b></td>
										<td width="23%"><b><input type="text" name="username" value="<?php echo $_POST['username']; ?>"></b></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Password *:</b></td>
										<td width="23%"><input type="text" name="password" value="<?php echo $_POST['password']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Class *:</b></td>
										<td width="23%"><input type="text" name="standard" value="<?php echo $_POST['standard']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Section *:</b></td>
										<td width="23%"><input type="text" name="section" value="<?php echo $_POST['section']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Designation *:</b></td>
										<td width="23%">
											<select name="designation">
												<?php
													$selectedRole = $_POST['designation'];
													echo roleDropdown($selectedRole); 
												?>
											</select>
										</td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Parent UserName:</b></td>
										<td width="23%"><input type="text" name="parent" value="<?php echo $_POST['parent']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>DOB <br>(YYYY-MM-DD):</b></td>
										<td colspan=2 width="28%"><b><?php echo $_POST['dob']; ?></b><br>
											<?php
												$myCalendar = new tc_calendar("date4", true);
												$myCalendar->setIcon("images/iconCalendar.gif");
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(1970, 2020);
												$myCalendar->writeScript();
											?>
										</td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr><tr /><tr />
								</table><br><br>

								<table >
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>First Name *:</b></td>
										<td width="23%"><input type="text" name="first" value="<?php echo $_POST['first']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Middle Name :</b></td>
										<td width="23%"><input type="text" name="middle" value="<?php echo $_POST['middle']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Last Name *:</b></td>
										<td width="23%"><input type="text" name="last_name" value="<?php echo $_POST['last_name']; ?>"></td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Father's Name:</b></td>
										<td width="23%"><input type="text" name="father_name" value="<?php echo $_POST['father_name']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Mother's Name:</b></td>
										<td width="23%"><input type="text" name="mother_name" value="<?php echo $_POST['mother_name']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Email ID :</b></td>
										<td width="23%"><input type="text" name="email_id" value="<?php echo $_POST['email_id']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Contact Number *:</b></td>
										<td width="23%"><input type="text" name="contact" value="<?php echo $_POST['contact']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Address 1 *:</b></td>
										<td width="23%"><input type="text" size=40 name="address1" value="<?php echo $_POST['address1']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Address 2 :</b></td>
										<td width="23%"><input type="text" size=40 name="address2" value="<?php echo $_POST['address2']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Address 3 :</b></td>
										<td width="23%"><input type="text" size=40 name="address3" value="<?php echo $_POST['address3']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Address 4 :</b></td>
										<td width="23%"><input type="text" size=40 name="address4" value="<?php echo $_POST['address4']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>City *:</b></td>
										<td width="23%"><input type="text" name="city" value="<?php echo $_POST['city']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>State *:</b></td>
										<td width="23%"><input type="text" name="state" value="<?php echo $_POST['state']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Pincode *:</b></td>
										<td width="23%"><input type="text" name="pincode" value="<?php echo $_POST['pincode']; ?>"></td>
										<td colspan=4 width="10%">&nbsp;</td>
									</tr><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Gender *:</b></td>
										<td width="23%"><input type="text" name="gender" value="<?php echo $_POST['gender']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Blood Group:</b></td>
										<td width="23%"><input type="text" name="bloodgroup" value="<?php echo $_POST['bloodgroups']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td colspan=6><b>* required fields ...</b></td>
									</tr>
								</table><br>
								<input type="hidden" name="flag">
								<input type="submit" onClick="return checkForm();"  name="save" value="Add User" id="z">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value="Reset" id="z">
							</form>
							<?php
										}
									} else {
							?>
							<br><br>
							<form method="post" name="addNewUser">
								<table style="font-family:calibri; width:90%; margin-left:30px; background: rgb(216,216,216); color:rgb(14,71,33);">
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="95%">
											<b>Instructions</b><br>
											&emsp;&emsp;1. Enter all the required fields (marked as star *).<br>
											&emsp;&emsp;2. For students, Standard, date of birth are mandatory field.<br>
											&emsp;&emsp;3. Please enter parent's username when you are creating a user interface for student. This is to link parent with the student.
										</td>
									</tr>
								</table><br>
								<table style="font-family:calibri; width:90%; margin-left:30px; background: rgb(216,216,216); color:rgb(19,77,91);" cellspacing="10px">
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Username *:</b></td>
										<td width="23%"><b><input type="text" name="username" value="<?php echo $_POST['username']; ?>"></b></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Password *:</b></td>
										<td width="23%"><input type="text" name="password" value="<?php echo $_POST['password']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Class *:</b></td>
										<td width="23%"><input type="text" name="standard" value="<?php echo $_POST['standard']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Section *:</b></td>
										<td width="23%"><input type="text" name="section" value="<?php echo $_POST['section']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Designation *:</b></td>
										<td width="23%">
											<select name="designation">
												<?php
													$selectedRole = $_POST['designation'];
													echo roleDropdown($selectedRole); 
												?>
											</select>
										</td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Parent UserName:</b></td>
										<td width="23%"><input type="text" name="parent" value="<?php echo $_POST['parent']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>DOB <br>(YYYY-MM-DD):</b></td>
										<td colspan=2 width="28%"><b><?php echo $_POST['dob']; ?></b><br>
											<?php
												$myCalendar = new tc_calendar("date4", true);
												$myCalendar->setIcon("images/iconCalendar.gif");
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(1970, 2020);
												$myCalendar->writeScript();
											?>
										</td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr><tr /><tr />
								</table><br><br>

								<table style="font-family:calibri; width:90%; margin-left:30px; background: rgb(216,216,216); color:rgb(19,77,91);" cellspacing="10px">
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>First Name *:</b></td>
										<td width="23%"><input type="text" name="first" value="<?php echo $_POST['first']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Middle Name :</b></td>
										<td width="23%"><input type="text" name="middle" value="<?php echo $_POST['middle']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Last Name *:</b></td>
										<td width="23%"><input type="text" name="last_name" value="<?php echo $_POST['last_name']; ?>"></td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Father's Name:</b></td>
										<td width="23%"><input type="text" name="father_name" value="<?php echo $_POST['father_name']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Mother's Name:</b></td>
										<td width="23%"><input type="text" name="mother_name" value="<?php echo $_POST['mother_name']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Email ID :</b></td>
										<td width="23%"><input type="text" name="email_id" value="<?php echo $_POST['email_id']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Contact Number *:</b></td>
										<td width="23%"><input type="text" name="contact" value="<?php echo $_POST['contact']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
								</table><br><br>
								<table style="font-family:calibri; width:90%; margin-left:30px; background: rgb(216,216,216); color:rgb(19,77,91);" cellspacing="10px">
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Address 1 *:</b></td>
										<td width="23%"><input type="text" size=40 name="address1" value="<?php echo $_POST['address1']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Address 2 :</b></td>
										<td width="23%"><input type="text" size=40 name="address2" value="<?php echo $_POST['address2']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Address 3 :</b></td>
										<td width="23%"><input type="text" size=40 name="address3" value="<?php echo $_POST['address3']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Address 4 :</b></td>
										<td width="23%"><input type="text" size=40 name="address4" value="<?php echo $_POST['address4']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>City *:</b></td>
										<td width="23%"><input type="text" name="city" value="<?php echo $_POST['city']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>State *:</b></td>
										<td width="23%"><input type="text" name="state" value="<?php echo $_POST['state']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Pincode *:</b></td>
										<td width="23%"><input type="text" name="pincode" value="<?php echo $_POST['pincode']; ?>"></td>
										<td colspan=4 width="10%">&nbsp;</td>
									</tr>
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Gender *:</b></td>
										<td width="23%"><input type="text" name="gender" value="<?php echo $_POST['gender']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Blood Group:</b></td>
										<td width="23%"><input type="text" name="bloodgroup" value="<?php echo $_POST['bloodgroups']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr>
								</table><br>
								<input type="hidden" name="flag">
								<input type="submit" onClick="return checkForm();"  name="save" value="Add User" id="z">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value="Reset" id="z">
							</form>
							<?php
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
