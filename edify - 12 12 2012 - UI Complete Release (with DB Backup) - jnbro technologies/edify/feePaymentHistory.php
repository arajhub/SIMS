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
<title>Fee Payment History</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
	<script language="javascript" src="default.js"></script>
       

</head>

<body>
<?php
 loadtheme();
?>
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
				<p class="title">Payment History
			
			  
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
								<li><a href="feeStructure.php">View Fee Structure</a></li>
								<li><a href="editFeeStructure.php">Edit</a></li>
								<li class="current_page_item"><a href="feePaymentHistory.php">Payment History</a></li>
							</ul><br>
							<?php
									$selectedStandard = $_GET['standard'];
									$selectedStudent = $_GET['student'];
									$selectedFeeType = $_GET['feetype'];
									$amount = $_POST['amountToBePaid'];
									echo getDynamicStanStuDropdown($selectedStandard, $selectedStudent);
									
									if ($selectedStudent != null){
										
										echo '<form id="searchform1" name="makeNewPayment" method="POST">';
										$subValue = $_POST['subValue'];
										if($_POST['subValue'] != 'Make New Payment' && $selectedFeeType == null) {
											echo '<input style="margin-left:300px" type="submit" name="subValue" id="z" value="Make New Payment" />';
										} else if($_POST['subValue'] == 'Paid' && is_numeric($amount)) {
											$paymentDate = date("Y-m-d");
											$paymentQuery = "INSERT INTO fee_payment (username, standard, feeid, paymentdate, amountPaid, issuedby) VALUES ('$selectedStudent', '$selectedStandard', '$selectedFeeType', '$paymentDate', '$amount', '$username')";
											mysql_query($paymentQuery);
											echo '<input style="margin-left:300px" type="submit" name="subValue" id="z" value="Make New Payment" />';
											echo '<p style="font-size:15px; color:rgb(19,77,91); margin-left:50px; font-weight:bold">Successfully made Payment !!!</p>';
										} else {
											echo '<br><font class="font1">Towards: &nbsp;&nbsp;</font><select class="feename" onchange="javascript:selectFeeType();" name="feetype">';
											echo getFeeTypeDropdown($selectedStandard, $selectedFeeType);
											echo '</select>';
											echo '<input type="hidden" name="standard" value="'.$selectedStandard.'"/>';
											echo '<input type="hidden" name="student" value="'.$selectedStudent.'"/>';
											if($_GET['feetype'] != null){
												$query = "SELECT fee FROM fee_structure WHERE id = '$selectedFeeType'";
												$result = mysql_fetch_array(mysql_query($query));
												$totalAmount = $result['fee'];
												$query = "SELECT sum(amountpaid) amount FROM fee_payment WHERE feeid='$selectedFeeType' AND username = '$selectedStudent' AND standard = '$selectedStandard'";
												$result = mysql_fetch_array(mysql_query($query));
												$amountPaid = $result['amount'];
												
												if ($amount != null and !is_string($amount)){
													$amountToBePaid = $amount;
												} else {
													$amountToBePaid = round(($totalAmount - $amountPaid),2);
												}
												
												
												echo '<br><br><font class="font1">Actual Amount: &nbsp;&nbsp;</font><font class="font1">'.round($totalAmount,2).' Rs.</font>';
												echo '<br><br><font class="font1">Amount Paid: &nbsp;&nbsp;</font><font class="font1">'.round($amountPaid,2).' Rs.</font>';
												echo '<br><br><font class="font1">Amount To Be Paid: &nbsp;&nbsp;<input c"font1" type="text" name="amountToBePaid" value="'.$amountToBePaid.'"/> Rs.</font>';
												echo '<input style="margin-left:30px" type="submit" value="Paid" name="subValue" id="z"/><br><br><br>';
											}
										}
										echo '</form>';
										
										$paymentHistoryQuery = "SELECT a.id, a.paymentdate, a.amountpaid, b.fee, b.type, a.issuedby, c.full_name FROM fee_payment a, fee_structure b, users c WHERE a.standard = '$selectedStandard' AND a.username = '$selectedStudent' AND a.feeid = b.id AND a.issuedby = c.username ORDER BY a.feeid, a.paymentdate DESC";
										$paymentHistoryRows = mysql_num_rows(mysql_query($paymentHistoryQuery));
										$noOfRecords = 10;
										$noOfPages = ceil($paymentHistoryRows/$noOfRecords);
										if($_GET['pageNo'] > 0) {
											$pageNo = $_GET['pageNo'];
											if($pageNo >= $noOfPages){
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
										$paymentHistoryQuery .= ' LIMIT '.$startRow.', '.$noOfRecords;
										$paymentHistoryResults = mysql_query($paymentHistoryQuery);
										//echo $paymentHistoryQuery;
										
										if (!$paymentHistoryResults) {
											echo '<p class="norecordsmsg">No Records Found</p>';
										} else {											
											if($paymentHistoryRows > 0){
												echo "<div style='padding-right:50px' align='right'>";
												echo "<a class='pagination' href='feePaymentHistory.php?pageNo=$previousPage&standard=$selectedStandard&student=$selectedStudent'>Previous Page</a>&nbsp;&nbsp;";
												echo "<a class='pagination' href='feePaymentHistory.php?pageNo=$nextPage&standard=$selectedStandard&student=$selectedStudent'>Next Page</a>";
												echo "</div><br>";
												echo '<table cellpadding=5 cellspacing=0 style="color:rgb(19,77,91); font-size: 14px; float:center; margin-left:0px; width:99%;">';
												echo '<tr><td width="0%"></td>';
												echo '<td align="center" style="background-color: rgb(19,77,91); border-right: 1px solid white; color:white;" width="30%"><b>Towards</b></td>';
												echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; border-right: 1px solid white; color:white;" width="10%"><b>Actual Amount</b></td>';
												echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; border-right: 1px solid white; color:white;" width="10%"><b>Amount Paid</b></td>';
												echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; border-right: 1px solid white; color:white;" width="20%"><b>Paid On</b></td>';
												echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white;" width="20%"><b>Received by</b></td></tr>';

												while ($line = mysql_fetch_assoc($paymentHistoryResults)){									
													echo '<tr><td width="0%"></td>';
													echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="30%">&nbsp;'.$line['type'].'&nbsp;</td>';
													echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="10%">&nbsp;'.round($line['fee'],2).'&nbsp;</td>';
													echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="10%">&nbsp;'.round($line['amountpaid'],2).'&nbsp;</td>';
													echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="20%">&nbsp;'.$line['paymentdate'].'&nbsp;</td>';
													echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="20%">&nbsp;'.$line['full_name'].'&nbsp;</td>';
													echo '</tr>';
												}
												echo '</table><br><br>';
											} else {
												echo '<br><br><p class="norecordsmsg">No Records Found !!!</p>';
											}
											mysql_free_result($paymentHistoryResults);
											
										}
									}
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
