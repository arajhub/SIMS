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
<title>Announcements</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
           	$username = $_SESSION['username'];
			$password = $_SESSION['password'];

			$designation = $_SESSION['designation'];
$subject=$_POST['subject'];
			$message=$_POST['message'];
			
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


<div id="middle" align="center">
<div class="pagegrey">
<div id="pageheader" class="headergrey">
				<p class="title">Announcements
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
          <ul>
								<?php
									if($designation != 'student' && $designation != 'parent') {
										if($_GET['action']=='post') {
											echo '<li class="current_page_item"><a href="announcements.php?action=post">Post</a></li>';
										} else {
											echo '<li><a href="announcements.php?action=post">Post</a></li>';
										}
									}
								?>
							</ul><br>
                            
                            <?php
								if($_GET['action']=='post') {
							?>
							<form method="post" action="announcements.php">
								<table >
									<tr>
										<td ><b>Subject:</b></td>
										<td><input type="text" name="subject" value="" size="62"></td>
									</tr>
									<tr>
										<td><b>Message:</b></td>
										<td><textarea cols="60" rows="10" name="message"></textarea></td>
									</tr>
								</table><br>
								<input type="submit" value="Post" id="z" name="send">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="reset" value="Reset" id="z" name="reset">
							</form>
							<?php
								}
							?>
                            
							<?php

								if($_POST) {
									$subject = $_POST['subject'];
									$message = $_POST['message'];
									if(strlen($subject) != 0 && strlen($message) != 0) {										
										if($designation == 'admin' || $designation == 'principal') {
											$bgcolor = "rgb(216,216,216)";
											$query = mysql_query("select full_name from users where username='$username'");
											$fromName=mysql_fetch_assoc($query);
											$fullName=$fromName['full_name'];
											$originaldatetime = date("Y-m-d H:i:s");
											$time = 19800;
											$creationDate= strtotime($originaldatetime) + $time;
											$postDate = date("Y-m-d G:i:s",$creationDate);
											$insertQuery="insert into announcements VALUES ('$username','$fullName','$postDate','$subject','$message','$bgcolor')";
											$insertQueryResult=mysql_query($insertQuery) or die ('<p class="td5">Cannot post your announcements. !!</p>');
											$activityMsg = 'Posted an annoucement with subject as '.$subject;
											$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$postDate', '$activityMsg')";
											mysql_query($userActivityQuery);
											echo '<p class="td5">Your announcement has been posted successfully !!</p>';
										} elseif($designation == 'teacher' || $designation == 'librarian') {
											$bgcolor = "white";
											$query = mysql_query("select full_name from users where username='$username'");
											$fromName = mysql_fetch_assoc($query);
											$fullName = $fromName['full_name'];
											$originaldatetime = date("Y-m-d H:i:s");
											$time = 19800;
											$creationDate = strtotime($originaldatetime) + $time;
											$postDate = date("Y-m-d G:i:s",$creationDate);
											$insertQuery = "INSERT INTO announcements VALUES ('$username','$fullName','$postDate','$subject','$message','$bgcolor')";
											$insertQueryResult = mysql_query($insertQuery) or die ('<p class="td5">Cannot post your announcements. !!</p>');

											$activityMsg = 'Posted an annoucement with subject as '.$subject;
											$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$postDate', '$activityMsg')";
											mysql_query($userActivityQuery);
											echo '<p class="td5">Your announcement has been posted successfully !!</p>';
										}
									} else {
										echo "Required field should not leave empty!";
									}
								}
								$query = mysql_query("select * from announcements");
								$rows = mysql_num_rows($query);
								echo '<table class="tab_announcement">';
								
								for($k = 0; $k < $rows; $k++) {
									$returnData = mysql_fetch_assoc($query);
									$bgcolor = $returnData['bgcolor'];
									//echo '<tr style="background:'.$bgcolor.';">';
									
									
									echo '<tr>';
									
									$unm = $returnData['username'];
									echo '<td>'.smallprofilebox($unm).'</td>';
									
									
									echo '<td><p class="h2" style="margin-left:1px; float:left;">'.$returnData['subject'].'</p> <p style="float:right">' .$returnData['time'].'</p> <br/><p class="announcemessage">'.$returnData['message'].'</p></td></tr>';
									
									
									

								}
								echo '</table>';
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
