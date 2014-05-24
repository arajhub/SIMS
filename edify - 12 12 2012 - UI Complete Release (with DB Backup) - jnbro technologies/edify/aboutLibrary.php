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
<title>About Library</title>

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

			function mailBoxEntries($username,$readFlag){
				if($readFlag){
					$mailBoxQuery = "SELECT * FROM mail_box WHERE to_id='$username' ORDER BY mail_date DESC";
					$mailBoxResult = mysql_query($mailBoxQuery);
					$mailBox = '<form method="post" name="mail"><br><br>';
					$mailBox .= '<table cellspacing=0>';
					$mailBox .= '<tr><td colspan=4>&nbsp;</td></tr>';
					$mailBox .= '<td width="2%">&nbsp;</td>';
					$mailBox .= '<td class="tab_mailbox" width="20%"><b><u>From</u></b></td>';
					$mailBox .= '<td class="tab_mailbox" width="58%"><b><u>Subject</u></b></td>';
					$mailBox .= '<td class="tab_mailbox" width="20%"><b><u>Date</u></b></td>';
					$mailBox .= '</tr><tr /><tr /><tr />';
					while($line = mysql_fetch_array($mailBoxResult)){
						if($line['flag'] == 'unread'){
							$mailBox .= '<tr class="unreadMails">';
							$mailBox .= '<td width="2%"><input name="book" type="radio" value="'.$line['id'].'"></td>';
							$mailBox .= '<td width="20%"><b>'.$line['from_name'].'</b></td>';
							$mailBox .= '<td width="58%"><b>'.$line['subject'].'</b></td>';
							$mailBox .= '<td width="20%"><b>'.$line['mail_date'].'</b></td>';
							$mailBox .= '</tr><tr /><tr /><tr />';
						} else {
							$mailBox .= '<tr class="readMails">';
							$mailBox .= '<td width="2%"><input name="book" type="radio" value="'.$line['id'].'"></td>';
							$mailBox .= '<td width="20%">'.$line['from_name'].'</td><td width="58%">'.$line['subject'].'</td>';
							$mailBox .= '<td width="20%">'.$line['mail_date'].'</td>';
							$mailBox .= '</tr><tr /><tr /><tr />';
						}
					}
					$mailBox .= '</table><input type="submit" value="Open Mail" id="z" /><br><br></form>';
				} else {
					$id = $_POST['book'];
					$mailBoxQuery = "SELECT * FROM mail_box WHERE id='$id'";
					$updateQuery = "UPDATE mail_box set flag='read' WHERE id='$id'";
					$updateResult = mysql_query($updateQuery);
					$mailBoxResult = mysql_fetch_assoc(mysql_query($mailBoxQuery));
					$mailBox = '<br><br>';
					$mailBox .= '<table><tr /><tr /><tr /><tr /><tr class="readMails">';
					$mailBox .= '<td width="5%"><b>&nbsp;</b></td>';
					$mailBox .= '<td width="15%"><b>From:</b></td>';
					$mailBox .= '<td width="5%"><b>&nbsp;</b></td>';
					$mailBox .= '<td width="75%">'.$mailBoxResult['from_name'].'</td>';
					$mailBox .= '</tr>';
					$mailBox .= '<tr class="readMails">';
					$mailBox .= '<td width="5%"><b>&nbsp;</b></td>';
					$mailBox .= '<td width="15%"><b>Subject:</b></td>';
					$mailBox .= '<td width="5%"><b>&nbsp;</b></td>';
					$mailBox .= '<td width="75%">'.$mailBoxResult['subject'].'</td>';
					$mailBox .= '</tr>';
					$mailBox .= '<tr class="readMails">';
					$mailBox .= '<td width="5%"><b>&nbsp;</b></td>';
					$mailBox .= '<td width="15%"><b>Message:</b></td>';
					$mailBox .= '<td width="5%"><b>&nbsp;</b></td>';
					$mailBox .= '<td width="75%">'.$mailBoxResult['message'].'</td>';
					$mailBox .= '</tr></table>';
				}
				return $mailBox;
			}

			
			if($username){
			?>
            
            <script language="JavaScript">
			function myfunction(){
				var y = document.getElementsByName('book')
				var k = document.mail.book
				alert (y[0].comment)
				for (var i = 0; i <= k.length; i++)
				{
				   if(y[i].checked){
					   break
				   }
				}

				alert ("Selected Row is "+k[i].comment)
				document.mail.output.value = y[i].comment
				x = "<p>this is my firs JavaScript Function</p>"
				return x
			}

			function upperCase(x){
				var y = document.getElementById(x).value
				document.getElementById(x).value = y.toUpperCase()
			}
			var userID
			var x= navigator
			var password
			var array12 = new Array("vinod@dpsbhilai.com","toast")
			var str = "vinod@dpsbhilai.com!"
			var d = new Date()
			theDay = d.getTime()
		</script>
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
				<p class="title">About Library
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
          <ul>
      <li class="current_page_item"><a href="aboutLibrary.php">About Library</a></li>
      <li><a href="bookStoreRetrive.php">Book Store</a></li>
      <li><a href="suggestion.php">Suggestions</a></li>
      <li><a href="booksRequested.php">Books Requested</a></li>
      <li><a href="booksIssued.php">Issued Books</a></li>
      <li><a href="booksHistory.php">Issued Books History</a></li>
    </ul>
    <br />
    <br />
    <br />
    <table>
      <tr>
        <td class="tab_mailbox"><font style="line-height: 30px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;School has a separate Library for its Primary Wing which caters to their needs and helps the little ones to develop reading habits and also satisfies their curiosity. The Library has 5,800 books and various newspapers both in English &amp; Hindi for the benefit of the young minds.<br />
          <br />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All classes from class I onwards are provided with at least one library period per week. The Library has an open shelf system. Students are not allowed to bring their personal books in the library. Students are allowed to borrow books on their own library cards only. </font></td>
      </tr>
    </table>
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
