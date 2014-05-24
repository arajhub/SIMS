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
<title>Attendance</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

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

			$imageFileExten = '.jpg';
			$imageFileName = $username.$imageFileExten;
			$loginQuery = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$loginDetails = mysql_fetch_assoc(mysql_query($loginQuery));
			
			function getHolidays(){
				$holi = '<table width="100%">';
				$holidaysQuery ="SELECT * FROM holidays ORDER BY date asc";
				$holidaysDetails = mysql_query($holidaysQuery);
				while ($line = mysql_fetch_assoc($holidaysDetails)){
					$holi .= '<tr><td width="5%" class="td3">&nbsp;</td>';
					$holi .= '<td width="15%" class="td3">'.$line['on_date'].'</td>';
					$holi .= '<td width="5%" class="td3">-</td>';
					$holi .= '<td width="20%" class="td3">'.$line['holiday'].'</td>';
					$holi .= '<td width="55%" class="td3"></td></tr>';
				}
				$holi .= '</table>';
				return $holi;
			}
			
			function getSelectedMonthName($selMonth){
				$selMonth = is_null($selMonth) ? date('n', time()) : $selMonth;
				$monthName = array(
					1 => 'January',
					2 => 'February',
					3 => 'March',
					4 => 'April',
					5 => 'May',
					6 => 'June',
					7 => 'July',
					8 => 'August',
					9 => 'September',
					10 => 'October',
					11 => 'November',
					12 => 'December');
				return $monthName[$selMonth];
			}

			function monthDropdown($selMonth) {
				$selMonth = is_null($selMonth) ? date('n', time()) : $selMonth;
				$dd = ' ';

				for ($i = 1; $i <= 12; $i++) {
					$dd .= '<option value="'.$i.'"';
					if ($i == $selMonth)
					{
							$dd .= ' selected';
					}
					/*** get the month ***/
					$mon = date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));
					$dd .= '>'.$mon.'</option>';
				}
				return $dd;
			}

			function studentDropdownForAttendance($selStudent){
				$username = $_SESSION['username'];
				$password = $_SESSION['password'];
				
				
				$loginQuery = "SELECT * FROM users WHERE username='$username' AND password='$password'";
				$loginDetails = mysql_fetch_assoc(mysql_query($loginQuery));
				if($loginDetails['designation']=='parent'){
					$studentsQuery = "SELECT username,full_name FROM users WHERE parent='$username' and designation='student'";
				}
				if($loginDetails['designation']=='teacher'){
					$today = date('l');
					$firstPeriodTeacherQuery = "SELECT * FROM timetableforteachers WHERE username='$username' AND day='$today'";
					$firstPeriodTeacherDetails = mysql_fetch_assoc(mysql_query($firstPeriodTeacherQuery));
					$class = $firstPeriodTeacherDetails['period1'];
					$class = strtok($class, " ");
					$section = $loginDetails['section'];
					$studentsQuery = "SELECT username,full_name FROM users WHERE standard='$class' and section='$section' and designation='student'";
				}
				if($loginDetails['designation'] == 'principal' or $loginDetails['designation'] == 'admin'){
					$studentsQuery = "SELECT username,full_name FROM users WHERE designation='student'";
				}
				$studentsResult = mysql_query($studentsQuery);
				$rowNum = mysql_num_rows(mysql_query($StudentsQuery));
				$dd = ' ';
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

			function getMonthWiseAtten($selStudent){
				updateAttendanceCorrectly($selStudent);
				$msr = ' ';				
				$masterTableQuery = "SELECT * FROM mst_table where type_id='attendance_slots'";
				$masterTableResult = mysql_fetch_assoc(mysql_query($masterTableQuery));
				$noOfSlots = $masterTableResult['value'];
				if($noOfSlots > 1){
					$slotsValidValues = '(';
					for($k = 1; $k <= $noOfSlots; $k++){
						$slotsValidValues .= $k;
						if($k != $noOfSlots){
							$slotsValidValues .= ',';
						}
					}
					$slotsValidValues .= ')';
					$monthwiseQuery = "SELECT month,year,working_days,days_present,days_absent,days_leave,slot FROM attendance WHERE username='$selStudent' and slot in $slotsValidValues order by year,month,slot asc";
					$monthwiseResult = mysql_query($monthwiseQuery);
					$precentageQuery = "SELECT sum(working_days) 'WD', sum(days_present) 'DP', sum(days_absent) 'DA', sum(days_leave) 'DL' FROM attendance WHERE username='$selStudent'";
					$attPercentage = mysql_fetch_assoc(mysql_query($precentageQuery));
				} else {
					$monthwiseQuery = "SELECT month,year,working_days,days_present,days_absent,days_leave,slot FROM attendance WHERE username='$selStudent' and slot=1 order by year,month,slot asc";
					$monthwiseResult = mysql_query($monthwiseQuery);
					$precentageQuery = "SELECT sum(working_days) 'WD', sum(days_present) 'DP', sum(days_absent) 'DA', sum(days_leave) 'DL' FROM attendance WHERE username='$selStudent' and slot=1";
					$attPercentage = mysql_fetch_assoc(mysql_query($precentageQuery));
				}
				
				$overrallPercentage = round($attPercentage['DP']/$attPercentage['WD']*100,2);
				/*** Print Column Headings ***/
				$msr .='<p class="title1">Monthwise Attendance</p>';
				$msr .= '<br><table cellspacing=0><tr><td width="5%"></td><td class="td1" width="13%"><center>Month</center></td><td class="td1" width="12%"><center>Slot</center></td><td class="td1" width="13%"><center>No. of Working Days</center></td>';
				$msr .= '<td class="td1" width="13%"><center>No. of Days Present</center></td><td class="td1" width="13%"><center>No. of Days Absent</center></td><td class="td1" width="13%"><center>Leave</center></td>';
				$msr .= '<td class="td1" width="13%"><center>Attendance Percentage</center></td><td width="5%"></td></tr>';	
				$temp = $monthwiseResult;
				/*** Print Column Data ***/
				while ($line = mysql_fetch_array($monthwiseResult)){
					$firstMonth = $line['month'];
					$attendancePercent = $line['days_present']/$line['working_days']*100;
					$roundedPercentage= round($attendancePercent,2);
					if($firstMonth == $secondMonth){
						$msr .= '<tr><td width="5%"></td><td class="td1" width="13%">&nbsp;</td>';
					} else {
						$msr .= '<tr><td width="5%"></td><td class="td1" width="13%"><center>&nbsp;'.getSelectedMonthName($line['month']).'-'.$line['year'].'&nbsp;</center></td>';
					}
					$msr .= '<td class="td1" width="12%"><center>&nbsp;'.$line['slot'].'&nbsp;</center></td>';
					$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$line['working_days'].'&nbsp;</center></td>';
					$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$line['days_present'].'&nbsp;</center></td>';
					$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$line['days_absent'].'&nbsp;</center></td>';
					$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$line['days_leave'].'&nbsp;</center></td>';
					$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$roundedPercentage.'&nbsp;</center></td>';
					$msr .= '<td width="5%"></td></tr>';
					$secondMonth = $line['month'];
				}

				/*** Print total percentage of attendance ***/
				$msr .= '<tr><td width="5%"></td><td class="td1" width="13%"><center>Total</center></td>';
				$msr .= '<td class="td1" width="12%"><center>&nbsp;</center></td>';
				$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$attPercentage['WD'].'&nbsp;</center></td>';
				$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$attPercentage['DP'].'&nbsp;</center></td>';
				$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$attPercentage['DA'].'&nbsp;</center></td>';
				$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$attPercentage['DL'].'&nbsp;</center></td>';
				$msr .= '<td class="td1" width="13%"><center>&nbsp;'.$overrallPercentage.'&nbsp;</center></td>';
				$msr .= '<td width="5%"></td></tr>';
				$msr .= '</table>';
				return $msr;
			}

			function getAttendance($selStudent,$selMonth) {
				$selMonth = is_null($selMonth) ? date('n', time()) : $selMonth;
				$selYear = date('o', time());
				$selMonthName = getSelectedMonthName($selMonth);

				$attQuery = "SELECT * FROM attendance where username='$selStudent' and month='$selMonth' order by slot";
				$masterTableQuery = "SELECT * FROM mst_table where type_id='attendance_slots'";
				$masterTableResult = mysql_fetch_assoc(mysql_query($masterTableQuery));
				$noOfSlots = $masterTableResult['value'];
				$attRows = mysql_num_rows(mysql_query($attQuery));
				$attDetails = mysql_fetch_assoc(mysql_query($attQuery));
				$num = cal_days_in_month(CAL_GREGORIAN, $selMonth, 2009);
				$data = '<br><p class="title1">Attendance for the month of '.$selMonthName.'</p>';
				if($attRows >  0){
					$firstColumnWidth = 3+14;
					$data .= '<br><table class="attendancetable" width="100%" cellspacing=0><tr><td width="3%"></td><td class="td2" width="14%">Date</td>';
					for ($i = 1; $i <= 15; $i++){
						$data .= '<td class="td1" width="5%"><center>'.$i.'</center></td>';
					}
					$firstColumnWidth += 15*5;
					$firstColumnWidth = 100 - $firstColumnWidth;
					$data .= '<td width="'.$firstColumnWidth.'%"></td></tr>';
					
					if ($noOfSlots > 1){
						$attendanceResult = mysql_query($attQuery);
						$k = 1;
						$slotsValidValues = '(';
						for($z = 1; $z <= $noOfSlots; $z++){
							$slotsValidValues .= $k;
							if($z != $noOfSlots){
								$slotsValidValues .= ',';
							}
						}
						$slotsValidValues .= ')';
						while ($line = mysql_fetch_array($attendanceResult)) {
							$data .= '<tr><td width="3%"></td><td class="td2"  width="14%">Slot '.$k.'-Attendance</td>';
							for ($i = 1; $i <= 15; $i++){
								$columnName = 'day'.$i;
								$data .= '<td class="td1" width="5%"><center>'.$line[$columnName].'&nbsp;</center></td>';
							}
							$data .= '<td width="'.$firstColumnWidth.'%"></td></tr>';
							$k++;
						}						
					} else {
						$data .= '<tr><td width="3%"></td><td class="td2"  width="14%">Attendance</td>';
						for ($i = 1; $i <= 15; $i++){
							$columnName = 'day'.$i;
							$data .= '<td class="td1" width="5%"><center>'.$attDetails[$columnName].'&nbsp;</center></td>';
						}
						$data .= '<td width="'.$firstColumnWidth.'%"></td></tr>';
					}
					
					$data .= '</table><br>';
					$data .= '<table class="attendancetable" width="100%" cellspacing=0><tr><td width="3%"></td><td class="td2" width="14%">Date</td>';
					$secondColumnWidth = 3+14;
					for ($i = 16; $i <= $num; $i++){
						$data .= '<td class="td1" width="5%"><center>'.$i.'&nbsp;</center></td>';
					}
					$secondColumnWidth += ($num-15)*5;
					$secondColumnWidth = 100 - $secondColumnWidth;
					$data .= '<td width="'.$secondColumnWidth.'%"></td></tr>';
					
					
					if ($noOfSlots > 1){
						$k = 1;
						$attendanceResult = mysql_query($attQuery);
						while ($line = mysql_fetch_array($attendanceResult)) {
							$data .= '<tr><td width="3%"></td><td class="td2"  width="14%">Slot '.$k.'-Attendance</td>';
							for ($i = 16; $i <= $num; $i++){
								$columnName = 'day'.$i;
								$data .= '<td class="td1" width="5%"><center>'.$line[$columnName].'&nbsp;</center></td>';
							}
							$data .='<td width="'.$secondColumnWidth.'%"></td></tr>';
							$k++;
						}						
					} else {
						$data .= '<tr><td width="3%"></td><td class="td2"  width="14%">Attendance</td>';
						for ($i = 16; $i <= $num; $i++){
							$columnName = 'day'.$i;
							$data .= '<td class="td1" width="5%"><center>'.$attDetails[$columnName].'&nbsp;</center></td>';
						}
						$data .='<td width="'.$secondColumnWidth.'%"></td></tr>';
					}					
					$data .= '</table><p class="note">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* PR - Present, AB - Absent, NH - National Holiday, SH - School Holiday, WO - Weekly Off, SL - Sick Leave, VA - Vacation, CL - Casual Leave</p><br><br>';
					$data .= getMonthWiseAtten($selStudent);
				} else {
					$data .='<br><p class="perDetails">No records found ...</p><br><br>';
				}
				return $data;
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
				<p class="title"> <?php
									if($loginDetails['designation'] == 'parent'){
										echo 'Children'."'s Attendance";
									} else {
										echo 'Student'."'s Attendance";
									}
								?>
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
        
							
							<?php
								if($loginDetails['designation'] == 'teacher'){
							?>
							
								<ul>
									<li  class="current_page_item"><a href="attendance.php">Search</a></li>
									<li  ><a href="attendance_add.php">Add</a></li>
									
								</ul>
							<br>
							<?php
								}
							?>
						</div>
						<form id="searchform1" method="GET">
							<select class="monthFullname" name="selMonth">
								<?php
									$selMonth = $_GET['selMonth'];
									echo monthDropdown($selMonth);
								?>
							</select>&nbsp;&nbsp;&nbsp;&nbsp;
							<?php
								if($designation != 'student'){
									echo '<select class="dynamicstudent" name="selStudent">';
									$selStudent = $_GET['selStudent'];
									echo studentDropdownForAttendance($selStudent);
								}
							?>
							<input type="submit" value="Get Attendance" id="y" />
						</form>
						<?php
							if($designation == 'student'){
								$selStudent = $username;
							}

							if($_GET){
								$selMonth = $_GET['selMonth'];
								$_SESSION['month']=$selMonth;
								if($designation == 'student'){
									$selStudent = $username;
								} else {
									$selStudent = $_GET['selStudent'];
								}
								echo getAttendance($selStudent,$selMonth);
							} else {
								echo '<br><br><br><br><br>';
							}
						?>
					
					<div class="post_mailbox">
						<div class="entry_mailbox">
							<p class="h2">Holidays</p><?php echo getHolidays(); ?>
						</div>
					</div>
        </div></div>
      
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
