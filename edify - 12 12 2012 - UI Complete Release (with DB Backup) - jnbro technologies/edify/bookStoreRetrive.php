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
<title>Book Store</title>

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
  <div>
    <ul>
    <li></li>
      <div>
        <div>
          <ul>
								<li><a href="aboutLibrary.php">About Library</a></li>
								<li class="current_page_item"><a href="bookStoreRetrive.php">Book Store</a></li>
								<li><a href="suggestion.php">Suggestions</a></li>
								<li><a href="booksRequested.php">Books Requested</a></li>
								<li><a href="booksIssued.php">Issued Books</a></li>
								<li><a href="booksHistory.php">Issued Books History</a></li>
							</ul><br><br><br>
							<form id="searchform" method="post" action="bookstoreRetrive.php">
								<input type="text" name="s" size="20" value="<?php echo $_POST['s']; ?>">
								<?php
									if($_POST['mybox'] == 'bookId') {
										echo '<input type="radio" name="mybox" value="bookId" CHECKED>Book Id&nbsp;&nbsp;';
									} else {
										echo '<input type="radio" name="mybox" value="bookId">Book Id&nbsp;&nbsp;';
									}
									if($_POST['mybox'] == 'title' || ($_POST['mybox'] == null && $_POST['s'] != null)) {
										echo '<input type="radio" name="mybox" value="title" CHECKED>Title&nbsp;&nbsp;';
									} else {
										echo '<input type="radio" name="mybox" value="title">Title&nbsp;&nbsp;';
									}
									if($_POST['mybox'] == 'authorName') {
										echo '<input type="radio" name="mybox" value="authorName" CHECKED>Author Name&nbsp;&nbsp;';
									} else {
										echo '<input type="radio" name="mybox" value="authorName">Author Name&nbsp;&nbsp;';
									}
									if($_POST['mybox'] == 'subject') {
										echo '<input type="radio" name="mybox" value="subject" CHECKED>Subject&nbsp;&nbsp;&nbsp;&nbsp;';
									} else {
										echo '<input type="radio" name="mybox" value="subject">Subject&nbsp;&nbsp;&nbsp;&nbsp;';
									}
								?>
								<input type="submit" value="Search" id="z">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="reset" value="Reset" id="z">
							</form><br>
							<?php
								if($_POST){
									$columnName = $_POST['mybox'];
									if($columnName == null){
										$columnName = 'title';
									}
									$columnValue = str_replace("*","%",$_POST['s']);
									//$columnValue = '%'.$_POST['s'].'%';
									$libraryBooks = mysql_num_rows(mysql_query("SELECT * FROM library WHERE $columnName LIKE '$columnValue'"));
								} else {
									$libraryBooks = mysql_num_rows(mysql_query("SELECT * FROM library"));
								}
								$noOfRecords = 10;
								$noOfPages = ceil($libraryBooks/$noOfRecords);
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
								if($_POST) {
									$query = "SELECT * FROM library WHERE $columnName LIKE '$columnValue' LIMIT ";
									$query .= $startRow.', '.$noOfRecords;
									$queryResult = mysql_query($query);
									if(mysql_affected_rows() == 0){
										print "<br><br><table><tr><td class='tab_mailbox'>No record found in the database with the given search query !!!</td></tr></table>\n";
									} else {
										$fields_num = mysql_num_fields($queryResult);
										echo '<form method="post" action="requestBook.php">';
										echo '<table class="maintable"><tr class="headline">';
										echo '<td width="5%">&nbsp;</td>';
										echo '<td width="10%" align="center"><b>Book ID</b></td>';
										echo '<td width="35%" align="center"><b>Title</b></td>';
										echo '<td width="20%" align="center"><b>Author Name</b></td>';
										echo '<td width="20%" align="center"><b>Subject</b></td>';
										echo '<td width="10%" align="center"><b>Available Copies</b></td></tr>';
										while($row = mysql_fetch_assoc($queryResult)) {
											echo '<tr class="mainrow">';
											echo '<td class="cell1" width="5%"><input type="radio" name="book" value="'.$row['bookId'].'"></td>';
											echo '<td class="cell1" width="10%" align="center"><b>'.$row['bookId'].'</b></td>';
											echo '<td class="cell1" width="35%"><b>'.$row['title'].'</b></td>';
											echo '<td class="cell1" width="20%"><b>'.$row['authorName'].'</b></td>';
											echo '<td class="cell1" width="20%" align="center"><b>'.$row['subject'].'</b></td>';
											echo '<td class="cell1" width="10%" align="center"><b>'.$row['availableCopies'].'</b></td>';
											echo '</tr>';
										}
										echo '</table><br>';
										if($designation == 'librarian') {
											echo '</form>';
										} else {
											echo"<input type='submit' name='request' value='Request' id='m'>";
											echo"&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='reset' value='Reset' id='m'></form>";
										}
									}

								} else {
									$query = "SELECT * FROM library LIMIT ";
									$query .= $startRow.', '.$noOfRecords;
									$queryResult = mysql_query($query);
									if(mysql_affected_rows() == 0){
										print "<table><tr><td class='tab_mailbox'>No records found in the database !!!</td></tr></table>\n";
									} else {
										$fields_num = mysql_num_fields($queryResult);
										echo '<form method="post" action="requestBook.php"><br>';
										echo "<div align='right'><a class='pagination' href='bookStoreRetrive.php?pageNo=$previousPage'>Previous Page</a>&nbsp;&nbsp;<a class='pagination' href='bookStoreRetrive.php?pageNo=$nextPage'>Next Page</a></div><br>";
										echo '<table class="maintable"><tr class="headline"><td width="5%">&nbsp;</td><td width="10%" align="center"><b>Book ID</b></td><td width="35%" align="center"><b>Title</b></td><td width="20%" align="center"><b>Author Name</b></td>';
										echo '<td width="20%" align="center"><b>Subject</b></td><td width="10%" align="center"><b>Available Copies</b></td></tr>';
										while($row = mysql_fetch_assoc($queryResult)) {
											echo '<tr class="mainrow"><td class="cell1" width="5%"><input type="radio" name="book" value="'.$row['bookId'].'"></td><td class="cell1" width="10%" align="center"><b>'.$row['bookId'].'</b></td>';
											echo '<td class="cell1" width="35%"><b>'.$row['title'].'</b></td><td class="cell1" width="20%"><b>'.$row['authorName'].'</b></td>';
											echo '<td class="cell1" width="20%" align="center"><b>'.$row['subject'].'</b></td><td class="cell1" width="10%" align="center"><b>'.$row['availableCopies'].'</b></td>';
											echo '</tr>';
										}
										echo '</table><br>';
										if($designation == 'librarian') {
											echo '</form>';
										} else {
											echo"<input type='submit' name='request' value='Request' id='z'>";
											echo"&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='reset' value='Reset' id='z'></form>";
										}
									}
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
