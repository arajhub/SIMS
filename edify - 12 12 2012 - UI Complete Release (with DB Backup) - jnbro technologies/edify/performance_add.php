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
<title>Register Student's Performance</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="performance.js"></script>
       

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
				<p class="title">Performance
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <?php
								if($designation == 'teacher' || $designation == 'principal' || $designation == 'admin'){

							?>
							<ul>
								<li><a href="performance.php">Search</a></li>
								<li class="current_page_item"><a href="performance_add.php">Add</a></li>
								<li><a href="improvement.php">Areas of Improvement</a></li>
							</ul><br><br><br><br>
							<?php
									$standard = $_GET['selStandard'];
									$selectedStudent = $_POST['selStudent'];
									$selectedMonth = $_POST['selMonth'];
									$arrayKeys = array_keys($_POST);
									$arrayValues = array_values($_POST);
									if($_POST['submitPerformance'] == 'Save Student Performance'){
										$examType = $_POST['exam_type'];
										$selectedMonth = $_POST['selMonth'];
										$thisYear = date("Y");
										$thisMonth = date("F");
										if($thisMonth > $selectedMonth) {
											$thisYear--;
										}
										$totalMarks = $_POST['ForTotalMarks'];
										$columnValues='';
										$totalMarksSecured = 0;
										for($i = 4; $i < count($_POST) - 2; $i++) {
											$j = $i - 3;
											$columnNames .= 'subject'.$j.', ';
											$columnValues .= "'".$arrayValues[$i]."', ";
											$totalMarksSecured += $arrayValues[$i];
										}
										
										$percentageSecured = $totalMarksSecured*100/$totalMarks;
										$gradeSecured = getGradeForGivenPercentage($percentageSecured);
		
										$columnNames .= 'username, standard, exam_type, totalMarks, month, year, marksSecured, grade';
										$columnValues .= "'".$selectedStudent."', '".$standard."', '".$examType."' ,'".$totalMarks."', '".$selectedMonth."', '".$thisYear."', '".$totalMarksSecured."', '".$gradeSecured."'";
										
										$insertQuery = "INSERT INTO ex_marks (".$columnNames.") VALUES (".$columnValues.")";
										mysql_query($insertQuery) or die ("Cannot inset into database");
										
										echo '<p class="td5">Record has been successfully stored in database.</p>';
										echo getFormUpdateForAddPerform($designation,'',$section,'');
										
										$activityDate = date("Y-m-d G:i:s");
										$activityMsg = 'Updated exam marks for '.$selectedStudent;
										$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
										mysql_query($userActivityQuery);
									} else {
										echo getFormUpdateForAddPerform($designation,$standard,$section,$selectedStudent);
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
