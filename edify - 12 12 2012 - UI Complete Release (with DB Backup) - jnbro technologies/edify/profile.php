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
<title>Profile</title>



       

</head>

<body>


 <?php
            
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
		    $designationo=$_SESSION['designation'];
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
			
			
		    $username = $_SESSION['username'];
		    if($_POST){
				$username=$_POST['id'];
				$userDetailsQuery = "SELECT * FROM user_profile WHERE username='$username'";
		    }
			else {
				
				$userDetailsQuery = "SELECT * FROM user_profile WHERE username='$username'";
		    }
			if($_GET){
				$username=$_GET['id'];
				$userDetailsQuery = "SELECT * FROM user_profile WHERE username='$username'";
		    }
			$contactDetailsQuery = "SELECT * FROM contactdetails WHERE username='$username'";
			$imageFileExten = '.jpg';
			$imageFileName = $username.$imageFileExten;
			$userDetailsResult = mysql_fetch_assoc(mysql_query($userDetailsQuery));
			$contactDetailsResult = mysql_fetch_assoc(mysql_query($contactDetailsQuery));
			
			
				$designation = $userDetailsResult['designation'];
				date_default_timezone_set('Asia/Calcutta');
		
			
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

<div id="digiclock"></div>
<div id="middle" align="center">
<div class="pagegreen">
<div id="pageheader" class="headergreen">
				<p class="title"><?php
									echo $userDetailsResult['first'].' '.$userDetailsResult['middle'].' '.$userDetailsResult['last'].'\'s';
								?>
								Profile
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designationo);
?>
  

				<div>
					<div class="pagecontent">
				
						<?php 
						echo '<div id="profile" style="float:right;"   align="center">';
$filename='profilePhotos/'.$imageFileName;
if (file_exists($filename)) {
    echo '<img id="ProfilePicture" src=profilePhotos/'.$imageFileName.'  width="150" height="190" alt="ProfilePicture" align="center" />';
} else {
    echo '<img id="ProfilePicture" src=profilePhotos/profilepicture.png  width="150" height="190" alt="ProfilePicture" align="center" />';
}

	echo '</div>';
							if($designation=='student') {
						?>
						<table width="60%" style="float:left;" style="float:left;"  class="maintable">
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Full Name :</b></h1></td>
								<td width="50%">
									<h1 class="detail">
										<?php
											echo $userDetailsResult['first'].' '.$userDetailsResult['middle'].' '.$userDetailsResult['last'];
										?>
									</h1>
								</td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Father's Name :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['father_name']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Mother's Name :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['mother_name']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Date of Birth :</b></h1></td>
								<td width="50%">
									<h1 class="detail">
										<?php
											$dob  = $userDetailsResult['dob'];
											$dobYear = substr($dob, 0, 4);
											$dobMonth = substr($dob, 4, 2);
											$dobDate = substr($dob, 6, 2);
											date("t",mktime(0,0,0,$calendar['current_month'],$calendar['current_day'],$calendar['current_year']));
											echo date('dS \of F Y',mktime(0,0,0,$dobMonth,$dobDate,$dobYear));
										?>
									</h1>
								</td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Standard :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['standard']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Section :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['section']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Email ID :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['email_id']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<?php
								if($userDetailsResult['address2'] != null) {
							?>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>&nbsp;</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['address2']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<?php
								}
								if($userDetailsResult['address3'] != null) {
							?>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>&nbsp;</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['address3']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<?php
								}
								if($userDetailsResult['address4'] != null) {
							?>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>&nbsp;</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['address4']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<?php
								}
							?>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>City :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['city']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>State :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['state']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Pincode :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['pincode']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Contact No. :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['contact']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
						</table>
						<?php
							} else {
						?>
						<table width="60%" style="float:left;">
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Full Name :</b></h1></td>
								<td width="50%"><h1 class="detail">
									<?php
										echo $userDetailsResult['first'].' '.$userDetailsResult['middle'].' '.$userDetailsResult['last'];
									?>
								</h1></td>
								<td width="10%">&nbsp;</td>
							</tr>							
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Designation :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['designation']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>							
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Date of Birth :</b></h1></td>
								<td width="50%">
									<h1 class="detail">
										<?php
											$dob  = $userDetailsResult['dob'];
											$dobYear = substr($dob, 0, 4);
											$dobMonth = substr($dob, 4, 2);
											$dobDate = substr($dob, 6, 2);
											date("t",mktime(0,0,0,$calendar['current_month'],$calendar['current_day'],$calendar['current_year']));
											echo date('dS \of F Y',mktime(0,0,0,$dobMonth,$dobDate,$dobYear));
										?>
									</h1>
								</td>
								<td width="10%">&nbsp;</td>
							</tr>							 
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Email ID :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['email_id']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Address :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['address1']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<?php
								if($userDetailsResult['address2'] != null) {
							?>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>&nbsp;</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['address2']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<?php
								}
								if($userDetailsResult['address3'] != null) {
							?>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>&nbsp;</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['address3']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<?php
								}
								if($userDetailsResult['address4'] != null) {
							?>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>&nbsp;</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['address4']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<?php
								}
							?>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>City :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['city']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>State :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['state']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Pincode :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['pincode']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="30%"><h1 class="detail"><b>Contact Nos. :</b></h1></td>
								<td width="50%"><h1 class="detail"><?php echo $userDetailsResult['contact']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
						</table><br><br>
						<?php
							}
							if ($designation == 'teacher' || $designation == 'principal' || $designation == 'librarian' || $designation == 'admin' ){
								$currentUser = $userDetailsResult['username'];
								$qualificationsQuery = "SELECT * FROM qualifications WHERE username='$currentUser'";
								$qualificationDetails = mysql_fetch_assoc(mysql_query($qualificationsQuery));
						?>
						
							
					
						<table width="60%">
                        <tr><td width="100%" colspan="4" align="center"> <p class="h2"> Qualifications</p></td></tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="40%"><h1 class="detail"><b>Degree :</b></h1></td>
								<td width="40%"><h1 class="detail"><?php echo $qualificationDetails['degree'].' '.$userDetailsResult['middle'].' '.$userDetailsResult['last']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>							
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="40%"><h1 class="detail"><b>Grade :</b></h1></td>
								<td width="40%"><h1 class="detail"><?php echo $qualificationDetails['grade']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>							
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="40%"><h1 class="detail"><b>Designation :</b></h1></td>
								<td width="40%"><h1 class="detail"><?php echo $qualificationDetails['desgn']; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>							 
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="40%"><h1 class="detail"><b>Age :</b></h1></td>
								<td width="40%"><h1 class="detail"><?php echo $qualificationDetails['age'].' yrs'; ?></h1></td>
								<td width="10%">&nbsp;</td>
							</tr>
							<tr>
								<td width="10%">&nbsp;</td>
								<td width="40%"><h1 class="detail"><b>Date of Joining :</b></h1></td>
								<td width="40%">
									<h1 class="detail">
										<?php
											$doj  = $qualificationDetails['doj'];
											$dojYear = substr($doj, 0, 4);
											$dojMonth = substr($doj, 4, 2);
											$dojDate = substr($doj, 6, 2);
											echo date('dS \of F Y',mktime(0,0,0,$dojMonth,$dojDate,$dojYear));
										?>
									</h1>
								</td>
								<td width="10%">&nbsp;</td>
							</tr>
						</table>
						<?php
							}
						?>
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
