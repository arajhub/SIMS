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
<title>Register Student's Attendance</title>

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

			$today = date('l');
			$firstPeriodTeacherQuery = "SELECT * FROM firstperiodteachers WHERE username='$username' AND day='$today'";
			$firstPeriodTeacherDetails = mysql_fetch_assoc(mysql_query($firstPeriodTeacherQuery));
			$class = $firstPeriodTeacherDetails['standard'];
			$section = $firstPeriodTeacherDetails['section'];
			$slotsQuery = "SELECT * FROM mst_table where type_id='attendance_slots'";
			$slotsResult = mysql_fetch_assoc(mysql_query($slotsQuery));
			$noOfSlots = $slotsResult['value'];

			function fillWO($slot){
				$thisMonth= date("n");
				$thisYear = date("Y");
				$leapYearCheck = date("L");
				$temp = '';
				if($leapYearCheck){
					$daysInMonth = array(31,28,31,30,31,30,31,31,30,31,30,31);
				} else {
					$daysInMonth = array(31,27,31,30,31,30,31,31,30,31,30,31);
				}
				$thisMonthDays = $daysInMonth[$thisMonth - 1];
				$columnNames = '';
				$columnValues = '';
				for($i = 1; $i <= $thisMonthDays; $i++){
					$today = 'day'.$i;
					$dayOfWeek = date("D", mktime(0,0,0,$thisMonth,$i,$thisYear));
					if($dayOfWeek == 'Sun' || $dayOfWeek == 'Sat'){
						$columnNames .= "$today,";
						$columnValues .= "'WO',";
						$dd .= "$today = 'WO',";
					} else {
						$columnNames .= "$today,";
						$columnValues .= "'',";
						$dd .= "$today = '',";					
					}
				}
				$updateCondition = substr($dd,0,-1);
				$insertColumnNames = substr($columnNames,0,-1);
				$insertColumnValues = substr($columnValues,0,-1);
				$insertUpdateTable = mysql_query("INSERT INTO updation_table (id,table_nm,remarks) VALUES ('$thisMonth.$thisYear.$slot','attendance','Weekly Off')");
				$usernameList = mysql_query("SELECT username FROM users WHERE designation='student'");
				$usernameCount = mysql_num_rows(mysql_query("SELECT username FROM users WHERE designation='student'"));
				while ($line = mysql_fetch_assoc($usernameList)){
					$currUsername = $line['username'];
					$insertAttTable = "INSERT INTO attendance (username,month,$insertColumnNames,year,slot) VALUES ('$currUsername','$thisMonth',$insertColumnValues,'$thisYear','$slot')";
					$insertAttResult = mysql_query($insertAttTable	);
				}
				return $insertUpdateTable;
			}
			$todayMonth= date("n");
			$thisYear = date("Y");
			if ($noOfSlots > 1){
				for($i = 1; $i <= $noOfSlots; $i++){
					$updationCheckQuery = mysql_num_rows(mysql_query("SELECT * FROM updation_table WHERE table_nm='attendance' and remarks='Weekly Off' and id='$todayMonth.$thisYear.$i'"));
					if($updationCheckQuery < 1){
						$slot = $i;
						fillWO($slot);
					}
				}
			} else {
				$i = 1;
				$updationCheckQuery = mysql_num_rows(mysql_query("SELECT * FROM updation_table WHERE table_nm='attendance' and remarks='Weekly Off' and id='$todayMonth.$thisYear.$i'"));
				if($updationCheckQuery < 1){
					$slot = $i;
					fillWO($slot);
				}			
			}

			function getHolidays(){
				$holi = '<table>';
				$holidaysQuery ="SELECT * FROM holidays ORDER BY date asc";
				$holidaysDetails = mysql_query($holidaysQuery);
				while ($line = mysql_fetch_assoc($holidaysDetails)){
					$holi .= '<tr><td width="5%" class="td3"> </td><td width="25%" class="td3">'.$line['on_date'].'</td><td class="td3" width="5%">-</td>';
					$holi .= '<td width="60%" class="td3">'.$line['holiday'].'</td><td width="5%" class="td3"></td></tr>';
				}
				$holi .= '</table>';
				return $holi;
			}

			function studentList(){
				$username = $_SESSION['username'];
				$password = $_SESSION['password'];
				$loginQuery = "SELECT * FROM users WHERE username='$username' AND password='$password'";
				$loginDetails = mysql_fetch_assoc(mysql_query($loginQuery));
				$today = date('l');
				$firstPeriodTeacherQuery = "SELECT * FROM firstperiodteachers WHERE username='$username' AND day='$today'";
				$firstPeriodTeacherDetails = mysql_fetch_assoc(mysql_query($firstPeriodTeacherQuery));
				$class = $firstPeriodTeacherDetails['standard'];
				$section = $firstPeriodTeacherDetails['section'];
				$studentsQuery = "SELECT username,full_name FROM users WHERE standard='$class' and section='$section' and designation='student'";
				$studentsResult = mysql_query($studentsQuery);
				$rowNum = mysql_num_rows(mysql_query($StudentsQuery));
				$dd = '<br><table cellspacing=5 width="900px"><tr>';
				$dd .= '<td width="10%" class="td5_header">P/A</td>';
				$dd .= '<td width="50%" class="td5_header"> Student Name</td>';
				$dd .= '<td width="40%">&nbsp;</td></tr>';
				while($line = mysql_fetch_array($studentsResult)){
					$id = $line['username'];
					$value = $line['full_name'];
					$dd .= '<tr><td width="10%" class="td5_line"><center><input type="checkbox" name="studentName[]" value="'.$id.'"></center></td>';
					$dd .= '<td width="50%" class="td5_line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value.'</td>';
					$dd .= '<td width="40%" class="td5_line">&nbsp;</td></tr>';
				}
				$dd .= '</table><br><input type="submit" value="Store Attendance" id="y" />';
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
									if($designation == 'parent'){
										echo 'Children'."'s Attendance";
									} else {
										echo 'Add Student'."'s Attendance";
									}
								?>
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
          <?php
								if($designation == 'teacher'){
							?>
							
								<ul>
									<li><a href="attendance.php">Search</a></li>
									<li class="current_page_item"><a href="attendance_add.php">Add</a></li>
									
								
							</ul><br>
						</div>
						<?php
							if ($_GET){
								$presentDate = $_GET['date3'];
								$attendanceSlot = $_GET['Slot'];

								$selectedStuList = $_GET['studentName'];
								$presentYear = substr($presentDate,0,4);
								$presentMonth = substr($presentDate,5,2);
								if(substr($presentMonth,0,1) == '0'){
									$presentMonth = substr($presentMonth,1,1);
								}
								$presentDay = substr($presentDate,8,2);
								if(substr($presentDay,0,1) == '0'){
									$presentDay = substr($presentDay,1,1);
								}
								$arrayCount = sizeof($selectedStuList);
								$studentsQuery = "SELECT username,full_name FROM users WHERE standard='$class' and section='$section' and designation='student'";
								$studentsResult = mysql_query($studentsQuery);
								while($line = mysql_fetch_array($studentsResult)){
									$id = $line['username'];
									for($i = 0; $i < $arrayCount; $i++){
										$selectedStudent = $selectedStuList[$i];
										if($id == $selectedStudent){
											$attendanceFlag = 'Yes';
											break;
										} else {
											$attendanceFlag = 'No';
										}
									}
									$searchQuery = "SELECT * FROM attendance WHERE username='$id' AND month='$presentMonth' AND year='$presentYear' and slot='$attendanceSlot'";
									$searchResults = mysql_num_rows(mysql_query($searchQuery));
									$toDate = 'day'.$presentDay;
									if($searchResults >= 1){
										if($attendanceFlag == 'Yes'){
											$persistQuery = "UPDATE attendance set $toDate='PR', working_days=working_days+1, days_present=days_present+1 WHERE username='$id' AND month='$presentMonth' AND year='$presentYear' AND slot='$attendanceSlot'";
										} else {
											$persistQuery = "UPDATE attendance set $toDate='AB', working_days=working_days+1, days_present=days_present+1 WHERE username='$id' AND month='$presentMonth' AND year='$presentYear' AND slot='$attendanceSlot'";
										}
									} else {
										if($attendanceFlag == 'Yes'){
											$persistQuery = "INSERT INTO attendance (username,month,$toDate,working_days,days_present,year,slot) VALUES ('$id',$presentMonth,'PR',1,1,$presentYear,$attendanceSlot)";
										} else {
											$persistQuery = "INSERT INTO attendance (username,month,$toDate,working_days,days_present,year,slot) VALUES ('$id',$presentMonth,'AB',1,1,$presentYear,$attendanceSlot)";
										}
									}
									//echo $persistQuery;
									$persistResult = mysql_query($persistQuery) or die ('cannot insert');
									$attQuery = "SELECT day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31 FROM attendance WHERE username='$id' AND month='$presentMonth' AND year='$presentYear' AND slot='$attendanceSlot'";
									$attRows = mysql_num_rows(mysql_query($attQuery));
									if($attRows == 1){
										$attResult = mysql_fetch_assoc(mysql_query($attQuery));
										$presentCount = 0;
										$absentCount = 0;
										$workingDaysCount = 0;
										$leaveCount = 0;
										for($j = 0; $j <= 31; $j++){
											$toDate = 'day'.$j;
											if($attResult[$toDate] == 'PR'){
												$presentCount++;
												$workingDaysCount++;
											} elseif ($attResult[$toDate] == 'AB') {
												$absentCount++;
												$workingDaysCount++;
											} elseif ($attResult[$toDate] == 'SL' || $attResult[$toDate] == 'CL') {
												$leaveCount++;
												$workingDaysCount++;
											}
										}
										$updateQuery = "UPDATE attendance set working_days='$workingDaysCount', days_present='$presentCount', days_absent='$absentCount', days_leave='$leaveCount' WHERE username='$id' AND month='$presentMonth' AND year='$presentYear' AND slot='$attendanceSlot'";
										$updateResult = mysql_query($updateQuery);
									}
								}
								$creationDate = date("Y-m-d G:i:s");
								$activityMsg = 'Updated attendance for standard '.$class;
								$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationDate', '$activityMsg')";
								mysql_query($userActivityQuery);
							}
						?>
						<form id="searchform1" method="GET">
							<?php
								$myCalendar = new tc_calendar("date3", true);
								$myCalendar->setIcon("images/iconCalendar.gif");
								$myCalendar->setPath("./");
								$myCalendar->setYearInterval(1970, 2020);
								$myCalendar->writeScript();
								
								if ($noOfSlots > 1) {
									echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="Slot">';
									for($i = 1; $i <= $noOfSlots; $i++){
										echo '<option value="'.$i.'">Slot '.$i.'</option>';
									}
									echo '</select>';
								} else {
									echo '<input type="hidden" value="1" name="Slot" />';
								}
							?><br>
							<?php echo studentList(); ?>
						</form>
						<?php
							}
						?>
       
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
