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
<title>Edit Fee Structure</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="calendar.js"></script>
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
				<p class="title">Edit Fee Structure
			
			  
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
								<li class="current_page_item"><a href="editFeeStructure.php">Edit</a></li>
								<li><a href="feePaymentHistory.php">Payment History</a></li>
							</ul><br><br><br><br>
							<?php
								}
								$selectedStandard = $_GET['standard'];
								echo getDynamicStandardDropdown($selectedStandard);

								echo '<br>';
								$newRows = 0;
								//print_r($_POST);
								if($selectedStandard != null)
								{									
									if($_POST['subValue'] == 'Add New' || $_POST['subValue'] == 'Update') {
										$newRows = ($_POST['newRows'] != null) ? $_POST['newRows'] : $newRows;
										$newRows = ($_POST['subValue'] == 'Add New') ? $newRows + 1 : $newRows;
										$existingIds = $_POST['oldIds'];
										$newIds = $_POST['newIds'];
										$feeNames = $_POST['feenames'];
										$newFeeNames = $_POST['newfeenames'];
										$feeAmounts = $_POST['feeamount'];
										$newFeeAmounts = $_POST['newfeeamount'];
										$feeCategories = $_POST['feecategory'];
										$newFeeCategories = $_POST['newfeecategory'];
										$feeTypes = $_POST['feetype'];
										$newFeeTypes = $_POST['newfeetype'];
										$existingRows = count($existingIds);
										$validationResult = 'Success';
										for($i = 0; $i < $existingRows; $i++) {
											$currentId = $existingIds[$i];
											$currentFeeType = $feeTypes[$i];
											$currentFeeAmount = $feeAmounts[$i];
											$currentFeeCategory = $feeCategories[$i];
											if(is_nan($currentFeeAmount)){
												$validationResult = 'Error';
												break;
											}
										}
										for($i = 0; $i < $newRows; $i++) {
											$currentFeeAmount = $newFeeAmounts[$i];
											$currentFeeName = $newFeeNames[$i];
											if(is_nan($currentFeeAmount) || strlen($currentFeeName) == 0){
												$validationResult = 'Error';
												break;
											}
										}
										$validationResult = ($_POST['subValue'] == 'Add New') ? 'Error' : $validationResult;
										if($validationResult == 'Error') {
											echo '<form name="feeStructure" method="POST"><table cellpadding=5 cellspacing=0 style="color:rgb(19,77,91); font-size: 14px; float:center; margin-left:10px; width:90%">';
											echo '<tr><td width="0%"></td>';
											echo '<td align="center" style="background-color: rgb(19,77,91); border-right: 1px solid white; color:white;" width="20%"><b>Fee</b></td>';
											echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; border-right: 1px solid white; color:white;" width="15%"><b>Amount</b></td>';
											echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white" width="25%"><b>Due Date</b></td>';
											echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white" width="15%"><b>Category</b></td>';
											echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white;" width="20%"><b>Monthly/Yearly</b></td></tr>';
											$j = 1;
											for($i = 0; $i < $existingRows; $i++){
												$currentNumber = 'date'.$j;
												$currentDate = $_POST[$currentNumber];
												$day = substr($currentDate,8,2);
												$month = substr($currentDate,5,2);
												$year = substr($currentDate,0,4);
												$currentFeeType = $feeTypes[$i];
												$currentFeeCategory = $feeCategories[$i];;
												echo '<tr><td width="0%">';
												echo '<input type="hidden" name="feenames[]" value="'.$feeNames[$i].'">';
												echo '<input type="hidden" name="oldIds[]" value="'.$existingIds[$i].'">'; 
												echo '</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);padding-left:10px;" align="left" width="20%">'.$feeNames[$i].'</td>';
												echo '<td style="border: 1px solid rgb(19,77,91); font-weight:bold;" align="center" width="15%">Rs. ';
												echo '<input name="feeamount[]" type="text" class="feeamount" value="'.round($feeAmounts[$i],2).'"/> /-</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="25%">';
													$myCalendar = new tc_calendar($currentNumber, true);
													$myCalendar->setIcon("images/iconCalendar.gif");
													$myCalendar->setDate($day, $month, $year);
													$myCalendar->setPath("./");
													$myCalendar->setYearInterval(2010, 2011);
													$myCalendar->writeScript();
												echo '</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="15%">';
												echo '<select class="feecategory" name="feecategory[]">'.getFeeCategoryDropdown($currentFeeCategory).'</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="20%">';
												echo '<select class="feetype" name="feetype[]">'.feeTypeDropdown($currentFeeType).'</td>';
												echo '</tr>';
												$j++;
											}
											for($i = 0; $i < $newRows; $i++){												
												$currentNumber = 'date'.$j;
												$currentDate = $_POST[$currentNumber];
												$day = substr($currentDate,8,2);
												$month = substr($currentDate,5,2);
												$year = substr($currentDate,0,4);
												$currentFeeType = $newFeeTypes[$i];
												$currentFeeCategory = $newFeeCategories[$i];;
												echo '<tr><td width="5%">';
												echo '<input type="hidden" name="newIds[]" value="'.$newIds[$i].'">';
												echo '</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);padding-left:10px;" align="left" width="20%">';
												echo '<input class="feename" type="text" name="newfeenames[]" value="'.$newFeeNames[$i].'">';
												echo '</td>';
												echo '<td style="border: 1px solid rgb(19,77,91); font-weight:bold;" align="center" width="15%">Rs. ';
												echo '<input name="newfeeamount[]" type="text" class="feeamount" value="'.round($newFeeAmounts[$i],2).'"/> /-</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="25%">';
													$myCalendar = new tc_calendar($currentNumber, true);
													$myCalendar->setIcon("images/iconCalendar.gif");
													$myCalendar->setDate($day, $month, $year);
													$myCalendar->setPath("./");
													$myCalendar->setYearInterval(2010, 2011);
													$myCalendar->writeScript();
												echo '</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="15%">';
												echo '<select class="feecategory" name="newfeecategory[]">'.getFeeCategoryDropdown($currentFeeCategory).'</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="20%">';
												echo '<select class="feetype" name="newfeetype[]">'.feeTypeDropdown($currentFeeType).'</td>';
												echo '</tr>';
												$j++;
											}
											echo '</table><br>';
											echo '<input type="hidden" name="newRows" value="'.$newRows.'"/>';
											echo '<div style="margin-right:50px" align="right"><input type="reset" name="reset" value="Reset" id="z">';
											echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Update" id="z">';
											echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Add New" id="z">';
											echo '</div></form>';
										} else {
											$j = 1;
											for($i = 0; $i < $existingRows; $i++) {
												$dateNumber = 'date'.$j;
												$currentDueDate = $_POST[$dateNumber];
												$currentId = $existingIds[$i];
												$currentFeeType = $feeTypes[$i];
												$currentFeeAmount = $feeAmounts[$i];
												$currentFeeCategory = $feeCategories[$i];
												$updateQuery = "UPDATE fee_structure SET category = '$currentFeeCategory', duration = '$currentFeeType', fee = '$currentFeeAmount', due_date = '$currentDueDate' WHERE id = '$currentId'";
												mysql_query($updateQuery);
												$j++;
											}
											for($i = 0; $i < $newRows; $i++) {
												$currentFeeAmount = $newFeeAmounts[$i];
												$currentFeeName = $newFeeNames[$i];
												$currentFeeType = $newFeeTypes[$i];
												$currentFeeCategory = $newFeeCategories[$i];
												$dateNumber = 'date'.$j;
												$currentDueDate = $_POST[$dateNumber];
												$insertQuery = "INSERT INTO fee_structure (standard, type, fee, due_date, admission_type, category, duration) VALUES ('$selectedStandard', '$currentFeeName', '$currentFeeAmount', '$currentDueDate', 'New Admissions', '$currentFeeCategory', '$currentFeeType'), ('$selectedStandard', '$currentFeeName', '$currentFeeAmount', '$currentDueDate', 'Present Students', '$currentFeeCategory', '$currentFeeType')";
												mysql_query($insertQuery);
												$j++;
											}
											echo '<script language="javascript">';
											echo "window.location.replace('http://edify.atrisesolutions.com/editFeeStructure.php?standard=".$selectedStandard."')";
											echo '</script>';
											
										}
									} else {
										$feeDetailsQuery = "SELECT id, standard, type, fee, due_date, admission_type, category, duration FROM fee_structure WHERE standard = '$selectedStandard' AND admission_type = 'Present Students' ORDER BY category";
										$feeDetailsResults = mysql_query($feeDetailsQuery);

										echo '<form name="feeStructure" method="POST"><table cellpadding=5 cellspacing=0 style="color:rgb(19,77,91); font-size: 14px; float:center; margin-left:10px; width:90%">';
										echo '<tr><td width="0%"></td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); border-right: 1px solid white; color:white;" width="20%"><b>Fee</b></td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; border-right: 1px solid white; color:white;" width="15%"><b>Amount</b></td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white" width="25%"><b>Due Date</b></td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white" width="15%"><b>Category</b></td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); border-left: 1px solid white; color:white;" width="20%"><b>Monthly/Yearly</b></td></tr>';
										$i = 1;

										while ($line = mysql_fetch_assoc($feeDetailsResults)){
											$currentDate = $line['due_date'];
											$currentNumber = 'date'.$i;
											$day = substr($currentDate,8,2);
											$month = substr($currentDate,5,2);
											$year = substr($currentDate,0,4);
											$currentFeeType = $line['duration'];
											$currentFeeCategory = $line['category'];
											echo '<tr><td width="0%">';
											echo '<input type="hidden" name="feenames[]" value="'.$line['type'].'">';
											echo '<input type="hidden" name="oldIds[]" value="'.$line['id'].'">';
											echo '</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);padding-left:10px;" align="left" width="20%">'.$line['type'].'</td>';
											echo '<td style="border: 1px solid rgb(19,77,91); font-weight:bold;" align="center" width="15%">Rs. ';
											echo '<input name="feeamount[]" type="text" class="feeamount" value="'.round($line['fee'],2).'"/> /-</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="25%">';
												$myCalendar = new tc_calendar($currentNumber, true);
												$myCalendar->setIcon("images/iconCalendar.gif");
												$myCalendar->setDate($day, $month, $year);
												$myCalendar->setPath("./");
												$myCalendar->setYearInterval(2010, 2011);
												$myCalendar->writeScript();
											echo '</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="15%">';
											echo '<select class="feecategory" name="feecategory[]">'.getFeeCategoryDropdown($currentFeeCategory).'</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="20%">';
											echo '<select class="feetype" name="feetype[]">'.feeTypeDropdown($currentFeeType).'</td>';
											echo '</tr>';
											$i++;
										}
										mysql_free_result($feeDetailsResults);
										echo '</table><br>';
										echo '<div style="margin-right:50px" align="right"><input type="reset" name="reset" value="Reset" id="z">';
										echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Update" id="z">';
										echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Add New" id="z">';
										echo '</div></form>';
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
