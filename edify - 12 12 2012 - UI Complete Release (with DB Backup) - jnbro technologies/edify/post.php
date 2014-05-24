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
<title>Forum - Post</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
           	$username = $_SESSION['username'];
			$password = $_SESSION['password'];

			$designation = $_SESSION['designation'];

			$userProfileQuery = "SELECT first, middle, last FROM user_profile WHERE username='$username'";
			$userProfileResult = mysql_fetch_assoc(mysql_query($userProfileQuery));

			$fullName = $userProfileResult['first'];
			if(strlen($userProfileResult['middle']) > 1) {
				$fullName .= ' '.$userProfileResult['middle'];
			}
			$fullName .= ' '.$userProfileResult['last'];
			
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
				<p class="title">Forum
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <?php
								print "<table style='margin-left:100px;'>";
								print "<tr><td class='h2'>Post the topic</td></tr>";
								print "<tr><td >";
								if(isset($_POST['submit'])) {
									$name=$fullName;
									$yourpost=$_POST['yourpost'];
									$yourpost=str_replace("'","\'",$yourpost);
									$subject=$_POST['subject'];
									$subject = str_replace("'","\'",$subject);
									if(strlen($yourpost)<1) {
										print "You did not type in a post."; //no post entered
								    } else if(strlen($subject)<1) {
										print "You did not enter a subject."; //no subject entered
								    } else {
										$getdate=date("U");
										$creationdate=date("F j, Y, g:i a");
										$subject=strip_tags($subject);
										$subject = str_replace("'","\'",$subject);
										$name=strip_tags($name);
										$yourpost=strip_tags($yourpost);
										$yourpost=str_replace("'","\'",$yourpost);
										$insertpost="INSERT INTO forum_student(author,title,post,creationdate,realtime,lastposter,parentid) values('$username','$subject','$yourpost','$creationdate','$getdate','$name',0)";
										mysql_query($insertpost) or die("Could not insert post");
										$activityDate = date("Y-m-d G:i:s");
										$activityMsg = 'Posted a new topic on Forum with the title "'.$subject.'"';
										$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
										mysql_query($userActivityQuery);
										print "Message posted, go back to <a href='forum.php'><b>Main Forum</b></a>.";
									}
								} else {
									print "<form action='post.php' method='post'><br>";
									print "Subject:<br>";
									print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='subject' size='66'><br><br>";
									print "Your message:<br>";
									print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name='yourpost' rows='5' cols='50'></textarea><br><br>";
									print "<input id='z' type='submit' name='submit' value='Post'></form>";
								}
								print "</td></tr></table>";
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
