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
	<title>Upload Documents</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>
<script language="JavaScript">		
			function checkForm() {
				var standard, users, docName;
				standard = trim(window.document.uploadDocs.standard.value);
				users = trim(window.document.uploadDocs.users.value);
				docName = window.document.uploadDocs.docName.value;
				if (docName.length == 0 || (users.length == 0 && standard.length == 0) || (users.length == 0 && standard == 'select')) {
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
									echo '<li class="current_page_item"><a href="uploadDocuments.php">Upload Documents</a></li>';
									echo '<li><a href="uploadHistory.php">Upload History</a></li>';
									echo '</ul><br><br>';
									if($_POST['flag']){
										$docName = $_POST['docName'];
										$standard = $_POST['standard'];
										if($standard == 'select'){
											$standard = '';
										}
										$tousers = $_POST['users'];
										$creationdate = date("Y-m-d GW:i:s");
										while(list($key,$value) = each($_FILES['uploadedfile']['name'])) {
											if(!empty($value)) {
												$filename = $value;
												$filename = str_replace("'","\'",$filename);
												$filename = str_replace('"','\"',$filename);
												$activityMsg = 'Uploaded a Admin Doc. with the name '.$filename;
												$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$creationdate', '$activityMsg')";
												$insertQuery = "INSERT INTO upload_docs (docName, tousers, creationdate, createdBy, standard, filename) VALUES ('$docName', '$tousers', '$creationdate', '$username', '$standard', '$filename')";
												$target_path = "adminDocs/";
												$target_path = $target_path.basename($_FILES['uploadedfile']['name'][$key]);
												echo '<table >';
												if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'][$key],$target_path)){
													echo '<tr><td width="100%">';
													echo 'The file with Filename "<b>'.basename($_FILES['uploadedfile']['name'][$key]).'"</b> has been uploaded';
													mysql_query($insertQuery) or die ('Cannot insert into database');
													mysql_query($userActivityQuery);
													echo '</td></tr>';
												} else {
													echo '<tr><td width="100%">';
													echo 'The file with Filename "<b>'.basename($_FILES['uploadedfile']['name'][$key]).'"</b> is not uploaded';
													echo '</td></tr>';
												}
												echo '</table><br>';
											}
										}
									}
							?>
							<form name="uploadDocs" enctype="multipart/form-data" method="post">
								<p style="color:#BB0000; margin-left:20px; margin-right:20px; font-weight: bold; font-size: 14px; background: #544C40 url(images/web-back13.GIF) repeat left top; padding: 4px; float:center; line-height:2em">
									*** GuideLines !!!
									<br>&nbsp;&nbsp;&nbsp;&nbsp;1. All fields marked with * are mandatory fields
									<br>&nbsp;&nbsp;&nbsp;&nbsp;2. Give a user friendly name to the document that is being uploaded to the Server.
									<br>&nbsp;&nbsp;&nbsp;&nbsp;3. Fill in user ids or standard to whom the document is related to. One of them should be specified.
								</p><br>
								<input type="hidden" name="MAX_FILE_SIZE" value="10485760000" />
								<table ><tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Document Name *:</b></td>
										<td width="23%"><input type="text" name="docName" value="<?php echo $_POST['docName']; ?>"></td>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Standard *:</b></td>
										<td width="23%">
											<select name="standard">
												<?php
													$selectedStandard = $_POST['standard'];
													echo standardDropdown($selectedStandard);
												?>
											</select>
										</td>
										<td width="5%">&nbsp;</td>
									</tr><tr /><tr /><tr /><tr />
									<tr>
										<td width="5%">&nbsp;</td>
										<td width="17%"><b>Users *:</b></td>
										<td colspan=3 width="50%"><input type="text" size=60 name="users" value="<?php echo $_POST['users']; ?>"></td>
										<td colspan=2 width="28%">&nbsp;</td>
									</tr><tr /><tr /><tr /><tr />
									<tr>
										<td width="100%" colspan=7><b>&nbsp;&nbsp;Choose a file to upload (max 10MB) :</b></td>
									</tr>
									<tr>
										<td colspan=2 width="22%">&nbsp;</td><td colspan=5 width="78%"><input size=50 type="file" name="uploadedfile[]"></td>
									</tr>
								</table><br>
								<input type="hidden" name="flag">
								<input onClick="return checkForm();" type="submit" value="Upload File" id="z">
							</form>
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
