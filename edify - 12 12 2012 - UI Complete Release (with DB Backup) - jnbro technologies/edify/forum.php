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
<title>Forum</title>

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
			function forumDetails($username,$readFlag){
				if($readFlag){
					$mailBoxQuery = "SELECT * FROM mail_box WHERE to_id='$username'";
					$mailBoxResult = mysql_query($mailBoxQuery);
					$mailBox = '<form method="post" name="mail"><table class="tab_forum" ><tr><td width="2%">&nbsp;</td>';
					$mailBox .= '<td class="tab_mailbox" width="20%"><b><u>From</u></b></td>';
					$mailBox .= '<td class="tab_mailbox" width="58%"><b><u>Subject</u></b></td>';
					$mailBox .= '<td class="tab_mailbox" width="20%"><b><u>Date</u></b></td></tr>';
					while($line = mysql_fetch_array($mailBoxResult)){
						if($line['flag'] == 'unread'){
							$mailBox .= '<tr><td width="2%"><input name="book" type="radio" value="'.$line['id'].'"></td>';
							$mailBox .= '<td width="20%"><b>'.$line['from_name'].'</b></td>';
							$mailBox .= '<td width="58%"><b>'.$line['subject'].'</b></td>';
							$mailBox .= '<td width="20%"><b>'.$line['mail_date'].'</b></td></tr>';
						} else {
							$mailBox .= '<tr><td width="2%"><input name="book" type="radio" value="'.$line['id'].'"></td>';
							$mailBox .= '<td width="20%">'.$line['from_name'].'</td>';
							$mailBox .= '<td width="58%">'.$line['subject'].'</td>';
							$mailBox .= '<td width="20%">'.$line['mail_date'].'</td></tr>';
						}
					}
					$mailBox .= '</table><input type="submit" value="Open Mail" id="z" /><br><br></form>';
				} else {
					$id = $_POST['book'];
					$mailBoxQuery = "SELECT * FROM mail_box WHERE id='$id'";
					$updateQuery = "UPDATE mail_box set flag='read' WHERE id='$id'";
					$updateResult = mysql_query($updateQuery);
					$mailBoxResult = mysql_fetch_assoc(mysql_query($mailBoxQuery));
					$mailBox = '<br><table ><tr><td width="15%"><b>From:</b></td>';
					$mailBox .= '<td width="85%">'.$mailBoxResult['from_name'].'</td></tr>';
					$mailBox .= '<tr><td width="15%"><b>Subject:</b></td>';
					$mailBox .= '<td width="85%">'.$mailBoxResult['subject'].'</td></tr>';
					$mailBox .= '<tr><td width="15%"><b>Message:</b></td>';
					$mailBox .= '<td width="85%">'.$mailBoxResult['message'].'</td></tr></table>';
				}
				return $mailBox;
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
				<p class="title">Forum
			
			  
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
     <?php
								print '<a id="z" href="post.php" style="padding:5px;">Create New Topic</a><br><br>';
								print "<table class='tab_forum'>";
								print "<tr class='headline'>";
								print "<td width='40%' align='center'>Topic</td>";
								print "<td width='25%' align='center'>Topic Starter</td>";
								print "<td width='10%' align='center'>Replies</td>";
								print "<td width='25%' align='center'>Last replied time</td></tr>";
								$getthreads = "SELECT * from forum_student where parentid='0' order by lastrepliedto DESC";
								$getthreads2 = mysql_query($getthreads) or die("Could not get threads");
								while($getthreads3 = mysql_fetch_array($getthreads2)) {
									  $getthreads3['title'] = strip_tags($getthreads3['title']);
									  $getthreads3['author'] = strip_tags($getthreads3['author']);
									  print "<tr class='mainrow'>";
									  print "<td width='40%' class='h3'><a href='message.php?id=$getthreads3[postid]'>$getthreads3[title]</a></td>";
									  $usr=$getthreads3[author];
									  print "<td width='25%' class='cell1'> ".smallprofilebox($usr) ."</td>";
									  print "<td width='10%' class='cell1'>$getthreads3[numreplies]</td>";
									  print "<td width='25%' class='cell1'>$getthreads3[showtime]Last post by <b>$getthreads3[lastposter]</b></td></tr>";
								}
								print "</table>";
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
