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
<title>Home Assignment</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
	<script language="javascript" src="calendar.js"></script>
       

</head>

<body>
<script language="JavaScript">
		
			function checkForm() {
				var assignmentName, subject, standard, dobSelected;
				assignmentName = trim(window.document.assignmentAdd.assignmentName.value);
				subject = trim(window.document.assignmentAdd.subject.value);
				standard = trim(window.document.assignmentAdd.standard.value);
				dobSelected = window.document.assignmentAdd.date4.value;
				if (assignmentName.length == 0 || subject.length == 0 || standard.length == 0) {
					alert('Please fill in the required fields');
					window.document.assignmentAdd.flag.value = 'false';
					return false;
				} else if (dobSelected == '0000-00-00') {
					alert('Please select the submission date');
					window.document.assignmentAdd.flag.value = 'false';
					return false;
				} else {
					window.document.assignmentAdd.flag.value = 'true';
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
				<p class="title">Home Assignment
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  <div>
    <ul>
    <li></li>
      <div>
        <div>
      <?php
								if($designation == 'admin' || $designation == 'teacher' || $designation == 'principal') {
									echo '<ul>';
									echo '<li><a href="uploadAssignments.php">Upload New Assignment</a></li>';
									echo '<li><a href="downloadAssignments.php">Download Assignment</a></li>';
									echo '<li><a href="correctAssignments.php">Assignment Marks</a></li>';
									echo '</ul><br/>';
							?>
							<form name="assignmentHistory" method="GET" action="homeAssignment.php">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<font style="font-size: 14px; color:rgb(14,71,33); font-weight:bold">Select Class:</font>
								<?php
									$distinctClassQuery = "SELECT DISTINCT standard FROM users WHERE designation = 'student' ORDER BY standard ASC";
									$distinctClassResult = mysql_query($distinctClassQuery);
									$selectedStandard = $_GET['selectStandard'];
									echo '&nbsp;&nbsp;&nbsp;<select name="selectStandard">';
									while($line = mysql_fetch_array($distinctClassResult)){
										$id = $line['standard'];
										echo '<option value="'.$id.'"';
										if($id == $selectedStandard){
											echo ' selected';
										}
										echo '>'.$id.'</option>';
									}
									echo '</select>';
								?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="View History" id="z" name="subValue">
							</form>
							<?php
									if($_GET){
										$assignmentListQuery = "SELECT * FROM ha_list WHERE standard = '$selectedStandard'";
										$assignmentListResult = mysql_query($assignmentListQuery);
										$assignmentListRows = mysql_num_rows(mysql_query($assignmentListQuery));
										echo '<br><br>';
										echo '<table cellspacing=0 style="background:rgb(216,216,216); margin-left:20px; width:100%; color:rgb(19,77,91);">';
										echo '<tr><td width="1%" class="td5"></td>';
										echo '<td width="20%" class="td5_1">Assignment Name</td>';
										echo '<td width="25%" class="td5_1">Subject</td>';
										echo '<td width="7%" class="td5_1">Standard</td>';
										echo '<td width="7%" class="td5_1">Section</td>';
										echo '<td width="14%" class="td5_1">Submission Date</td>';
										echo '<td width="17%" class="td5_1">File Name</td>';
										echo '<td width="9%" class="td5"></td></tr>';
										if ($assignmentListRows != 0) {
											while($line = mysql_fetch_array($assignmentListResult)){
												echo '<tr><td width="1%" class="td5"></td>';
												echo '<td width="20%" class="td5_3">'.$line['assignmentName'].'</td>';
												echo '<td width="25%" class="td5_3">'.$line['subject'].'</td>';
												echo '<td width="14%" class="td5_3">'.$line['submissionDate'].'</td>';
												echo '<td width="7%" class="td5_3">'.$line['standard'].'</td>';
												echo '<td width="7%" class="td5_3">'.$line['section'].'</td>';
												$fileName = $line['fileName'];
												$fileName = stringReplacement($fileName);
												if(strlen($fileName) == 0){
													echo '<td width="17%" class="td5_3">Not uploaded</td>';
												} else {
													echo '<td width="17%" class="td5_3">'.$line['fileName'].'</td>';
												}
												echo '<td width="9%" class="td5"></td></tr>';
											}
										} else {
											echo '<tr><td width="1%" class="td5"></td>';
											echo '<td colspan=6 width="90%" class="td5_3">No existing Assignments for the selected standard ...</td>';
											echo '<td width="9%" class="td5"></td></tr>';
										}
										echo '</table><br><br><br>';
									}
									if($_POST['flag']){
										$assignmentName = $_POST['assignmentName'];
										$class = $_POST['standard'];
										$subject = $_POST['subject'];
										$subject = stringReplacement($subject);
										$section = $_POST['section'];
										$section = stringReplacement($section);
										$submissionDate = $_POST['date4'];
										$fileName = $_POST['fileName'];
										$insertQuery1 = "INSERT INTO ha_list (assignmentName, submissionDate, standard, subject, section, createdBy, fileName) VALUES ('$assignmentName', '$submissionDate', '$class', '$subject', '$section', '$username', '$fileName')";
										//echo $insertQuery1;	
										$activityDate = date("Y-m-d G:i:s");
										$activityMsg = 'Created a new assignment with the given Deatils. Assignment name: '.$assignmentName.'; Submission Date: '.$submissionDate.'; Standard: '.$class;
										$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
										mysql_query($userActivityQuery);
										if(strlen($section == 0)){
											$insertQuery2 = "INSERT INTO ha_submission (assignmentName, submissionDate, standard, subject, section, faculty, fileName, submittedBy) SELECT '$assignmentName', '$submissionDate', '$class', '$subject', '$section', '$username', '$fileName', username FROM users WHERE designation = 'student' AND standard = '$class'";

										} else {
											$insertQuery2 = "INSERT INTO ha_submission (assignmentName, submissionDate, standard, subject, section, faculty, fileName, submittedBy) SELECT '$assignmentName', '$submissionDate', '$class', '$subject', '$section', '$username', '$fileName', username FROM users WHERE designation = 'student' AND standard = '$class' AND section = '$section'";
										}
										//echo $insertQuery2;	
										mysql_query ($insertQuery1) or die ('Cannot insert the ha_submission 1 data into database');
										mysql_query ($insertQuery2) or die ('Cannot insert the ha_submission 2 data into database');
										echo '<table style="background:rgb(216,216,216); margin-left:20px; width:100%; color:rgb(19,77,91);">';
										echo '<tr><td width="10%">&nbsp;</td><td width="80%">';
										echo 'Successfully created an assignment !!!';
										echo '</td><td width="10%">&nbsp;</td></tr>';
										echo '</table><br><br>';
									}
							?>
							<form name="assignmentAdd" method="post" action="homeAssignment.php">
								<p style="color:rgb(19,77,91); margin-left:20px; margin-right:20px; font-weight: bold; font-size: 14px; background: rgb(216,216,216); padding: 4px; float:center; line-height:2em">
									*** GuideLines !!!
									<br>&nbsp;&nbsp;&nbsp;&nbsp;1. All fields marked with * are mandatory fields
									<br>&nbsp;&nbsp;&nbsp;&nbsp;2. Assignment Name should be unique like 'Assignment 1' or 'Assignment 2'.
									<br>&nbsp;&nbsp;&nbsp;&nbsp;3. 'Section' field is optional. If the user don't enter anything in 'Section' then the data is stored every section that exists for that standard.
									<br>&nbsp;&nbsp;&nbsp;&nbsp;4. User has to enter section if the assignment is meant for only one section.
									<br>&nbsp;&nbsp;&nbsp;&nbsp;5. User has to enter file name if he/she has already uploaded the assignment question paper.									
								</p><br>
								<table style="background:rgb(216,216,216); margin-left:20px; width:100%; color:rgb(19,77,91);">
									<tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Assignment Name *:</b></td>
										<td width="23%"><input type="text" name="assignmentName" value="<?php echo $_POST['assignmentName']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Subject *:</b></td>
										<td width="23%"><input type="text" name="subject" value="<?php echo $_POST['subject']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr><tr /><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Class *:</b></td>
										<td width="23%"><input type="text" name="standard" value="<?php echo $_POST['standard']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Section :</b></td>
										<td width="23%"><input type="text" name="section" value="<?php echo $_POST['section']; ?>"></td>
										<td width="5%">&nbsp;</td>
									</tr><tr /><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Submission Date <br>(YYYY-MM-DD) *:</b></td>
										<td colspan=2 width="28%">
											<?php
												echo '<b>'.$_POST['subDate'].'</b><br>';
												$myCalendar = new tc_calendar("date4", true);
												$myCalendar->setIcon("images/iconCalendar.gif");
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(2009, 2011);
												$myCalendar->writeScript();
											?>
										</td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr><tr /><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>File Name </b></td>
										<td colspan=2 width="28%">
											<input type="text" name="fileName" value="<?php echo $_POST['fileName']; ?>">
										</td>
										<td colspan=4 width="55%">&nbsp;</td>
									</tr><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />
								</table><br>
								<p style="float:right; margin-right:30px">
									<input type="hidden" name="flag">
									<input type="submit" onClick="return checkForm();" value="Store" id="z" name="subValue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="reset" value="Reset" id="z" name="reset">
								</p>
							</form>
							<?php
								} elseif ($designation == 'student') {
									echo '<ul>';
									echo '<li><a href="downloadAssignments.php">Download Assignment</a></li>';
									echo '<li><a href="correctAssignments.php">Assignment Marks</a></li>';
									echo '</ul>';
									$assignmentListQuery = "SELECT * FROM ha_submission WHERE submittedBy = '$username'";
									$assignmentListResult = mysql_query($assignmentListQuery);
									$assignmentListRows = mysql_num_rows(mysql_query($assignmentListQuery));
									echo '<br><br><br><br><br><br><table width="100%" cellspacing=0>';
									echo '<tr><td width="5%" class="td5"></td>';
									echo '<td width="20%" class="td5_1">Assignment Name</td>';
									echo '<td width="25%" class="td5_1">Subject</td>';									
									echo '<td width="14%" class="td5_1">Submission Date</td>';
									echo '<td width="17%" class="td5_1">File Name</td>';
									echo '<td width="14%" class="td5_1">Submitted On</td>';
									echo '<td width="5%" class="td5"></td></tr>';
									if ($assignmentListRows != 0) {
										while($line = mysql_fetch_array($assignmentListResult)){
											echo '<tr><td width="5%" class="td5"></td>';
											echo '<td width="20%" class="td5_3">'.$line['assignmentName'].'</td>';
											echo '<td width="25%" class="td5_3">'.$line['subject'].'</td>';
											echo '<td width="14%" class="td5_3">'.$line['submissionDate'].'</td>';
											$fileName = $line['fileName'];
											$fileName = stringReplacement($fileName);
											$submittedOn = $line['submittedOn'];
											$submittedOn = stringReplacement($submittedOn);
											if(strlen($fileName) == 0){
												echo '<td width="17%" class="td5_3">Not uploaded</td>';
											} else {
												echo '<td width="17%" class="td5_3">'.$line['fileName'].'</td>';
											}
											if(strlen($submittedOn) == 0){
												echo '<td width="14%" class="td5_3">Not Submitted</td>';
											} else {
												echo '<td width="14%" class="td5_3">'.$line['submittedOn'].'</td>';
											}
											echo '<td width="5%" class="td5"></td></tr>';
										}
									} else {
										echo '<tr><td width="5%" class="td5"></td>';
										echo '<td colspan=5 width="90%" class="td5_3">No Assignements Pending ...</td>';
										echo '<td width="5%" class="td5"></td></tr>';
									}
									echo '</table><br>';
								} elseif ($designation == 'parent') {
									echo '<ul>';
									echo '<li><a href="downloadAssignments.php">Download Assignment</a></li>';
									echo '<li><a href="correctAssignments.php">Assignment Marks</a></li>';
									echo '</ul>';
									$childrenQuery = "SELECT * FROM users WHERE parent = '$username' AND designation = 'Student' ORDER by standard, username ASC";
									$childrenResult = mysql_query($childrenQuery);
									while($line1 = mysql_fetch_array($childrenResult)){
										$selectedChildren = $line1['username'];
										$selectedChildrenFullName = $line1['full_name'];
										$assignmentListQuery = "SELECT * FROM ha_submission WHERE submittedBy = '$selectedChildren'";
										$assignmentListResult = mysql_query($assignmentListQuery);
										$assignmentListRows = mysql_num_rows(mysql_query($assignmentListQuery));
										echo '<br><br><br><div align="center">';
										echo '<p style="color:white; margin-left:30px; margin-right:30px; font-weight: bold; font-size: 14px; background: rgb(19,77,91) repeat left top; padding: 4px; float:center; line-height:2em; width:300px">';
										echo 'Assignments for '.$selectedChildrenFullName;
										echo '</p></div>';
										echo '<table width="100%" cellspacing=0>';
										echo '<tr><td width="5%" class="td5"></td>';
										echo '<td width="20%" class="td5_1">Assignment Name</td>';
										echo '<td width="25%" class="td5_1">Subject</td>';									
										echo '<td width="14%" class="td5_1">Submission Date</td>';
										echo '<td width="17%" class="td5_1">File Name</td>';
										echo '<td width="14%" class="td5_1">Submitted On</td>';
										echo '<td width="5%" class="td5"></td></tr>';
										if ($assignmentListRows != 0) {
											while($line = mysql_fetch_array($assignmentListResult)){
												echo '<tr><td width="5%" class="td5"></td>';
												echo '<td width="20%" class="td5_3">'.$line['assignmentName'].'</td>';
												echo '<td width="25%" class="td5_3">'.$line['subject'].'</td>';
												echo '<td width="14%" class="td5_3">'.$line['submissionDate'].'</td>';
												$fileName = $line['fileName'];
												$fileName = stringReplacement($fileName);
												$submittedOn = $line['submittedOn'];
												$submittedOn = stringReplacement($submittedOn);
												if(strlen($fileName) == 0){
													echo '<td width="17%" class="td5_3">Not uploaded</td>';
												} else {
													echo '<td width="17%" class="td5_3">'.$line['fileName'].'</td>';
												}
												if(strlen($submittedOn) == 0){
													echo '<td width="14%" class="td5_3">Not Submitted</td>';
												} else {
													echo '<td width="14%" class="td5_3">'.$line['submittedOn'].'</td>';
												}
												echo '<td width="5%" class="td5"></td></tr>';
											}
										} else {
											echo '<tr><td width="5%" class="td5"></td>';
											echo '<td colspan=5 width="90%" class="td5_3">No Assignements Pending ...</td>';
											echo '<td width="5%" class="td5"></td></tr>';
										}
										echo '</table><br>';
									}
								}
							?>
        </div>
      </div>
      
    </ul>
  </div>
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
