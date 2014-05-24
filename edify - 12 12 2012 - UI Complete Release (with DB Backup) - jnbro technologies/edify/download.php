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
<title>Download Files</title>

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
				<p class="title">Download Files
			
			  
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
      <table>
								<tr>
									<td width="10%">&nbsp;</td>
									<td width="80%">
										<table style="width:450px" class="maintable">					
											<?php
												$dir = "uploads";
												if (is_dir($dir)) {
													if ($dh = opendir($dir)) {
														$i = 1;
														while (false !== ($file = readdir($dh))) {
															$tempFile = "uploads/".$file."/";
															if(is_dir($tempFile) !== true){
																echo "<tr class='mainrow'><td width='10%' align='center' class='cell1'><b>".$i."</b></td><td width='90%' class='cell1'><a href='uploads/".$file."'>".$file."</a></td></tr><tr /><tr />";
																$i++;
															}
														}
														closedir($dh);
													}
												}
											?>
										</table>
									</td>
									<td width="10%">&nbsp;</td>
								</tr>
							</table><br /><br />
							<?php
								if($designation == 'admin') {
								$adminDocsResults = mysql_query("SELECT filename FROM upload_docs");
							?>
							<p style="padding: 3px 15px; margin:0 0 20px 20px; text-align: center; font-weight: bold; background: #544C40 url(images/web-back6.GIF) repeat left top; color: white; font-size: 15px; line-height: 165%; width: 160px;">Admin Docs</p>
							<table>
								<tr>
									<td width="10%">&nbsp;</td>
									<td width="80%">
										<table style="width:450px" class="maintable">					
											<?php
												$dir = $_SERVER['DOCUMENT_ROOT']."/sbv/adminDocs";
												if (is_dir($dir)) {
													if ($dh = opendir($dir)) {
														$i = 1;
														while (false !== ($file = readdir($dh))) {
															$tempFile = "adminDocs/".$file."/";
															if(is_dir($tempFile) !== true){
																echo "<tr class='mainrow'><td width='10%' align='center' class='cell1'><b>".$i."</b></td><td width='90%' class='cell1'><a href='adminDocs/".$file."'>".$file."</a></td></tr><tr /><tr />";
																$i++;
															}
														}
														closedir($dh);
													}
												}
											?>
										</table>
									</td>
									<td width="10%">&nbsp;</td>
								</tr>
							</table>
							<?php
								} else {
									if($designation == 'student') {
										$userProfilResult = mysql_fetch_assoc(mysql_query("SELECT standard FROM user_profile WHERE username = '$username'"));
										$userStandard = $userProfilResult['standard'];
									} else {
										$userStandard = '';
									}
									$tousers = '%'.$username.'%';
									$adminDocsResults = mysql_query("SELECT filename FROM upload_docs WHERE standard = '$userStandard' OR tousers like '$tousers'");
									$noOfDocs = mysql_num_rows($adminDocsResults);
									$i = 0;
									while($line = mysql_fetch_assoc($adminDocsResults)){
										$adminDocsList[$i] = $line['filename'];
										$i++;
									}
									if($noOfDocs > 0) {
									
							?>
							<p style="padding: 3px 15px; margin:0 0 20px 20px; text-align: center; font-weight: bold; background: #544C40 url(images/web-back6.GIF) repeat left top; color: white; font-size: 15px; line-height: 165%; width: 160px;">Admin Docs</p>
							<table>
								<tr>
									<td width="10%">&nbsp;</td>
									<td width="80%">
										<table style="width:450px" class="maintable">					
											<?php
												$dir = $_SERVER['DOCUMENT_ROOT']."/sbv/adminDocs";
												if (is_dir($dir)) {
													if ($dh = opendir($dir)) {
														$i = 1;
														while (false !== ($file = readdir($dh))) {
															$tempFile = "adminDocs/".$file."/";
															if(is_dir($tempFile) !== true && in_array($file,$adminDocsList)){
																echo "<tr class='mainrow'><td width='10%' align='center' class='cell1'><b>".$i."</b></td><td width='90%' class='cell1'><a href='adminDocs/".$file."'>".$file."</a></td></tr><tr /><tr />";
																$i++;
															}
														}
														closedir($dh);
													}
												}
											?>
										</table>
									</td>
									<td width="10%">&nbsp;</td>
								</tr>
							</table>
							<?php
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
