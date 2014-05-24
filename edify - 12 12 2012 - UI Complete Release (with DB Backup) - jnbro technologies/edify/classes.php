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
           	$username = $_SESSION['username'];
			$password = $_SESSION['password'];
			$imageFileExten = '.jpg';
			$imageFileName = $username.$imageFileExten;
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
			function getClassesUndertaken($username){
                $classes = '<table width="100%" cellspacing=0><tr><td width="5%"></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>Day</center></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>1st Period</center></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>2nd Period</center></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>3rd Period</center></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>4th Period</center></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>5th Period</center></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>6th Period</center></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>7th Period</center></td>';
				$classes .= '<td width="10%" class="tdHeader"><center>8th Period</center></td>';
				$classes .= '<td width="5%"></td></tr>';
                $classesQuery ="SELECT * FROM timetableforteachers WHERE username='$username' ORDER BY id ASC";
                $classesResult = mysql_query($classesQuery);
                while ($line = mysql_fetch_assoc($classesResult)){
					$todayDay = $line['day'];
					$classes = '<tr><td width="5%"></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['day'].'</center></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['period1'].'</center></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['period2'].'</center></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['period3'].'</center></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['period4'].'</center></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['period5'].'</center></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['period6'].'</center></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['period7'].'</center></td>';
					$classes .= '<td width="10%" class="tdHeader"><center>'.$line['period8'].'</center></td>';
					$classes .= '<td width="5%"></td></tr>';
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
				<p class="title">Classes Undertaken
			
			  
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
          <?php echo getClassesUndertaken($username); ?><br><br>
							<p class="pagination">Time Table</p>
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
