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
<title>Leave Application</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       		<script language="javascript" src="calendar.js"></script>

</head>

<body>
<script language="JavaScript">
			function checkForm(){
				var fromDate, toDate, message;
				var leave_type = window.document.LeaveApplication.leave_type.value;
				message = trim(window.document.LeaveApplication.message.value);
				if(leave_type == 'SL') {
					fromDate = window.document.LeaveApplication.date3.value;
					if(fromDate == '0000-00-00') {
						alert('Please select a date on which you want a leave');
						window.document.LeaveApplication.flag.value = 'false';
						return false;
					} else if(message.length == 0) {
						alert('Please type the reason for the leave application');
						window.document.LeaveApplication.flag.value = 'false';
						return false;
					} else {
						window.document.LeaveApplication.flag.value = 'true';
					}
				}
				if(leave_type == 'VA') {
					fromDate = window.document.LeaveApplication.date3.value;
					toDate = window.document.LeaveApplication.date4.value;
					if(fromDate == '0000-00-00') {
						alert('Please select start date of the leave');
						window.document.LeaveApplication.flag.value = 'false';
						return false;
					} else if(toDate == '0000-00-00') {
						alert('Please select end date for the leave');
						window.document.LeaveApplication.flag.value = 'false';
						return false;
					} else if(message.length == 0) {
						alert('Please type the reason for the leave application');
						window.document.LeaveApplication.flag.value = 'false';
						return false;
					} else {
						window.document.LeaveApplication.flag.value = 'true';
					}
				}
			}
		   
			function pickLeaveType(){
				var leaveType = window.document.LeaveApplication.leave_type.value;
				window.location.replace('http://edify.atrisesolutions.com//leaveApplication.php?selLeaveType='+leaveType);
//			   window.location.replace('http://localhost/edify/leaveApplication.php?selLeaveType='+leaveType);
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
				<p class="title">Leave Application
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
  <?php
								if($designation == 'parent'){
									if(isset($_GET['flag'])) {
										echo '<ul>';
										echo '<li class="current_page_item"><a href="leaveApplication.php">Leave Applications</a></li>';
										echo '<li><a href="approveLeave.php">Leave Application History</a></li>';
										echo '</ul><br>';
										$fromDate = $_GET['date3'];
										$toDate = $_GET['date4'];
										if($toDate == ''){
										    $toDate = $fromDate;
										}
										$appliedBy = $username;
										$appliedFor = $_GET['child_name'];
										$leaveType = $_GET['leave_type'];
										$message = $_GET['message'];
										$message = str_replace("'","\'",$message);
										$message = str_replace('"','\"',$message);
										$parentNameQuery = mysql_fetch_assoc(mysql_query("SELECT full_name FROM users WHERE username='$username'"));
										$studentNameQuery = mysql_fetch_assoc(mysql_query("SELECT full_name FROM users WHERE username='$appliedFor'"));
										$appliedByName = $parentNameQuery['full_name'];
										$appliedForName = $studentNameQuery['full_name'];
										$insertQuery = "INSERT INTO leaveapplication (username,from_date,to_date,applied_by,applied_for,applied_for_name,leaveType,approve_flag,reason) VALUES ('$username','$fromDate','$toDate','$appliedByName','$appliedFor','$appliedForName','$leaveType','PENDING','$message')";
										$validateQuery = mysql_num_rows(mysql_query("SELECT * FROM leaveApplication WHERE username='$username' AND from_date='$fromDate' AND to_date='$toDate' AND applied_by='$appliedByName' AND applied_for='$appliedFor' AND applied_for_name='$appliedForName' AND leaveType='$leaveType'"));
										if($validateQuery == 0) {
											mysql_query($insertQuery) or die('<table class="maintable"><tr /><tr class="mainrow"><td align="center" class="cell1"><b>Could not insert into database .</b></td></tr><tr /></table>');
											echo '<table class="maintable"><tr />';
											echo '<tr class="mainrow">';
											echo '<td align="center" class="cell1"><b>You have successfully applied for the leave with the specified details.</b></td>';
											echo '</tr><tr /></table>';
										} else {
											print_r($_GET);
											echo '<table class="maintable"><tr /><tr class="mainrow"><td align="center" class="cell1"><b>You have already applied for the leave with the given details</b></td></tr><tr /></table>';
										}
									} else {
										echo '<ul>';
										echo '<li class="current_page_item"><a href="leaveApplication.php">Leave Applications</a></li>';
										echo '<li><a href="approveLeave.php">Leave Application History</a></li></ul><br><br>';
							?>
							<form name="LeaveApplication" method="GET">
								<table cellpadding=5 cellspacing=1 style="background:rgb(216,216,216); color:rgb(19,77,91); font-size: 14px; float:center; margin-left:0px; width:850px">
									<tr>
										<td width="7%">&nbsp;</td>
										<td width="10%"><b>Leave Type: </b></td>
										<td colspan=4>
											<select name="leave_type" onChange="pickLeaveType()">
											<?php
												if($_GET['selLeaveType'] == 'VA') {
													echo '<option value="SL">One Day Leave</option><option selected value="VA">Many Day Leave</option>';
												} else {
													$_GET['selLeaveType'] = 'SL';
													echo '<option selected value="SL">One Day Leave</option><option value="VA">Many Day Leave</option>';
												}
											?>
										</td>
										<td width="7%">&nbsp;</td>
									</tr>
									<tr /><tr /><tr /><tr />
									<?php
										if($_GET['selLeaveType'] == 'VA'){
									?>
									<tr>
										<td width="7%">&nbsp;</td>
										<td width="10%"><b>From Date: </b></td>
										<td width="30%">
											<?php
												$myCalendar = new tc_calendar("date3", true);
												$myCalendar->setIcon("images/iconCalendar.gif");
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(1970, 2020);
												$myCalendar->writeScript();
											?>
										</td>
										<td width="6%">&nbsp;</td>
										<td width="10%"><b>To Date: </b></td>
										<td width="30%">
											<?php
												$myCalendar = new tc_calendar("date4", true);
												$myCalendar->setIcon("images/iconCalendar.gif");
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(1970, 2020);
												$myCalendar->writeScript();
											?>
										</td>
										<td width="7%">&nbsp;</td>
									</tr>
									<?php
										} else {
									?>
									<tr>
										<td width="7%">&nbsp;</td>
										<td width="10%"><b>On Date: </b></td>
										<td width="30%">
											<?php
												$myCalendar = new tc_calendar("date3", true);
												$myCalendar->setIcon("images/iconCalendar.gif");
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(1970, 2020);
												$myCalendar->writeScript();
											?>
										</td>
										<td width="53%" colspan=4>&nbsp;</td>
									</tr>	
									<?php
										}
									?>							
									<tr /><tr /><tr /><tr />
									<tr>
										<td width="2%">&nbsp;</td>
										<td width="12%"><b>Student Name: </b></td>
										<td colspan=4>
											<?php echo childrenList($username); ?>
										</td>
										<td width="2%">&nbsp;</td>
									</tr>
									<tr /><tr /><tr /><tr />
									<tr>
										<td width="2%">&nbsp;</td>
										<td width="12%"><b>Reason:* </b></td>
										<td colspan=4><textarea cols="60" rows="10" name="message"></textarea></td>
										<td width="2%">&nbsp;</td>
									</tr>
								</table><br>
								<input type="hidden" name="flag">
								<input type="hidden" name="selLeaveType">
								<input name="submit" type="submit" value="Apply" onClick="return checkForm();" id="z">
							</form>
							<?php
									}
								} else {
									if($designation == 'teacher') {
										echo '<ul>';
										echo '<li class="current_page_item"><a href="leaveApplication.php">Leave Applications</a></li>';
										echo '<li><a href="approveLeave.php">Approve Leave Applications</a></li>';
										echo '</ul><br>';
										$noOfRecords = 10;
										
										$approvalQuery = "SELECT * FROM leaveapplication";
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
										
										$approveLeaveQuery = "SELECT * FROM leaveapplication ORDER BY from_date desc LIMIT ";
										$approveLeaveQuery .= $startRow.', '.$noOfRecords;
										$approveLeaveResults = mysql_query($approveLeaveQuery);
										echo "<div align='right'>";
										echo "<a class='pagination' href='leaveApplication.php?pageNo=$previousPage'>Previous Page</a>";
										echo "&nbsp;&nbsp;<a class='pagination' href='leaveApplication.php?pageNo=$nextPage'>Next Page</a>";
										echo "</div><br>";
										echo "<table cellspacing=0 class='maintable'>";
										echo "<tr class='headline'>";
										echo "<td align='center' width='3%'>&nbsp;</td>";
										echo "<td width='15%' align='center'><b>From Date</b></td>";
										echo "<td width='15%' align='center'><b>To Date</b></td>";
										echo "<td width='20%' align='center'><b>Applied For</b></td>";
										echo "<td width='20%' align='center'><b>Applied By</b></td>";
										echo "<td width='27%' align='center'><b>Reason</b></td></tr>";
										if($noOfPages > 0){
											while($row = mysql_fetch_array($approveLeaveResults)){
												echo "<tr class='mainrow'><td align='center' class='cell1' width='3%'>";
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
												echo "</td><td class='cell1' align='center' width='15%'><b>".$row['from_date']."</b></td>";
												if($row['to_date'] == '0000-00-00'){
													echo "<td align='center' class='cell1' width='15%'><b>-</b></td>";
												} else {
													echo "<td align='center' class='cell1' width='15%'><b>".$row['to_date']."</b></td>";
												}
												echo "<td align='center' class='cell1' width='20%'><b>".$row['applied_for_name']."</b></td>";
												echo "<td align='center' class='cell1' width='20%'><b>".$row['applied_by']."</b></td>";
												echo "<td align='center' class='cell1' width='27%'><b>".$row['reason']."</b></td></tr>";
											}
										} else {
											echo "<tr class='mainrow'><td colspan=6 align='center' class='cell1'></td></tr>";
										}
										echo '</table>';
										echo "<br><font size='3' face='Calibri' color='rgb(14,71,33)'>***&nbsp;&nbsp;&nbsp;<b>";
										echo "<img src='images/approved.GIF' />&nbsp;&nbsp;Leave Approved&nbsp;	&nbsp;&nbsp;&nbsp;";
										echo "<img src='images/pending.GIF' />&nbsp;&nbsp;Pending Approval&nbsp;&nbsp;&nbsp;&nbsp;";
										echo "<img src='images/rejected.GIF' />&nbsp;&nbsp;Leave Rejected</b></font>";										
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
