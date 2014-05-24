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
<?php
								if($designation == 'admin' || $designation == 'teacher' || $designation == 'principal') {
							?>
							<ul>
								<li class="current_page_item"><a href="uploadAssignments.php">Upload New Assignment</a></li>
								<li><a href="downloadAssignments.php">Download Assignment</a></li>
								<li><a href="correctAssignments.php">Assignment Marks</a></li>
							</ul><br>
							<?php
								if($_POST['subValue'] == 'Upload File') {
									$maxFileSize = $_POST['MAX_FILE_SIZE'];
									$classArray = $_POST['class'];
									$sectionArray = $_POST['section'];
									$m = 0;
									$originaldatetime = date("Y-m-d H:i:s");
									$time = 19800;
									$creationDate= strtotime($originaldatetime) + $time;
									$uploadedOn = date("Y-m-d",$creationDate);
									while(list($key,$value) = each($_FILES['uploadedfile']['name'])) {
										if(!empty($value)) {
											$filename = $value;
											if(substr($filename,0,10) == 'Assignment'){
												$currentClass = $classArray[$m];
												$currentSection = strtoupper($sectionArray[$m]);
												$filename = stringReplacement($filename);
												$firstOccurence = strpos($filename,"_");
												$stringLength = strlen($filename);
												$l =  $firstOccurence - $stringLength + 1;
												$tempVar = substr($filename,$l);
												$firstDotOccurence = strpos($tempVar,".");
												$currentSubject = substr($tempVar, 0, $firstDotOccurence);
												$insertQuery = "INSERT INTO ha_uploaded (fileName, subject, standard, section, uploaded_by, uploaded_on) VALUES ('$filename', '$currentSubject', '$currentClass', '$currentSection', '$username','$uploadedOn')";
												if(mysql_query($insertQuery)){
													$target_path = "uploads/Assignment/Class".$currentClass."/";
													$assignment_folder_path = "uploads/Assignment";
													if(!is_dir($assignment_folder_path)){
														mkdir($assignment_folder_path);
													}
													if(!is_dir($target_path)){
														mkdir($target_path);
													}
													$target_path = $target_path.basename($_FILES['uploadedfile']['name'][$key]);
													echo '<table >';
													if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'][$key],$target_path)){
														echo '<tr><td width="100%">';
														echo 'The file with Filename "<b>'.basename($_FILES['uploadedfile']['name'][$key]).'"</b> has been uploaded';
														echo '</td></tr>';
													} else {
														echo '<tr><td width="100%">';
														echo 'The file with Filename "<b>'.basename($_FILES['uploadedfile']['name'][$key]).'"</b> is not uploaded';
														echo '</td></tr>';
													}
													echo '</table><br>';
												} else {
													echo '<table >';
													echo '<tr><td width="100%">';
													echo 'The file with Filename "<b>'.basename($_FILES['uploadedfile']['name'][$key]).'"</b> already exists';
													echo '</td></tr>';
													echo '</table><br>';
												}
											} else {
												echo '<table >';
												echo '<tr><td width="100%">';
												echo 'The file with Filename "<b>'.basename($_FILES['uploadedfile']['name'][$key]).'"</b> is not uploaded because it '."doesn't start with".'"Assignment"';
												echo '</td></tr>';
												echo '</table><br>';
											}
										}
										$m++;
									}
								}
							?>
							<form enctype="multipart/form-data" method="post" action="uploadAssignments.php">
								<input type="hidden" name="MAX_FILE_SIZE" value="10485760000" />
								<p style="color:rgb(19,77,91); margin-left:20px; margin-right:20px; font-weight: bold; font-size: 14px; background: rgb(216,216,216); padding: 20px; float:center; line-height:2em">
									*** Upload the file from your system. Following points are mandatory !!!
									<br>&nbsp;&nbsp;&nbsp;&nbsp;1. File name should start with "Assignment" and then followed by Assignment no.
									<br>&nbsp;&nbsp;&nbsp;&nbsp;2. It should then followed by "_" and subject.
									<br>&nbsp;&nbsp;&nbsp;&nbsp;3. User has to enter standard/class besides every file that is being uploaded to the Server.
									<br>&nbsp;&nbsp;&nbsp;&nbsp;4. User has to enter section if the file is meant for only one section.
									<br>For ex :- <i>Assignment1_English.</i>
								</p><br>
								<table style="background:rgb(216,216,216); margin-left:20px; width:80%; color:rgb(19,77,91); padding:5px;">
									<tr>
										<td width="80%" colspan=2><b>Choose a file to upload (max 10MB) :</b></td>
										<td align="center" width="5%"><b>Class</b></td>
										<td align="center" width="5%"><b>Section</b></td>
										<td width="10%">&nbsp;</td>
									</tr>
									<?php
										if($_GET) {
											$j = $_GET['no'];
											for($i = 0; $i <= $j; $i++){
												echo '<tr><td width="20%">&nbsp;</td>';
												echo '<td width="60%"><input size=50 type="file" name="uploadedfile[]"></td>';
												echo '<td width="5%"><input size=5 type="text" name="class[]" value=""/></td>';
												echo '<td width="5%"><input size=5 type="text" name="section[]" value=""/></td>';
												echo '<td width="10%">&nbsp;</td></tr>';
											}
											$j++;
											echo "<tr><td width='20%'>&nbsp;</td>";
											echo "<td class='td2_mailbox' width='60%'><a href='uploadAssignments.php?no=$j'>Attach another file >>> </a></td>";
											echo '<td width="20%" colspan=3>&nbsp;</td></tr>';
										} else {
											echo '<tr><td width="20%">&nbsp;</td>';
											echo '<td width="60%"><input size=50 type="file" name="uploadedfile[]"></td>';
											echo '<td width="5%"><input size=5 type="text" name="class[]" value=""/></td>';
											echo '<td width="5%"><input size=5 type="text" name="section[]" value=""/></td>';
											echo '<td width="10%">&nbsp;</td></tr>';
											
											echo "<tr><td width='20%'>&nbsp;</td>";
											echo "<td class='td2_mailbox' width='60%'><a href='uploadAssignments.php?no=1'>Attach another file >>> </a></td>";
											echo '<td width="20%" colspan=3>&nbsp;</td></tr>';
										}
									?>
								</table><br>
								<input type="submit" name="subValue" value="Upload File" id="z">
							</form>
							<?php
								} else {
							?>
							<ul>
								<li><a href="downloadAssignments.php">Download Assignment</a></li>
								<li><a href="correctAssignments.php">Assignment Marks</a></li>
							</ul><br>
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
