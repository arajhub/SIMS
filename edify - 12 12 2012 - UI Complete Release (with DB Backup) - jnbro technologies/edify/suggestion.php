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
	<title>Suggestions</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>
	<script language="JavaScript">
			function checkForm() {
				var author_name, book_name;
				author_name = trim(window.document.addSuggestion.author_name.value);
				book_name = trim(window.document.addSuggestion.book_name.value);
				if(author_name == '' || book_name == '') {
					alert('Please enter the required details');
					return false;
				}
				return true;
			}
			function trim(str) {
				return str.replace(/^\s+|\s+$/g,'');
			}
		</script>

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
								<li class="current_page_item"><a href="suggestion.php">Suggestions</a></li>
								<li><a href="booksRequested.php">Books Requested</a></li>
								<li><a href="booksIssued.php">Issued Books</a></li>
								<li><a href="booksHistory.php">Issued Books History</a></li>
							</ul><br>
							<form name="addSuggestion" method="post">
								<div class="detailBox">
									<p style="margin-left:10px;">
										<font class="font1">Author's Name: </font>&nbsp;
										<font class="font2">
											<input type="text" name="author_name" size="66" value="<?php echo $_POST['author_name']; ?>">
										</font>
									</p>
									<p style="margin-left:10px;">
										<font class="font1">Book Name: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<font class="font2">
											<input type="text" name="book_name" size="66" value="<?php echo $_POST['book_name']; ?>">
										</font>
									</p>
									<p style="margin-left:10px;">
										<font class="font1">
											<input id="z" type="submit" onClick="return checkForm();" name="save" value='Suggest'>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="z" type="reset" name="Reset">
										</font>
									</p>
								</div>
							</form><br>
							<?php
								$booksSuggestedQuery = "SELECT a.author_name, a.book_name, a.suggested_on, b.full_name FROM book_suggestions a, users b WHERE a.suggested_by = b.username";
								
								$totalRows = mysql_num_rows(mysql_query($booksSuggestedQuery));

								$noOfRecords = 10;
								$noOfPages = ceil($totalRows/$noOfRecords);
								if($_GET['pageNo'] > 0) {
									$pageNo = $_GET['pageNo'];
									if($noOfPages > 0 && $pageNo >= $noOfPages){
									   $pageNo = $noOfPages - 1;
									}
									$nextPage = $pageNo + 1;
									$previousPage = $pageNo - 1;
									$startRow = ($pageNo*$noOfRecords);
								} else {
									$pageNo = 0;
									$nextPage = $pageNo + 1;
									$previousPage = 0;
									$startRow = 0;
								}
								
								$booksSuggestedQuery .= ' LIMIT '.$startRow.', '.$noOfRecords;
								echo "<div align='right'><a class='pagination' href='suggestion.php?pageNo=$previousPage'>Previous Page</a>&nbsp;&nbsp;<a class='pagination' href='suggestion.php?pageNo=$nextPage'>Next Page</a></div><br>";
								$booksSuggested = mysql_query($booksSuggestedQuery);
								echo '<table cellpadding=5 cellspacing=0 style="color: rgb(19,77,91); font-size: 14px; float:center;  width:100%">';
								echo '<tr>';
								echo '<td align="center" style="background-color: rgb(14,71,33); border-right: 1px solid white; color:white;" width="40%"><b>Book Name</b></td>';
								echo '<td align="center" style="background-color: rgb(14,71,33); border-left: 1px solid white; border-right: 1px solid white; color:white;" width="20%"><b>Author Name</b></td>';
								echo '<td align="center" style="background-color: rgb(14,71,33); border-left: 1px solid white; color:white" width="20%"><b>Suggested By</b></td>';
								echo '<td align="center" style="background-color: rgb(14,71,33); border-left: 1px solid white; color:white;" width="20%"><b>Suggested On</b></td></tr>';
								
								if(mysql_num_rows($booksSuggested) > 0) {
									while ($line2 = mysql_fetch_assoc($booksSuggested)){
										echo '<tr>';
										echo '<td style="border: 1px solid rgb(14,71,33);padding-left:10px;" align="left" width="40%">'.$line2['book_name'].'</td>';
										echo '<td style="border: 1px solid rgb(14,71,33);" align="center" width="20%">'.$line2['author_name'].'</td>';
										echo '<td style="border: 1px solid rgb(14,71,33);" align="center" width="20%">'.$line2['full_name'].'</td>';
										echo '<td style="border: 1px solid rgb(14,71,33);" align="center" width="20%">'.$line2['suggested_on'].'</td>';
										echo '</tr>';
									}
								} else {
									echo '<tr>';
									echo '<td colspan=4 style="border: 1px solid rgb(14,71,33);padding-left:10px;" align="center">No records found</td>';
									echo '</tr>';
								}
								mysql_free_result($booksSuggested);
								echo '</table><br>';
								if(isset($_POST['save'])) {										
									$authorName = stringReplacement($_POST['author_name']);
									$bookName = stringReplacement($_POST['book_name']);										
									$suggestedBy = $username;
									$suggestedOn = date("Y-m-d");										
									$insertQuery = "INSERT INTO book_suggestions (author_name, book_name, suggested_by, suggested_on) VALUES ('$authorName', '$bookName', '$suggestedBy', '$suggestedOn')";
									echo '<p class="norecordsmsg">Your suggestions has been registed</p>';
								}
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
