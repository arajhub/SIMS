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
<title>Fee Structure</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="default.js"></script>
       

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
				<p class="title">Fee Structure
			
			  
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
								if($designation == 'admin'){
							?>
							<ul>
								<li class="current_page_item"><a href="feeStructure.php">View Fee Structure</a></li>
								<li><a href="editFeeStructure.php">Edit</a></li>
								<li><a href="feePaymentHistory.php">Payment History</a></li>
							</ul><br>
							<?php
								}							
								$selectedStandard = $_GET['standard'];
								echo getDynamicStandardDropdown($selectedStandard);
								echo '<br><br>';
								$feeCateogryQuery = "SELECT DISTINCT category FROM fee_structure WHERE standard = '$selectedStandard' ORDER BY category";
								$feeCateogryResults = mysql_query($feeCateogryQuery);
								
								while ($line1 = mysql_fetch_assoc($feeCateogryResults)) {
									$currentCategory = $line1['category'];
									
									echo '<p style="font-size:15px; color:rgb(0,10,0); margin-left:60px; font-weight:bold"><u>'.$currentCategory.':</u></p>';
									
									$feeDetailsQuery = "SELECT id, standard, type, fee, date_format(due_date, '%D %b %Y') dueDate, admission_type, category, duration FROM fee_structure WHERE standard = '$selectedStandard' AND category = '$currentCategory' AND admission_type = 'Present Students' ORDER BY due_date";

									$feeDetailsResults = mysql_query($feeDetailsQuery);
									echo '<table cellpadding=5 cellspacing=0 style="color:rgb(19,77,91); font-size: 14px; float:center;  width:90%">';
									echo '<tr><td width="10%">&nbsp;</td>';
									echo '<td align="center" style="background-color: rgb(19,77,91); border-right: 1px solid white; color:white;" width="30%"><b>Fee</b></td>';
									echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; border-right: 1px solid white; color:white;" width="20%"><b>Amount</b></td>';
									echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white" width="20%"><b>Due Date</b></td>';
									echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white;" width="20%"><b>Monthly/Yearly</b></td></tr>';

									while ($line2 = mysql_fetch_assoc($feeDetailsResults)){
										echo '<tr><td width="10%">&nbsp;</td>';
										echo '<td style="border: 1px solid rgb(19,77,91);padding-left:10px;" align="left" width="30%">'.$line2['type'].'</td>';
										echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="20%">Rs. '.round($line2['fee'],2).'/-</td>';
										echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="20%">';
										if ($line2['dueDate'] == '') {
											echo '&nbsp;-&nbsp;';
										} else {
											echo $line2['dueDate'];
										}
										echo '</td>';
										echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="20%">'.$line2['duration'].'</td>';
										echo '</tr>';
									}
									mysql_free_result($feeDetailsResults);
									echo '</table><br><br>';
								}
								mysql_free_result($feeCategoryResults);
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
