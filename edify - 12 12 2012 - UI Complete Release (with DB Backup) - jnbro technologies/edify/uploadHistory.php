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
	<title>Upload Documents History</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>

<script language="JavaScript">
		
			function checkForm() {
				var standard, users, docName;
				standard = trim(window.document.uploadDocs.standard.value);
				users = trim(window.document.uploadDocs.users.value);
				docName = window.document.uploadDocs.docName.value;
				if (docName.length == 0 || (users.length == 0 && docName.length == 0)) {
					alert('Please fill in the required fields');
					window.document.uploadDocs.flag.value = 'false';
					return false;
				} else {
					window.document.uploadDocs.flag.value = 'true';
					return true;
				}				
			}

			function trim(str) {
				return str.replace(/^\s+|\s+$/g,'');
			}
		</script>
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
				<p class="title">Upload Files
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
<?php
								if($designation == 'admin') {
									echo '<ul>';
									echo '<li><a href="uploadDocuments.php">Upload Documents</a></li>';
									echo '<li class="current_page_item"><a href="uploadHistory.php">Upload History</a></li>';
									echo '</ul><br><br><br>';
									$docUploadRows = mysql_num_rows(mysql_query("SELECT * FROM upload_docs"));
									$noOfRecords = 10;
									$noOfPages = ceil($docUploadRows/$noOfRecords);
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
									$detailsQuery = "SELECT * FROM upload_docs ORDER BY id ASC LIMIT ";
									$detailsQuery .= $startRow.', '.$noOfRecords;
									$results = mysql_query($detailsQuery);
									$noOfRows = mysql_num_rows($results);
									if($noOfRows > 0){
										echo "<div align='right'><a class='pagination' href='uploadHistory.php?pageNo=$previousPage'>Previous Page</a>&nbsp;&nbsp;<a class='pagination' href='uploadHistory.php?pageNo=$nextPage'>Next Page</a></div><br>";
										echo '<table class="maintable"><tr class="headline">';
										echo '<td width="5%"></td>';
										echo '<td class="tab_facultyheader"width="5%">&nbsp;</td>';
										echo '<td class="tab_facultyheader" width="20%"><u><center>File Name</center></u></td>';
										echo '<td class="tab_facultyheader" width="15%"><u><center>Date and Time</center></u></td>';
										echo '<td class="tab_facultyheader" width="40%"><u><center>Created For Users</center></u></td>';
										echo '<td class="tab_facultyheader" width="15%"><u><center>Standard</center></u></td>';
										echo '<td width="5%"></td></tr>';
										for($i = 0;$i < $noOfRows;$i++) {
											$currentRow = mysql_fetch_array($results);
											echo '<tr><td width="5%"></td>';
											echo '<td width="5%" class="tab_faculty"><center>'.$currentRow['id'].'</center></td>';
											echo '<td class="tab_faculty" width="20%"><center>'.$currentRow['docname'].'</center></td>';
											echo '<td class="tab_faculty" width="15%"><center>'.$currentRow['creationdate'].'</center></td>';
											echo '<td class="tab_faculty" width="40%">&nbsp;&nbsp;'.$currentRow['tousers'].'</td>';
											echo '<td class="tab_faculty" width="15%"><center>'.$currentRow['standard'].'</center></td>';
											echo '<td width="5%"></td></tr>';
										}
										echo '</table><br>';
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
