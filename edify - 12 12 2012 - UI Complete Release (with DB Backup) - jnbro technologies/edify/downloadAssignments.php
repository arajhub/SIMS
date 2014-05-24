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
<title>Upload Home Assignment</title>

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
				<p class="title">Home Assignment
			
			  
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
      <ul>
								<?php
									if($designation == 'admin' || $designation == 'teacher' || $designation == 'principal') {
										echo '<li><a href="uploadAssignments.php">Upload New Assignment</a></li>';
										echo '<li class="current_page_item"><a href="downloadAssignments.php">Download Assignment</a></li>';
										echo '<li><a href="correctAssignments.php">Assignment Marks</a></li>';
									} elseif ($designation == 'student' || $designation == 'parent') {
										echo '<li class="current_page_item"><a href="downloadAssignments.php">Download Assignment</a></li>';
										echo '<li><a href="correctAssignments.php">Assignment Marks</a></li>';
									}
								?>
							</ul><br><br><br><br>
							<table width="100%">
								<tr>
									<td width="10%">&nbsp;</td>
									<td align="center" width="80%">
										<table class="maintable">					
											<?php
												if($designation == 'student'){
													$classQuery = "SELECT * FROM users WHERE username = '$username'";
													$classResult = mysql_fetch_assoc(mysql_query($classQuery));
													$studentClass = $classResult['standard'];
													$studentSection = $classResult['section'];
													$dir = $_SERVER['DOCUMENT_ROOT']."/eduSector/uploads/Assignment/Class".$studentClass;
													$fileDirectory = "uploads/Assignment/Class".$studentClass."/";
													if (is_dir($dir)) {
														if ($dh = opendir($dir)) {
															$i = 1;
															while (($file = readdir($dh)) !== false) {
																$tempFile = $fileDirectory.$file."/";
																if(is_dir($tempFile) !== true){
																	$validateFileQuery = "SELECT * FROM ha_uploaded WHERE fileName = '$file' AND standard = '$studentClass' AND (section = '' OR section='$studentSection')";
																	$validateRows = mysql_num_rows(mysql_query($validateFileQuery));
																	if($validateRows != 0){
																		echo "<tr class='mainrow'><td width='10%' align='center' class='cell1'><b>".$i."</b></td><td width='90%' class='cell1'><a href='".$fileDirectory.$file."'>".$file."</a></td></tr><tr /><tr />";
																		$i++;
																	}
																}
															}
															closedir($dh);
														}
													}
												} elseif ($designation == 'parent') {
													$childrenQuery = "SELECT DISTINCT standard, section FROM users WHERE parent='$username' ORDER BY standard ASC";
													$childrenResult = mysql_query($childrenQuery);
													while ($line = mysql_fetch_assoc($childrenResult)){
														$currentClass = $line['standard'];
														$currentSection = $line['section'];
														echo '<tr class="mainrow2">';
														echo '<td width="10%" align="center" class="cell1"><b>&nbsp;</b></td>';
														echo '<td align="center" class="cell1" width="90%" style="color:white;">Files Uploaded for Class '.$currentClass.'</td></tr>';
														$dir = $_SERVER['DOCUMENT_ROOT']."/eduSector/uploads/Assignment/Class".$currentClass;
														$fileDirectory = "uploads/Assignment/Class".$currentClass."/";
														if (is_dir($dir)) {
															if ($dh = opendir($dir)) {
																$i = 1;
																while (($file = readdir($dh)) !== false) {
																	$tempFile = $fileDirectory.$file."/";
																	if(is_dir($tempFile) !== true){
																		$validateFileQuery = "SELECT * FROM ha_uploaded WHERE fileName = '$file' AND standard = '$currentClass' AND (section = '' OR section='$currentSection')";																		
																		$validateRows = mysql_num_rows(mysql_query($validateFileQuery));
																		if($validateRows != 0){
																			echo "<tr class='mainrow'>";
																			echo "<td width='10%' align='center' class='cell1'><b>".$i."</b></td>";
																			echo "<td width='90%' class='cell1'>";
																			echo "<a href='".$fileDirectory.$file."'>".$file."</a></td>";
																			echo "</tr><tr /><tr />";
																			$i++;
																		}
																	}
																}
																if ($i == 1){
																	echo "<tr class='mainrow'>";
																	echo "<td width='10%' align='center' class='cell1'><b>&nbsp;</b></td>";
																	echo "<td width='90%' align='center' class='cell1'>";
																	echo "s<b>No files are uploaded !!!</td></tr><tr /><tr />";
																}
																echo '<tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />';
																closedir($dh);
															}
														}
														echo "<tr class='mainrow'>";
														echo "<td width='10%' align='center' class='cell1'><b>&nbsp;</b></td>";
														echo "<td width='90%' align='center' class='cell1'><b>No files are uploaded !!!</td>";
														echo "</tr><tr /><tr />";
													}
												} elseif ($designation == 'teacher') {
													$selectedStandard = $_GET['standard'];
													echo '<tr><td width="10%">&nbsp;</td><td width="90%" style="float:left; align:left;">';
													echo getDynamicStandardDropdown($selectedStandard);
													echo '</td></tr>';
													
													if($selectedStandard != null) {
														echo '<tr class="mainrow2">';
														echo '<td width="10%" align="center" class="cell1"><b>&nbsp;</b></td>';
														echo '<td align="center" class="cell1" width="90%" style="color:white;">';
														echo 'Files Uploaded for Class '.$selectedStandard.'</td></tr>';
														$dir = $_SERVER['DOCUMENT_ROOT']."/eduSector/uploads/Assignment/Class".$selectedStandard;
														$fileDirectory = "uploads/Assignment/Class".$selectedStandard."/";
														if (is_dir($dir)) {
															if ($dh = opendir($dir)) {
																$i = 1;
																while (($file = readdir($dh)) !== false) {
																	$tempFile = $fileDirectory.$file."/";
																	if(is_dir($tempFile) != true){
																		$validateFileQuery = "SELECT * FROM ha_uploaded WHERE fileName = '$file' AND standard = '$selectedStandard'";																		
																		$validateRows = mysql_num_rows(mysql_query($validateFileQuery));
																		if($validateRows != 0){
																			echo "<tr class='mainrow'>";
																			echo "<td width='10%' align='center' class='cell1'><b>".$i."</b></td>";
																			echo "<td width='90%' class='cell1'>";
																			echo "<a href='".$fileDirectory.$file."'>".$file."</a></td></tr><tr /><tr />";
																			$i++;
																		}
																	}
																}
																if ($i == 1){
																	echo "<tr class='mainrow'>";
																	echo "<td width='10%' align='center' class='cell1'><b>&nbsp;</b></td>";
																	echo "<td width='90%' align='center' class='cell1'>";
																	echo "<b>No files are uploaded !!!</td></tr><tr /><tr />";
																}
																echo '<tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />';
																closedir($dh);
															}
														}
														echo "<tr class='mainrow'>";
														echo "<td width='10%' align='center' class='cell1'><b>&nbsp;</b></td>";
														echo "<td width='90%' align='center' class='cell1'><b>No files are uploaded !!!</td>";
														echo "</tr><tr /><tr />";
													}
												}
											?>
										</table>
									</td>
									<td width="10%">&nbsp;</td>
								</tr>
							</table>
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
