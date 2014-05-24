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
<title>Courses Offered</title>

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
				<p class="title">Courses Offered in the School
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <?php
								if($designation == 'admin') {
									echo '<ul><li><a href="editCourses.php">Edit Courses</a></li></ul>';
									$distinctClassQuery = "SELECT DISTINCT standard FROM courses_offered ORDER BY standard ASC";
									$distinctClassResult = mysql_query($distinctClassQuery);
									echo '<br>';
									while ($line = mysql_fetch_assoc($distinctClassResult)){
										$currentClass = $line['standard'];
										$coursesQuery = "SELECT * FROM courses_offered WHERE standard='$currentClass' ORDER BY courseId ASC";
										$coursesResult = mysql_query($coursesQuery);
										echo '<h2 class="h2">Class - '.$currentClass.'</h2>';
										echo '<table cellpadding=5 cellspacing=1 class="maintable">';
										echo '<tr><td width="10%">&nbsp;</td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); color:white;" width="30%">Course ID</td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); color:white" width="50%">Course Description</td>';
										echo '<td width="10%">&nbsp;</td></tr>';
										while ($line2 = mysql_fetch_assoc($coursesResult)){									
											echo '<tr><td width="10%">&nbsp;</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="30%">&nbsp;'.$line2['courseId'].'&nbsp;</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="50%">&nbsp;'.$line2['courseDesc'].'&nbsp;</td>';
											echo '<td width="10%">&nbsp;</td></tr>';
										}
										echo '</table><br><br>';
									}
									echo '';
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
