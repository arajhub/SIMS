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
	<title>School Library</title>

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
				<p class="title">Library
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <ul>
								<li><a href="aboutLibrary.php">About Library</a></li>
								<li><a href="bookStoreRetrive.php">Book Store</a></li>
								<li><a href="suggestion.php">Suggestions</a></li>
								<li><a href="booksRequested.php">Books Requested</a></li>
								<li><a href="booksIssued.php">Issued Books</a></li>
								<li><a href="booksHistory.php">Issued Books History</a></li>
							</ul><br /><br /><br /><br />
							<?php
								$today = date("Y-m-d");
								if($designation == 'librarian') {
									$issuedBooks = mysql_num_rows(mysql_query("SELECT * FROM issuedbooks"));
									$issuedBooksHistory = mysql_num_rows(mysql_query("SELECT * FROM issuedbookshistory"));
									$requestedBooks = mysql_num_rows(mysql_query("SELECT * FROM requestedbooks"));
									$booksReturn = mysql_num_rows(mysql_query("SELECT * FROM issuedbooks WHERE returnDate='$today'"));
									$booksLateReturn = mysql_num_rows(mysql_query("SELECT * FROM issuedbooks WHERE returnDate<'$today'"));
								} else {
									$issuedBooks = mysql_num_rows(mysql_query("SELECT * FROM issuedbooks where username='$username'"));
									$issuedBooksHistory = mysql_num_rows(mysql_query("SELECT * FROM issuedbookshistory where username='$username'"));
									$requestedBooks = mysql_num_rows(mysql_query("SELECT * FROM requestedbooks where username='$username'"));
									$booksReturn = mysql_num_rows(mysql_query("SELECT * FROM issuedbooks WHERE returnDate='$today' AND username='$username'"));
									$booksLateReturn = mysql_num_rows(mysql_query("SELECT * FROM issuedbooks WHERE returnDate<'$today' AND username='$username'"));
								}
								$suggestions = mysql_num_rows(mysql_query("SELECT * FROM book_suggestions"));
								$suggestionsByUser = mysql_num_rows(mysql_query("SELECT * FROM book_suggestions where suggested_by='$username'"));
							?>
							<div class="detailBox">
								<p style="margin-left:10px;">
									<font class="font1">No. of Books Issued: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="booksIssued.php"><?php echo $issuedBooks; ?></a></font>
								</p>
								<p style="margin-left:10px;">
									<font class="font1">No. of Books Issued till date: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="booksHistory.php"><?php echo $issuedBooksHistory+$issuedBooks; ?></a></font>
								</p>
								<p style="margin-left:10px;">
									<font class="font1">No. of Pending requests: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="booksRequested.php"><?php echo $requestedBooks; ?></a></font>
								</p>
								<p style="margin-left:10px;">
									<font class="font1">No. of Books suggested by you: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="suggestion.php"><?php echo $suggestionsByUser; ?></a></font>
								</p>
								<p style="margin-left:10px;">
									<font class="font1">No. of Books suggested all together: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="suggestion.php"><?php echo $suggestions; ?></a></font>
								</p>
								<p style="margin-left:10px;">
									<font class="font1">No. of Books to be returned today: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="booksIssued.php"><?php echo $booksReturn; ?></a></font>
								</p>
								<p style="margin-left:10px;">
									<font class="font1">No. of Books to be returned by yesteday: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="booksIssued.php"><?php echo $booksLateReturn; ?></a></font>
								</p>
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
