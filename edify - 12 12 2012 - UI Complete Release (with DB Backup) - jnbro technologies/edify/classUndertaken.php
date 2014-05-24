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
<title>Classes Undertaken</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
           	$username=$_SESSION['username'];
			$designation=$_SESSION['designation'];
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
			
				
				function getTimeTableForTeachers($username){
					$classes = '<table style="float:center" width="100%" cellspacing=1><td width="5%"></td><tr>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">Day</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">1st Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">2nd Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">3rd Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">4th Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">5th Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">6th Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">7th Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">8th Period</td></tr>';
					$classesQuery ="SELECT * FROM timetableforteachers WHERE username='$username' ORDER BY id ASC";
					$classesResult = mysql_query($classesQuery);
					while ($line = mysql_fetch_assoc($classesResult)){
						$classes .= '<tr>';
						$classes .= '<td width="10%" class="tdHeaderForTimetable"> '.$line['day'].' </td>';
						$classes .= '<td width="10%" class="tdDataForTimetable">&nbsp;'.$line['period1'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForTimetable">&nbsp;'.$line['period2'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForTimetable">&nbsp;'.$line['period3'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForTimetable">&nbsp;'.$line['period4'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForTimetable">&nbsp;'.$line['period5'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForTimetable">&nbsp;'.$line['period6'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForTimetable">&nbsp;'.$line['period7'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForTimetable">&nbsp;'.$line['period8'].'&nbsp;</td>';
						$classes .= '</tr>';
					}
					$classes .= '</table>';
					return $classes;
				}
				
				function getClassTimings($username){
					$classes = '<table style="float:center" width="100%" cellspacing=1><td width="5%"></td><tr>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">Day</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">1st Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">2nd Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">3rd Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">4th Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">5th Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">6th Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">7th Period</td>';
					$classes .= '<td width="10%" class="tdHeaderForTimetable">8th Period</td></tr>';
					$classesQuery ="SELECT * FROM classtimings ORDER BY id ASC";
					$classesResult = mysql_query($classesQuery);
					while ($line = mysql_fetch_assoc($classesResult)){
						$classes .= '<tr>';
						$classes .= '<td width="10%" class="tdHeaderForTimetable"> '.$line['day'].' </td>';
						$classes .= '<td width="10%" class="tdDataForClassTimings">&nbsp;'.$line['period1'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForClassTimings">&nbsp;'.$line['period2'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForClassTimings">&nbsp;'.$line['period3'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForClassTimings">&nbsp;'.$line['period4'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForClassTimings">&nbsp;'.$line['period5'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForClassTimings">&nbsp;'.$line['period6'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForClassTimings">&nbsp;'.$line['period7'].'&nbsp;</td>';
						$classes .= '<td width="10%" class="tdDataForClassTimings">&nbsp;'.$line['period8'].'&nbsp;</td>';
						$classes .= '</tr>';
					}
					$classes .= '</table>';
					return $classes;
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
				<p class="title">Timetable		
			  
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
								if($designation == 'teacher') {
									echo getTimeTableForTeachers($username);
									echo '<br><br><p class="links_mailbox">Class Timings</p>';
									echo getClassTimings();
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
