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
<title>Reply</title>

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
				<p class="title">Forum
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
     <?php
								print "<table >";
								print "<tr><td class='h2'>Reply to the topic</td></tr>";
								print "<tr><td >";
								$id = $_GET['id'];
								$titleQuery = "SELECT title FROM forum_student WHERE postid='$id'";
								$titleResults = mysql_fetch_assoc(mysql_query($titleQuery));
								$title = $titleResults['title'];
								if(isset($_POST['submit'])) {
									$name = $fullName;
									$yourpost = $_POST['yourpost'];
									$subject = $_POST['subject'];
									$id = $_POST['id'];
									if(strlen($yourpost) < 1) {
										print "You did not type in a post."; //no post entered
									}
									else {
										$thedate = date("U");
										$creationdate = date("F j, Y, g:i a");
										$subject = strip_tags($subject);
										$name = strip_tags($name);
										$yourpost = strip_tags($yourpost);
										$insertpost = "INSERT INTO forum_student (author,title,post,creationdate,realtime,lastposter,parentid) values('$username','$subject','$yourpost','$creationdate','$thedate','$name','$id')";

										mysql_query($insertpost) or die("Could not insert post");
										$updatepost="Update forum_student set numreplies=numreplies+1, lastposter='$name',creationdate='$creationdate', lastrepliedto='$thedate' where postid='$id'";
										mysql_query($updatepost) or die("Could not update post");
										$activityDate = date("Y-m-d G:i:s");
										$activityMsg = 'Replied to the topic "'.$subject.'" on Forum';
										$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
										mysql_query($userActivityQuery);
										print "Message posted, go back to <A href='message.php?id=$id'>Message</a>.";
									}
								} else {
									print "<form action='reply.php' method='post'><br>";
									print "<input type='hidden' name='id' value='$id'><input type='hidden' name='subject' value='$title'>";
									print "Your message:<br>";
									print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name='yourpost' rows='5' cols='50'></textarea><br><br>";
									print "<input id='z' type='submit' name='submit' value='Reply'></form>";
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
