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
<title>Assignment Marks</title>

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
									echo '<li class="current_page_item"><a href="correctAssignments.php">Assignment Marks</a></li>';
									echo '</ul><br><br><br>';
							?>
							<p style="color:rgb(19,77,91); margin-left:20px; margin-right:20px; font-weight: bold; font-size: 14px; background: rgb(216,216,216); padding: 20px; float:center; line-height:2em">
								*** GuideLines !!!
								<br>&nbsp;&nbsp;&nbsp;&nbsp;1. Select the Class from the dropdown list and then get the list of assignments which are given to that class.
								<br>&nbsp;&nbsp;&nbsp;&nbsp;2. Select the radio button and then click on 'View Summary' button to get the list of students who didn't submit that particular assignment.
								<br>&nbsp;&nbsp;&nbsp;&nbsp;3. Select the students who did submit their assignments and then click 'Submitted' button to store the submission Date for that particular assignment and particular student.								
							</p><br>
							<form name="assignmentHistory" method="GET" action="correctAssignments.php">
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
										echo '<form name="assignmentHistory" method="POST" action="correctAssignments.php">';
										$assignmentListQuery = "SELECT * FROM ha_list WHERE standard = '$selectedStandard'";
										$assignmentListResult = mysql_query($assignmentListQuery);
										$assignmentListRows = mysql_num_rows(mysql_query($assignmentListQuery));
										echo '<br><br><table cellspacing=0>';
										echo '<tr><td width="5%" class="td5_1">&nbsp;</td>';
										echo '<td width="20%" class="td5_1">Assignment Name</td>';
										echo '<td width="25%" class="td5_1">Subject</td>';
										echo '<td width="14%" class="td5_1">Submission Date</td>';
										echo '<td width="7%" class="td5_1">Standard</td>';
										echo '<td width="7%" class="td5_1">Section</td>';										
										echo '<td width="17%" class="td5_1">File Name</td>';
										echo '<td width="5%" class="td5"></td></tr>';
										if ($assignmentListRows != 0) {
											while($line = mysql_fetch_array($assignmentListResult)){
												echo '<tr><td width="5%" class="td5_3"><input type="radio" name="ListId[]" value="'.$line['id'].'"></td>';
												echo '<td width="20%" class="td5_3">'.$line['assignmentName'].'</td>';
												echo '<td width="25%" class="td5_3">'.$line['subject'].'</td>';
												echo '<td width="14%" class="td5_3">'.$line['submissionDate'].'</td>';
												echo '<td width="7%" class="td5_3">'.$line['standard'].'</td>';
												echo '<td width="7%" class="td5_3">&nbsp;'.$line['section'].'&nbsp;</td>';
												$fileName = $line['fileName'];
												$fileName = stringReplacement($fileName);
												if(strlen($fileName) == 0){
													echo '<td width="17%" class="td5_3">Not uploaded</td>';
												} else {
													echo '<td width="17%" class="td5_3">'.$line['fileName'].'</td>';
												}
												echo '<td width="5%" class="td5"></td></tr>';
											}
										} else {
											echo '<tr><td width="5%" class="td5_3">&nbsp;</td><td colspan=6 width="90%" class="td5_3">No existing Assignments for the selected standard ...</td><td width="5%" class="td5"></td></tr>';
										}
										echo '</table><br>';
										echo '<p style="float:right; margin-right:20px"><input type="submit" value="View Summary" id="z" name="subValue"></p>';
										echo '</form><br><br><br>';
									}
									if ($_POST['subValue'] == 'View Summary') {
										$listIds = $_POST['ListId'];
										$selectedId = $listIds[0];
										$ha_listQuery = "SELECT * FROM ha_list WHERE id = '$selectedId'";
										$ha_listResult = mysql_fetch_assoc(mysql_query($ha_listQuery));
										$assignmentName = $ha_listResult['assignmentName'];
										$submissionDate = $ha_listResult['submissionDate'];
										$subject = $ha_listResult['subject'];
										$standard = $ha_listResult['standard'];
										$section = $ha_listResult['section'];
										$fileName = $ha_listResult['fileName'];
										$faculty = $ha_listResult['createdBy'];
										$ha_submissionQuery = "SELECT a.*, b.full_name FROM ha_submission a, users b WHERE a.assignmentName = '$assignmentName' AND a.submissionDate = '$submissionDate' AND a.subject = '$subject' AND a.standard = '$standard' AND a.section = '$section' AND a.fileName = '$fileName'AND a.faculty = '$faculty' AND a.submittedBy = b.username AND submittedOn IS NULL";
										$ha_submissionResult = mysql_query($ha_submissionQuery);
										echo '<form name="assignmentHistory" method="POST" action="correctAssignments.php">';
										echo '<br><br><table cellspacing=0>';
										echo '<td width="3%" class="td5"></td>';
										echo '<td width="5%" class="td5_1">&nbsp;</td>';
										echo '<td width="22%" class="td5_1">Student Name</td>';
										echo '<td width="20%" class="td5_1">Assignment Name</td>';
										echo '<td width="20%" class="td5_1">Subject</td>';
										echo '<td width="14%" class="td5_1">Submission Date</td>';
										echo '<td width="7%" class="td5_1">Standard</td>';
										echo '<td width="7%" class="td5_1">Section</td>';									
										echo '<td width="2%" class="td5"></td></tr>';
										while ($list1 = mysql_fetch_array($ha_submissionResult)) {
											echo '<tr><td width="3%" class="td5"></td>';
											echo '<td width="5%" class="td5_3"><input type="checkbox" name="ListId[]" value="'.$list1['id'].'"></td>';
											echo '<td width="22%" class="td5_3">'.$list1['full_name'].'</td>';
											echo '<td width="20%" class="td5_3">'.$list1['assignmentName'].'</td>';
											echo '<td width="20%" class="td5_3">'.$list1['subject'].'</td>';
											echo '<td width="14%" class="td5_3">'.$list1['submissionDate'].'</td>';
											echo '<td width="7%" class="td5_3">'.$list1['standard'].'</td>';
											echo '<td width="7%" class="td5_3">&nbsp;'.$list1['section'].'&nbsp;</td>';
											echo '<td width="2%" class="td5"></td></tr>';
										}
										echo '</table><br><br>';
										echo '<p style="float:right; margin-right:20px">';
										echo '<input type="submit" value="Submitted" id="z" name="subValue">';
										echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Reset" id="z" name="reset">';
										echo '</p>';
										echo '</form><br><br><br>';
									} elseif ($_POST['subValue'] == 'Submitted') {
										$submittedIds = $_POST['ListId'];
										$originaldatetime = date("Y-m-d H:i:s");
										$time = 19800;
										$creationDate= strtotime($originaldatetime) + $time;
										$submittedOn = date("Y-m-d",$creationDate);
										$arrayLength = count($submittedIds);
										for($j = 0; $j < $arrayLength; $j++){
											$id = $submittedIds[$j];
											$updateQuery = "UPDATE ha_submission SET submittedOn = '$submittedOn' WHERE id = '$id'";
											mysql_query($updateQuery) or die ('Could not update the database');
										}
									}
								} else {
									echo '<ul>';
									echo '<li><a href="downloadAssignments.php">Download Assignment</a></li>';
									echo '<li class="current_page_item"><a href="correctAssignments.php">Assignment Marks</a></li>';
									echo '</ul>';
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
