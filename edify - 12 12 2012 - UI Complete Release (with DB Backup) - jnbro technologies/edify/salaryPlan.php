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
		<title>Salary Plan</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
           	$username = $_SESSION['username'];
			$password = $_SESSION['password'];
$fullname = $_SESSION['fullname'];
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
				<p class="title"><?php echo $username ?> 's Salary Plan
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
     <?php
							if($designation == 'teacher' || $designation == 'librarian' || $designation == 'principal' || $designation == 'admin'){
								$salaryQuery = "SELECT * FROM salaryplan WHERE username = '$username'";
								$genderQuery = "SELECT a.gender, b.full_name FROM user_profile a, users b WHERE a.username = '$username' AND a.username = b.username";
								$genderResult = mysql_fetch_assoc(mysql_query($genderQuery));
								$salaryResult = mysql_fetch_assoc(mysql_query($salaryQuery));
								$gender = $genderResult['gender'];
								$full_name = $genderResult['full_name'];
								$basic = $salaryResult['basic'];
								$booksAndPeriodicals = $salaryResult['books'];
								$conveyanceAllowance = $salaryResult['conveyance'];
								$dearnessAllowance = $salaryResult['dearness'];
								$flexiBalancePay = $salaryResult['flexi'];
								$houseRentAllowance = $salaryResult['houserent'];
								$specialAllowance = $salaryResult['special'];
								$totalEarnings = $basic + $booksAndPeriodicals + $conveyanceAllowance + $dearnessAllowance + $flexiBalancePay + $houseRentAllowance + $specialAllowance;
								$pfAmount = ($basic + $dearnessAllowance)*12/100;
								$professionalTax = 200;
								$totalDeductions = $pfAmount + $professionalTax;
								$totalYearlyPay = ($totalEarnings + $totalDeductions)*12;
								if($gender == 'female'){
									if($totalYearlyPay > 500000) {
										$yearlyIncomeTax = round(51000 + (($totalYearlyPay - 500000)*30/100),2);
									} elseif ($totalYearlyPay > 300000) {
										$yearlyIncomeTax = round(11000 + (($totalYearlyPay - 300000)*20/100),2);
									} elseif ($totalYearlyPay > 190000) {
										$yearlyIncomeTax = round((($totalYearlyPay - 190000)*10/100),2);
									} else {
										$yearlyIncomeTax = 0;
									}
								} else {
									if($totalYearlyPay > 500000) {
										$yearlyIncomeTax = round(54000 + (($totalYearlyPay - 500000)*30/100),2);
									} elseif ($totalYearlyPay > 300000) {
										$yearlyIncomeTax = round(14000 + (($totalYearlyPay - 300000)*20/100),2);
									} elseif ($totalYearlyPay > 160000) {
										$yearlyIncomeTax = round((($totalYearlyPay - 160000)*10/100),2);
									} else {
										$yearlyIncomeTax = 0;
									}
								}
								$totalDeductions  = round(($totalDeductions + $yearlyIncomeTax/12),2);
						?>
						<table cellspacing="15px" width="100%">
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detailHeader">Earnings</h1></td>
								<td width="20%"><h1 class="detailHeader">Monthly</h1></td>
								<td width="20%"><h1 class="detailHeader">Yearly</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Basic</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($basic,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round(12*$basic,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Books and Periodicals</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($booksAndPeriodicals,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round(12*$booksAndPeriodicals,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Conveyance Allowance</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($conveyanceAllowance,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round(12*$conveyanceAllowance,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Dearness Allowance</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($dearnessAllowance,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round(12*$dearnessAllowance,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Flexi Balance Pay</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($flexiBalancePay,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round(12*$flexiBalancePay,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>House Rent Allowance</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($houseRentAllowance,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round(12*$houseRentAllowance,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Special Allowance</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($specialAllowance,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round(12*$specialAllowance,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Total Earnings</b></h1></td>
								<td width="20%">
									<h1 style="text-decoration:overline;" class="detail">Rs. 
										<?php
											echo round($totalEarnings,2);
										?> /-
									</h1>
								</td>
								<td width="20%">
									<h1 style="text-decoration:overline;" class="detail">Rs. 
										<?php
											echo round(12*$totalEarnings,2);
										?> /-
									</h1>
								</td>
								<td width="5%">&nbsp;</td>
							</tr><tr />
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detailHeader">Deductions</h1></td>
								<td colspan=3 width="45%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Provident Fund</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($pfAmount,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round(12*$pfAmount,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Income Tax</b></h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($yearlyIncomeTax/12,2); ?> /-</h1></td>
								<td width="20%"><h1 class="detail">Rs. <?php echo round($yearlyIncomeTax,2); ?> /-</h1></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="detail"><b>Total Deductions</b></h1></td>
								<td width="20%">
									<h1 style="text-decoration:overline;" class="detail">Rs. 
										<?php
											echo round($totalDeductions,2);
										?> /-
									</h1>
								</td>
								<td width="20%">
									<h1 style="text-decoration:overline;" class="detail">Rs. 
										<?php
											echo round(12*$totalDeductions,2);
										?> /-
									</h1>
								</td>
								<td width="5%">&nbsp;</td>
							</tr><tr />
							<tr>
								<td width="5%">&nbsp;</td>
								<td width="50%"><h1 class="netSalary"><b>Net Salary:</b></h1></td>
								<td width="20%">
									<h1 style="text-decoration:overline; font-size:17px;" class="detail"><b>Rs. 
										<?php 
											echo round($totalEarnings-$totalDeductions,2);
										?> /-
									</b></h1>
								</td>
								<td width="20%">
									<h1 style="text-decoration:overline; font-size:17px;" class="detail"><b>Rs. 
										<?php
											echo round(12*($totalEarnings-$totalDeductions),2); 
										?> /-
									</b></h1>
								</td>
								<td width="5%">&nbsp;</td>
							</tr>
						</table>
						<?php
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
