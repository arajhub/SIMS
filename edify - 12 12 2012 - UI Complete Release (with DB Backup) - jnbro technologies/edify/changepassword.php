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
<title>Change Password</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
          	
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
		    $designation=$_SESSION['designation'];
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
<div class="pagegrey">
<div id="pageheader" class="headergrey">
				<p class="title">
								Change Password
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
  

				<div>
					<div class="pagecontent">
				<?php
								if($_POST){
									$old_password= $_POST['old'];
									$new_password = $_POST['new'];
									$renew_password = $_POST['renew'];
									$change= $_POST['change'];
									$username =$_SESSION['username'];
									$userPwd=$_SESSION['password'];
									if($old_password AND $new_password AND $renew_password) {
									if($userPwd === $old_password) {
											if($new_password === $renew_password) {
												$updateQuery="UPDATE users SET password='$new_password' WHERE username='$username'";
												$result=mysql_query($updateQuery);
												$successMsg="<p class='font1'>Congratulation! your password has been changed successfully !</p>";
												echo $successMsg;
											} else {
												$renewMsg = "New password and Retyped New password should be same.\n";
												echo $renewMsg;
											}
										} else {
											$oldMsg= "<div id='content'><div class='post1'><div class='entry'><table style='width:500px; align:center' ><tr><td width='5%'>&nbsp;</td><td colspan='95%'><b>Invalid current password. !!!</b></td></tr></table></div></div></div>";
											echo $oldMsg;
										}
									} else {
										$requiredMsg= "<div id='content'><div class='post1'><div class='entry'><table style='width:500px; align:center' ><tr><td width='5%'>&nbsp;</td><td colspan='95%'><b>Do not leave the required field empty.</b></td></tr></table></div></div></div>";
									echo $requiredMsg;
									}
									mysql_close($connect);
								}
							?>
							<div class="detailBox">
								<form method="post" action="changepassword.php" style="margin-left:60px">
									<table cellpadding=2 style="width:500px; align:center;" >
										<tr>
											<td width="5%"> </td>
											<td width="45%"><b>* Current Password</b></td>
											<td width="50%"><input type="password" name="old" value="" size="30"></td>
										</tr>
										<tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />
										<tr>
											<td width="5%"> </td>
											<td width="45%"><b>* New Password</b></td>
											<td width="50%"><input type="password" name="new" value="" size="30"></td>
										</tr>
										<tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />
										<tr>
											<td width="5%"> </td>
											<td width="45%"><b>* Retype New Password</b></td>
											<td width="50%"><input type="password" name="renew" value="" size="30"></td>
										</tr>
										<tr /><tr /><tr /><tr /><tr /><tr /><tr /><tr />
										<tr>
											<td width="5%"></td>
											<td colspan=2><b>(*) denotes require field must be entered.</b></td>
										</tr>
									</table><br>&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="submit" value="Change" id="z" name="change">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="reset" value="Reset" id="z">&nbsp;&nbsp;&nbsp;
								</form>
							</div>
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
