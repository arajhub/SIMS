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
<title>Mailbox-Compose</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
          $username = $_SESSION['username'];
			$password = $_SESSION['password'];
			$designation = $_SESSION['designation'];
			$fullName = $_SESSION['fullName'];
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
				<p class="title">Classmates
			
			  
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
								<li><a href="mailBox.php">Inbox</a></li>
								<li><a href="outBox.php">Outbox</a></li>
								<li class="current_page_item"><a href="compose.php">Compose</a></li>
							</ul><br>
							<?php
								if($_POST){
									$sendToVar = $_POST['sendId'];
									$subject = $_POST['subject'];
									$subject = str_replace("'","\'",$subject);
									
									$message = $_POST['message'];
									$message = str_replace("'","\'",$message);
									$pos = strpos($sendToVar,',');
									$mailDate = date("Y-m-d G:i:s");
									$activityMsg = 'Sent a mail to '.$sendToVar;
									$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$mailDate', '$activityMsg')";
									mysql_query($userActivityQuery);
									
									if($pos) {
										$sendToLength = strlen($sendToVar);
										$sendTo = substr($sendToVar,0,$pos);
										$i = 0;
										$validUsername = mysql_query("SELECT * FROM user_profile WHERE username='$sendTo'");
										$validCount = mysql_num_rows($validUsername);
										if($validCount == 0){
											$nonValidUsername[$i] = $sendTo;
											$i++;
										} else {
											$fromId = $username;
											$sendToArray = array (0 => "$sendTo");
											$validUsernameDetails = mysql_fetch_assoc($validUsername);
											$sendToFullName = $validUsernameDetails['first'];
											if(strlen($validUsernameDetails['middle']) > 1) {
												$sendToFullName .= ' '.$validUsernameDetails['middle'];
											}
											$sendToFullName .= ' '.$validUsernameDetails['last'];
											$mailBoxInsertQuery = "INSERT INTO mail_box (username,to_id,subject,mail_date,message,from_name,to_name,sendToList) VALUES ('$username','$sendTo','$subject','$mailDate','$message','$fullName','$sendToFullName','$sendToVar')";
											
											mysql_query($mailBoxInsertQuery) or die ("Could not insert the given values");
										}
										$newSendToVar = substr($sendToVar,$pos+1,$sendToLength);
										$newLength = strlen($newSendToVar);
										$flag = 1;
										while($flag){
											$j = $newSendToVar;
											$pos = strpos($j,',');
											if($pos){
												$k = substr($j,0,$pos);
												$validUsername = mysql_query("SELECT * FROM user_profile WHERE username='$k'");
												$validCount = mysql_num_rows($validUsername);
												if($validCount == 0){
													$nonValidUsername[$i] = $k;
													$i++;
												} else {
													$fromId = $username;
													array_push($sendToArray,"$k");
													$validUsernameDetails = mysql_fetch_assoc($validUsername);
													$sendToFullName = $validUsernameDetails['first'];
													if(strlen($validUsernameDetails['middle']) > 1) {
														$sendToFullName .= ' '.$validUsernameDetails['middle'];
													}
													$sendToFullName .= ' '.$validUsernameDetails['last'];
													echo $sendToFullName;
													$mailBoxInsertQuery = "INSERT INTO mail_box (username,to_id,subject,mail_date,message,from_name,to_name,sendToList) VALUES ('$username','$k','$subject','$mailDate','$message','$fullName','$sendToFullName','$sendToVar')";
													mysql_query($mailBoxInsertQuery) or die ("Could not insert the given values");
												}
												$newSendToVar = substr($newSendToVar,$pos+1,$newLength);
												$newLength = strlen($newSendToVar);
											} else {
												$k = substr($j,0,$newLength);
												$validUsername = mysql_num_rows(mysql_query("SELECT * FROM user_profile WHERE username='$k'"));
												if($validUsername == 0){
													$nonValidUsername[$i] = $k;
													$i++;
												} else {
													$fromId = $username;
													array_push($sendToArray,"$k");
													$validUsernameDetails = mysql_fetch_assoc($validUsername);
													$sendToFullName = $validUsernameDetails['first'];
													if(strlen($validUsernameDetails['middle']) > 1) {
														$sendToFullName .= ' '.$validUsernameDetails['middle'];
													}
													$sendToFullName .= ' '.$validUsernameDetails['last'];
													$mailBoxInsertQuery = "INSERT INTO mail_box (username,to_id,subject,mail_date,message,from_name,to_name,sendToList) VALUES ('$username','$k','$subject','$mailDate','$message','$fullName','$sendToFullName','$sendToVar')";
													mysql_query($mailBoxInsertQuery) or die ("Could not insert the given values");
												}
												$flag=0;
											}
										}
									} else {
										$sendToSingle = $sendToVar;
										$i = 0;
										$validUsername = mysql_query("SELECT * FROM users WHERE username='$sendToSingle'");
										$validCount = mysql_num_rows($validUsername);
										$validUsernameDetails = mysql_fetch_assoc($validUsername);
										$sendToFullName = $validUsernameDetails['full_name'];
										if($validCount == 0){
											$nonValidUsername[$i] = $sendToSingle;
											$i++;
										} else {
											$fromId = $username;											
											$mailBoxInsertQuery = "INSERT INTO mail_box (username,to_id,subject,mail_date,message,from_name,to_name,sendToList) VALUES ('$username','$sendToSingle','$subject','$mailDate','$message','$fullName','$sendToFullName','$sendToVar')";
											mysql_query($mailBoxInsertQuery) or die ("Could not insert the given values");
										}
									}
									$arrayLength = count($sendToArray);
									echo '<table class="readMails">';
									if($arrayLength >= 1){
										echo '<tr>';
										echo '<td><b>Your message has been sent successfully to the following users:</b></td>';
										echo '</tr>';
										echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										for($i = 0; $i < $arrayLength; $i++){
											echo $sendToArray[$i].', ';
										}
										echo '</td></tr>';
									}
									$arrayLength = count($nonValidUsername);
									if($arrayLength >= 1){
										echo '<table>';
										echo '<tr class="readMails">';
										echo '<td><b>Following user Ids are incorrect and the message has not been sent to these users:</b></td>';
										echo '</tr>';
										echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										for($i = 0; $i < $arrayLength; $i++){
											echo $nonValidUsername[$i].', ';
										}
										echo '</td></tr>';
									}
									echo '<tr class="readMails"><td>Go back to <a href="mailBox.php">Inbox</a></td></tr></table>';
								} else {
							?>
							<form method="post" action="compose.php">
								<table>
									<tr class="readMails">
										<td width="5%">&nbsp;</td>
										<td width="15%"><b>Send To:</b></td>
										<td width="80%"><input type="text" name="sendId" value="" size="62"></td>
									</tr>
									<tr class="readMails">
										<td width="5%">&nbsp;</td>
										<td width="15%"><b>Subject:</b></td>
										<td width="80%"><input type="text" name="subject" value="" size="62"></td>
									</tr>
									<tr class="readMails">
										<td width="5%">&nbsp;</td>
										<td width="15%"><b>Message:</b></td>
										<td width="80%"><textarea cols="60" rows="10" name="message"></textarea></td>
									</tr><tr /><tr /><tr />
								</table><br>
								<input type="submit" value="Send" id="z" name="send">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="reset" value="Reset" id="z" name="reset">
							</form>
							<?php
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
