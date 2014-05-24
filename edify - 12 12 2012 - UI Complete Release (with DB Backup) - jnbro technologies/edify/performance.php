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
	<title>Student's Performance</title>

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
								<li class="current_page_item"><a href="performance.php">Search</a></li>
								<li><a href="performance_add.php">Add</a></li>
								<li><a href="improvement.php">Areas of Improvement</a></li>
							</ul><br><br>
							<?php
								} elseif ($designation == 'student'){
							?>
							<ul>
								<li class="current_page_item"><a href="performance.php">Search</a></li>
							</ul><br><br>
							<?php
								} else {
							?>
							<ul>
								<li class="current_page_item"><a href="performance.php">Search</a></li>
								<li><a href="improvement.php">Areas of Improvement</a></li>
							</ul><br><br>
						<?php
							}
						?>
						</div>
					
					<div class="post_mailbox">
						<?php
							function colorHex($myImage, $HexColorString) {
								$R = hexdec(substr($HexColorString, 0, 2));
								$G = hexdec(substr($HexColorString, 2, 2));
								$B = hexdec(substr($HexColorString, 4, 2));
								return ImageColorAllocate($myImage, $R, $G, $B);
							}

							function colorHexshadow($myImage, $HexColorString, $mork) {
								$R = hexdec(substr($HexColorString, 0, 2));
								$G = hexdec(substr($HexColorString, 2, 2));
								$B = hexdec(substr($HexColorString, 4, 2));

								if ($mork) {
									($R > 99) ? $R -= 100 : $R = 0;
									($G > 99) ? $G -= 100 : $G = 0;
									($B > 99) ? $B -= 100 : $B = 0;
								} else {
									($R < 220) ? $R += 35 : $R = 255;
									($G < 220) ? $G += 35 : $G = 255;
									($B < 220) ? $B += 35 : $B = 255;				
								}			
								
								return ImageColorAllocate($myImage, $R, $G, $B);
							}
							if($designation == 'student') {
								echo getMarks($username);
								$userQuery = mysql_fetch_array(mysql_query("SELECT standard FROM users WHERE username='$username'"));
								$standard = $userQuery['standard'];
								echo getClassBarGraph($standard);
							} else {
								$selectedStudent = $_POST['selStudent'];
								$selectedStandard = $_GET['selStandard'];
								if($designation == 'parent') {
									$userQuery = mysql_fetch_array(mysql_query("SELECT standard FROM users WHERE username='$selectedStudent'"));
									$selectedStandard = $userQuery['standard'];
								}
								echo getFormUpdateForPerform($designation,$selectedStandard,$username,$section,$selectedStudent);
								echo '<br><br>';
								if($_POST){
									$selStudent = $_POST['selStudent'];
									$standard = 'II';
									$exam_type = 'Quaterly';
									echo getClassPieChart($selectedStandard, $exam_type);
									echo getMarks($selectedStudent);
									echo getClassBarGraph($selectedStandard);
								}
							}
						?>
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
