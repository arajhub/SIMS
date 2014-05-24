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
<?php
			$designation = $_SESSION['designation'];
			if($designation == 'parent') {
				echo '<title>Leave Application History</title>';
			} else {
				echo '<title>Approve Leave Application</title>';
			}
		?>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
	<script language="javascript" src="calendar.js"></script>
       

</head>

<body>


 <?php
           	$username = $_SESSION['username'];
			$password = $_SESSION['password'];

			$designation = $_SESSION['designation'];
$subject=$_POST['subject'];
			$message=$_POST['message'];
			
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
function childrenList($username){
				$studentsQuery = "SELECT username,full_name FROM users WHERE parent='$username' and designation='student'";
				$studentsResult = mysql_query($studentsQuery);
				$dd = ' <select name="child_name">';
				while($line = mysql_fetch_array($studentsResult)){
					$id = $line['username'];
					$value = $line['full_name'];
					$dd .= '<option value="'.$id.'"';
					if($id == $selStudent){
					   $dd .= ' selected';
					}
					$dd .='>'.$value.'</option>';
				}
				//$number = 0;
				return $dd;
			}
			
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
				<p class="title"><?php
			$designation = $_SESSION['designation'];
			if($designation == 'parent') {
				echo 'Leave Application History';
			} else {
				echo 'Approve Leave Application';
			}
		?>

			
			  
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
		  if($designation == 'student')
		  {
			  header( 'Location: dashboard.php' ) ;
			  }
								if($designation == 'parent'){
									echo '<ul>';
									echo '<li><a href="leaveApplication.php">Leave Applications</a></li>';
									echo '<li class="current_page_item"><a href="approveLeave.php">Leave Application History</a></li>';
									echo '</ul><br>';
									$leaveHistoryQuery = "SELECT * FROM leaveApplication WHERE username='$username' ORDER BY from_date asc";
									$leaveHistoryResults = mysql_query($leaveHistoryQuery);
									$noOfRecords = 10;
									$noOfPages = ceil((mysql_num_rows(mysql_query($leaveHistoryQuery)))/$noOfRecords);
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
									$leaveQuery = "SELECT * FROM leaveApplication WHERE username='$username' ORDER BY from_date DESC LIMIT ";
									$leaveQuery .= $startRow.', '.$noOfRecords;
									$leaveResult = mysql_query($leaveQuery);
									echo "<div align='right'>";
									echo "<a class='pagination' href='approveLeave.php?pageNo=$previousPage'>Previous Page</a>";
									echo "&nbsp;&nbsp;<a class='pagination' href='approveLeave.php?pageNo=$nextPage'>Next Page</a>";
									echo "</div><br>";
									echo "<table cellspacing=0 class='maintable'><tr class='headline'>";
									echo "<td align='center' width='2%'>&nbsp;</td>";
									echo "<td width='15%' align='center'><b>From Date</b></td>";
									echo "<td width='15%' align='center'><b>To Date</b></td>";
									echo "<td width='20%' align='center'><b>Applied For</b></td>";
									echo "<td width='28%' align='center'><b>Reason</b></td>";
									echo "<td width='20%' align='center'><b>Approved/Rejected By</b></td></tr>";
									if($noOfPages > 0) {
										while($row = mysql_fetch_array($leaveResult)){
											echo "<tr class='mainrow'><td class='cell1' align='center' width='2%'>";
											$flag = $row['approve_flag'];
											if($flag == 'PENDING'){
												echo "<img src='images/pending.GIF' />";
											} else {
												if($flag == 'REJECTED'){
													echo "<img src='images/rejected.GIF' />";
												} else {
													echo "<img src='images/approved.GIF' />";
												}
											}
											echo "</td><td class='cell1' align='center' width='15%'><b>".$row['from_date']."</b>";
									echo "</td><td align='center' class='cell1' width='15%'><b>".$row['to_date']."</b></td>";
									echo "<td align='center' class='cell1' width='20%'><b>".$row['applied_for_name']."</b></td>";
									echo "<td align='center' class='cell1' width='28%'><b>".$row['reason']."</b></td>";
									echo "<td align='center' class='cell1' width='20%'><b>".$row['approved_by_name']."</b></td></tr>";
										}
									} else {
										echo "<tr class='mainrow'><td colspan=6 align='center' class='cell1'><b>No Requests.</b></td></tr>";
									}
									echo '</table>';
									echo "<br><font size='3' face='Calibri' color='rgb(14,71,33)'>***&nbsp;&nbsp;&nbsp;<b>";
									echo "<img src='images/approved.GIF' />&nbsp;&nbsp;Leave Approved&nbsp;	&nbsp;&nbsp;&nbsp;";
									echo "<img src='images/pending.GIF' />&nbsp;&nbsp;Pending Approval&nbsp;&nbsp;&nbsp;&nbsp;";
									echo "<img src='images/rejected.GIF' />&nbsp;&nbsp;Leave Rejected</b></font>";	
								}
								if($designation == 'teacher') {
									$approveList = $_POST['leave'];

									$arrayLength = count($approveList);
									$teacherNameQuery = mysql_fetch_assoc(mysql_query("SELECT full_name FROM users WHERE username='$username'"));
									$teacherFullName = $teacherNameQuery['full_name'];
									for($j = 0; $j < $arrayLength; $j++){
										$id = $approveList[$j];
										if($_POST['request'] == 'Approve'){
										    $approveFlag = 'APPROVED';
											$leaveApplicationQuery = mysql_fetch_assoc(mysql_query("SELECT * FROM leaveapplication WHERE id='$id'"));
											$fromDateFromQuery = $leaveApplicationQuery['from_date'];
											$toDateFromQuery = $leaveApplicationQuery['to_date'];
											$leaveTypeFromQuery = $leaveApplicationQuery['leave_type'];
											$fromYear = substr($fromDateFromQuery,0,4);
											$fromMonth = substr($fromDateFromQuery,5,2);
											$studentUsername = $leaveApplicationQuery['applied_for'];
											if(substr($fromMonth,0,1) == '0'){
												$fromMonth = substr($fromMonth,1,1);
											}
											$fromDay = substr($fromDateFromQuery,8,2);
											if(substr($fromDay,0,1) == '0'){
												$fromDay = substr($fromDay,1,1);
											}
											$toYear = substr($fromDateFromQuery,0,4);
											$toMonth = substr($fromDateFromQuery,5,2);
											if(substr($toMonth,0,1) == '0'){
												$toMonth = substr($toMonth,1,1);
											}
											$toDay = substr($fromDateFromQuery,8,2);
											if(substr($toDay,0,1) == '0'){
												$toDay = substr($toDay,1,1);
											}
											$timeDifference =  strtotime($toDateFromQuery) - strtotime($fromDateFromQuery);
											$temp = $timeDifference/(24*60*60);
											if($fromDateFromQuery != $toDateFromQuery){
												$startDate = $fromDateFromQuery;
												$startMonth = $fromMonth;
												$startYear = $fromYear;
												$timeDifference =  strtotime($toDateFromQuery) - strtotime($fromDateFromQuery);
												$daysDifference = $timeDifference/(24*60*60);
												$columns = '';
												$values = '';
												$updateColumns = '';
												$tempDate = date("Y-m-d",strtotime("-1 Days",strtotime($startDate)));
												$presentDate = date("Y-m-d",strtotime("+1 Days",strtotime($tempDate)));
												$presentYear = substr($presentDate,0,4);
												$presentMonth = substr($presentDate,5,2);
												$presentDay = substr($presentDate,8,2);
												if(substr($presentDay,0,1) == '0'){
													$presentDay = substr($presentDay,1,1);
												}
												for($i = 0; $i <= $daysDifference; $i++){
													$presentDate = date("Y-m-d",strtotime("+1 Days",strtotime($tempDate)));
													$presentYear = substr($presentDate,0,4);
													$presentMonth = substr($presentDate,5,2);
													if(substr($presentMonth,0,1) == '0'){
														$presentMonth = substr($presentMonth,1,1);
													}
													$presentDay = substr($presentDate,8,2);
													if(substr($presentDay,0,1) == '0'){
														$presentDay = substr($presentDay,1,1);
													}
													if($presentMonth == $startMonth){
														$columns .= 'day'.$presentDay.',';
														$values .= "'VA',";
														$updateColumns .= 'day'.$presentDay."='VA',";
													} else{
														$validateQuery = mysql_num_rows(mysql_query("SELECT * FROM attendance WHERE username='$studentUsername' AND month='$startMonth' AND year='$presentYear'"));
														if($validateQuery == 0){
															$columns .= 'username,month,year,days_leave';
															$updateMonth = $startMonth - 1;
															$values .= "'$studentUsername','$updateMonth','$presentYear','$i'";
															$insertAttendanceQuery = "INSERT INTO attendance (".$columns.") VALUES (".$values.")";
															mysql_query($insertAttendanceQuery) or die ("Couldn't insert attendance data into table");
														} else {
															$updateColumns .= "month"."='$startMonth'";
															$updateAttendanceQuery = "UPDATE attendance SET ".$updateColumns." WHERE username='$studentUsername' AND month='$startMonth' AND year='$presentYear'";
															mysql_query($updateAttendanceQuery) or die ("Couldn't update the data in table");
															$creationDate = date("Y-m-d G:i:s");
															$activityMsg = 'Updated attendance for '.$studentUsername;
															$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationDate', '$activityMsg')";
															mysql_query($userActivityQuery);
														}
														$creationDate = date("Y-m-d G:i:s");
														$activityMsg = 'Updated attendance for '.$studentUsername;
														$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationDate', '$activityMsg')";
														mysql_query($userActivityQuery);
														$columns = '';
														$values = '';
														$updateColumns = '';
														$columns .= 'day'.$presentDay.',';
														$values .= "'VA',";
														$updateColumns .= 'day'.$presentDay."='VA',";
													}
													$startMonth = $presentMonth;
													$tempDate = $presentDate;
												}
												$validateQuery = mysql_num_rows(mysql_query("SELECT * FROM attendance WHERE username='$studentUsername' AND month='$startMonth' AND year='$presentYear'"));
												if($validateQuery == 0){
													$columns .= 'day'.$presentDay.',';
													$values .= "'VA',";
													$columns .= 'username,month,year';
													$values .= "'$studentUsername','$startMonth','$presentYear'";
													$insertAttendanceQuery = "INSERT INTO attendance (".$columns.") VALUES (".$values.")";
													mysql_query($insertAttendanceQuery) or die ("Couldn't insert attendance the data into table");
												} else {													
													$updateColumns .= 'day'.$presentDay."='VA',";
													$updateColumns .= "month"."='$startMonth'sss";
													$updateAttendanceQuery = "UPDATE attendance SET ".$updateColumns." WHERE username='$studentUsername' AND month='$startMonth' AND year='$presentYear'";
													mysql_query($updateAttendanceQuery) or die ("Couldn't update the data in table");
												}
												$creationDate = date("Y-m-d G:i:s");
												$activityMsg = 'Updated attendance for '.$studentUsername;
												$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationDate', '$activityMsg')";
												mysql_query($userActivityQuery);
											} else {
												$startDate = $fromDateFromQuery;
												$startMonth = $fromMonth;
												$startYear = $fromYear;
												$presentYear = substr($startDate,0,4);
												$presentMonth = substr($startDate,5,2);
												if(substr($presentMonth,0,1) == '0'){
													$presentMonth = substr($presentMonth,1,1);
												}
												$presentDay = substr($startDate,8,2);
												if(substr($presentDay,0,1) == '0'){
													$presentDay = substr($presentDay,1,1);
												}
												$dateColumn = 'day'.$presentDay;
												$validateQuery = mysql_num_rows(mysql_query("SELECT * FROM attendance WHERE username='$studentUsername' AND month='$presentMonth' AND year='$presentYear'"));
												if($validateQuery == 0){
													$insertAttendanceQuery = "INSERT INTO attendance (".$dateColumn.",username,month,year) VALUES ('VA','$studentUsername','$presentMonth','$presentYear')";
													mysql_query($insertAttendanceQuery) or die ("Couldn't insert the data into table");
												} else {
													$updateAttendanceQuery = "UPDATE attendance SET ".$dateColumn." = 'VA' WHERE username='$studentUsername' AND month='$presentMonth' AND year='$presentYear'";
													mysql_query($updateAttendanceQuery) or die ("Couldn't update the data in table");
												}
												$creationDate = date("Y-m-d G:i:s");
												$activityMsg = 'Updated attendance for '.$studentUsername;
												$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationDate', '$activityMsg')";
												mysql_query($userActivityQuery);
											}
										} else {
											if($_POST['request'] == 'Reject'){
												$approveFlag = 'REJECTED';
											}
										}
										$updateQuery = "UPDATE leaveApplication SET approve_flag='$approveFlag',approved_by='$username',approved_by_name='$teacherFullName' WHERE id='$id'";
										mysql_query($updateQuery) or die ("Not able to update the entry in database");
										$creationDate = date("Y-m-d G:i:s");
										$activityMsg = 'Took action on leave application';
										$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationDate', '$activityMsg')";
										mysql_query($userActivityQuery);
									}
								    echo '<ul>';
									echo '<li><a href="leaveApplication.php">Leave Applications</a></li>';
									echo '<li class="current_page_item"><a href="approveLeave.php">Approve Leave Applications</a></li>';
									echo '</ul><br>';
									$noOfRecords = 10;

									$approvalQuery = "SELECT * FROM leaveapplication a WHERE approve_flag='PENDING'";
									$noOfPages = ceil((mysql_num_rows(mysql_query($approvalQuery)))/$noOfRecords);

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

									$approveLeaveQuery = "SELECT * FROM leaveapplication a WHERE approve_flag='PENDING' ORDER BY from_date DESC LIMIT ";
									$approveLeaveQuery .= $startRow.', '.$noOfRecords;
									$approveLeaveResults = mysql_query($approveLeaveQuery);

									echo "<div align='right'>";
									echo "<a class='pagination' href='approveLeave.php?pageNo=$previousPage'>Previous Page</a>";
									echo "&nbsp;&nbsp;<a class='pagination' href='approveLeave.php?pageNo=$nextPage'>Next Page</a>";
									echo "</div><br>";
									echo "<table cellspacing=0 class='maintable'><tr class='headline'>";
									echo "<td align='center' width='3%'>&nbsp;</td>";
									echo "<td width='15%' align='center'><b>From Date</b></td>";
									echo "<td width='15%' align='center'><b>To Date</b></td>";
									echo "<td width='20%' align='center'><b>Applied For</b></td>";
									echo "<td width='20%' align='center'><b>Applied By</b></td>";
									echo "<td width='27%' align='center'><b>Reason</b></td></tr>";
									if($noOfPages > 0){
										echo '<form method="post" action="approveLeave.php">';
										while($row = mysql_fetch_array($approveLeaveResults)){
											echo "<tr class='mainrow'>";
											echo "<td class='cell1' align='center' width='3%'><input type='checkbox' name='leave[]' value='".$row['id']."'>";
											$flag = $row['approve_flag'];
											echo "</td>";
											echo "<td class='cell1' align='center' width='15%'><b>".$row['from_date']."</b></td>";
											if($row['to_date'] == '0000-00-00'){
												echo "<td align='center' class='cell1' width='15%'><b>-</b></td>";
											} else {
												echo "<td align='center' class='cell1' width='15%'><b>".$row['to_date']."</b></td>";
											}
											echo "<td align='center' class='cell1' width='20%'><b>".$row['applied_for_name']."</b></td>";
											echo "<td align='center' class='cell1' width='20%'><b>".$row['applied_by']."</b></td>";
											echo "<td align='center' class='cell1' width='27%'><b>".$row['reason']."</b></td></tr>";
										}
										echo '</table><br>';
										echo "<input type='submit' name='request' value='Approve' id='z'>";
										echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='request' value='Reject' id='z'>";
										echo "&nbsp;&nbsp;&nbsp;<input type='reset' name='reset' value='Reset' id='z'></form>";
										echo "<br><br><font size='3' face='Calibri' color='rgb(14,71,33)'>***&nbsp;&nbsp;&nbsp;<b>";
										echo "<img src='images/approved.GIF' />&nbsp;&nbsp;Leave Approved&nbsp;	&nbsp;&nbsp;&nbsp;";
										echo "<img src='images/pending.GIF' />&nbsp;&nbsp;Pending Approval&nbsp;&nbsp;&nbsp;&nbsp;";
										echo "<img src='images/rejected.GIF' />&nbsp;&nbsp;Leave Rejected</b></font>";	
									} else {
										echo "<tr class='mainrow'><td colspan=6 align='center' class='cell1'><b>No Pending Requests.</b></td></tr>";
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
