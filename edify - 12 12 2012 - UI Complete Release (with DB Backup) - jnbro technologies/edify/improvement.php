<?php
    include_once "dbconnect.php";
    include_once "myPhpFunctions.php";
    include_once "staticCalendar.php";
	    include_once "jfunctions.php";
		include ("performFunctions.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student's Improvement</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="default.js"></script>
       

</head>

<body>


 <?php
           	$username = $_SESSION['username'];
			$password = $_SESSION['password'];

			$designation = $_SESSION['designation'];
$fullName = $_SESSION['fullName'];

			
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
				<p class="title">Performance
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  <div>
    <ul></li>
    <li>
      <div>
        <div>
    	<?php
							if($designation == 'teacher' || $designation == 'parent' || $designation == 'admin' || $designation == 'principal'){
						?>
						<div class="entry_mailbox">
							
							<?php
								if($designation == 'teacher' || $designation == 'admin' || $designation == 'principal'){
							?>
							<ul>
								<li><a href="performance.php">Search</a></li>
								<li><a href="performance_add.php">Add</a></li>
								<li class="current_page_item"><a href="improvement.php">Areas of Improvement</a></li>
							</ul><br>
							<?php
									$selectedStandard = $_GET['standard'];
									$selectedStudent = $_GET['student'];
									echo getDynamicStanStuDropdown($selectedStandard, $selectedStudent);
								} else {
							?>
							<ul>
								<li><a href="performance.php">Search</a></li>
								<li class="current_page_item"><a href="improvement.php">Areas of Improvement</a></li>
							</ul><br>
							<?php
								}
							?>
							<form method="POST">
								<?php
									if($designation=='parent'){
										$studentsQuery = "SELECT username, full_name FROM users WHERE parent = '$username' and designation = 'student' ORDER BY standard, section, full_name ASC";											
										$selectedStudent = $_POST['selStudent'];
										$studentsResult = mysql_query($studentsQuery);
										$rowNum = mysql_num_rows(mysql_query($StudentsQuery));
										echo '<p style="margin-left:30px;" class="td5">Select Child Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										echo '<select class="dynamicstudent" name="selStudent">';
										while($line = mysql_fetch_array($studentsResult)){
											$id = $line['username'];
											$value = $line['full_name'];
											echo '<option value="'.$id.'"';
											if($id == $selectedStudent){
												echo ' selected';
											}
											echo '>'.$value.'</option>';
										}
										echo '</select> *</p>';
										echo '<input style="margin-left:350px" type="submit" value="View Remarks" id="z" name="subValue">';
									} else {
										if($selectedStandard != null && $selectedStudent != null) {
											echo '<input style="margin-left:350px" type="submit" value="View Previous History" id="z" name="subValue"><br><br>';
											echo '<br><br><p style="margin-left:70px; padding:0px; border:0px;" class="font1">Improvement *: ';
											echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea cols="40" rows="4" name="message"></textarea></p>';
											echo '<p style="margin-left:500px; padding:0px; border:0px;">';
											echo '<input type="submit" value="Store" id="z" name="subValue"></p><br><br>';
										}
									}
									if($_POST) {
										if($_POST['subValue'] == 'Store'){
											$teacher_username = $username;
											$teacher_fullName = $fullName;
											$student_username = $_POST['selStudent'];
											$stuFullNameQuery = mysql_fetch_assoc(mysql_query("SELECT full_name, standard FROM users WHERE username = '$student_username'"));
											$student_fullName = $stuFullNameQuery['full_name'];
											$student_standard = $stuFullNameQuery['standard'];
											$message = $_POST['message'];
											$message = str_replace("'","\'",$message);
											$message = str_replace('"','\"',$message);
											$originaldatetime = date("Y-m-d H:i:s");
											$time = 19800;
											$creationDate= strtotime($originaldatetime) + $time;
											$createdOn = date("Y-m-d",$creationDate);
											$insertQuery = "INSERT INTO improvement (teacher_username, teacher_fullname, student_username, student_fullname, improvement, creation_date) VALUES ('$teacher_username', '$teacher_fullName', '$student_username', '$student_fullName', '$message', '$createdOn')";
											mysql_query($insertQuery) or die ("Cannot insert into the database");
											
											$activityDate = date("Y-m-d G:i:s");
											$activityMsg = 'Suggested some improvements needed on certain topics for '.$student_fullname.' of standard '.$student_standard;
											$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
											mysql_query($userActivityQuery);
											echo '<p style="font-size:15px; color:rgb(14,71,33); margin-left:30px; font-weight: bold">Successfully stored in the database ... !!!</p>';
										} elseif($_POST['subValue'] == 'View Previous History' || $_POST['subValue'] == 'View Remarks'){
											$teacher_username = $username;
											$student_username = $_POST['selStudent'];
											$getDetailsQuery = "SELECT * FROM improvement WHERE student_username = '$student_username' ORDER BY creation_date";
											$getDetailsResult = mysql_query($getDetailsQuery);
											$getDetailsRows = mysql_num_rows(mysql_query($getDetailsQuery));
											if($getDetailsRows > 0) {
												if($designation == 'teacher' || $designation == 'admin' || $designation == 'principal') {
													echo '<br><br><table width="100%" cellspacing=0>';
													echo '<tr><td width="7%" class="td5"></td><td width="3%" class="td5_1">&nbsp;</td>';
													echo '<td width="15%" class="td5_1">From Name</td>';
													echo '<td width="50%" class="td5_1">Message</td>';
													echo '<td width="15%" class="td5_1">Updated On</td>';
													echo '<td width="10%" class="td5"></td></tr>';
													while($line = mysql_fetch_array($getDetailsResult)){
														echo '<tr><td width="7%" class="td5"></td>';
														echo '<td width="3%" class="td5_3"><input type="checkbox" name="remarksID[]" value="'.$line['id'].'"></td>';
														echo '<td width="15%" class="td5_3">'.$line['teacher_fullname'].'</td>';
														echo '<td width="50%" class="td5_3">&nbsp;'.$line['improvement'].'&nbsp;</td>';
														echo '<td width="15%" class="td5_3">'.$line['creation_date'].'</td>';
														echo '<td width="10%" class="td5"></td></tr>';
													}
													echo '</table><br>';
													echo '<p style="float:right; margin-right:10px">';
													echo '<input type="submit" value="Delete" id="z" name="subValue">';
													echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Reset" id="z" name="reset">';
													echo '</p>';
												} else {
													echo '<br><br><table width="100%" cellspacing=0>';
													echo '<tr><td width="10%" class="td5"></td>';
													echo '<td width="15%" class="td5_1">From Name</td>';
													echo '<td width="50%" class="td5_1">Message</td>';
													echo '<td width="15%" class="td5_1">Updated On</td>';
													echo '<td width="10%" class="td5"></td></tr>';
													while($line = mysql_fetch_array($getDetailsResult)){
														echo '<tr><td width="10%" class="td5"></td>';
														echo '<td width="15%" class="td5_3">'.$line['teacher_fullname'].'</td>';
														echo '<td width="50%" class="td5_3">&nbsp;'.$line['improvement'].'&nbsp;</td>';
														echo '<td width="15%" class="td5_3">'.$line['creation_date'].'</td>';
														echo '<td width="10%" class="td5"></td></tr>';
													}
													echo '</table>';
												}
											} else {
												echo '<br><br><p style="font-size:17px; color:rgb(14,71,33); margin-left:150px; font-weight: bold">No records to display ...</p>';
											}
										} elseif($_POST['subValue'] == 'Delete'){
											$remarkIDs = $_POST['remarksID'];
											$arrayLength = count($remarkIDs);
											for($i = 0; $i < $arrayLength; $i++){
												$id = $remarkIDs[$i];
												$originaldatetime = date("Y-m-d H:i:s");
												$time = 19800;
												$creationDate= strtotime($originaldatetime) + $time;
												$movedOn = date("Y-m-d",$creationDate);
												$insertQuery = "INSERT INTO improvement_bkup (id, teacher_username, teacher_fullname, student_username, student_fullname, improvement, creation_date, moved_on) SELECT id, teacher_username, teacher_fullname, student_username, student_fullname, improvement, creation_date, '$movedOn' from improvement WHERE id='$id'";
												mysql_query($insertQuery) or die ("Cannot insert the data into backup tables");
												$deleteQuery = "DELETE FROM improvement WHERE ID='$id'";
												mysql_query($deleteQuery) or die ("Cannot delete the data from database");
											}
											echo '<br><br><p style="font-size:16px; color:rgb(14,71,33); margin-left:150px; font-weight: bold">Selected records have been deleted Successfully ... !!!</p>';
										}
									}
								?>
							</form>
						</div>
						<?php
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
