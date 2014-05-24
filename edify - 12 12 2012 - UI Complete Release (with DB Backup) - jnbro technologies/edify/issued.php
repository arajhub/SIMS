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
<title>Inventory-Issued</title>

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
				<p class="title">Inventory
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <ul>
								<li><a href="store.php">Store</a></li>
								<li><a href="requested.php">Requested</a></li>
								<li class="current_page_item"><a href="issued.php">Issued</a></li>
							</ul><br>
							<?php
								$ResourcesReturnList = $_POST['resource'];
								$arrayLength = count($ResourcesReturnList);
								for($i = 0; $i < $arrayLength; $i++){
									$id = $ResourcesReturnList[$i];
									$originaldatetime = date("Y-m-d H:i:s");
									$time = 19800;
									$creationDate= strtotime($originaldatetime) + $time;
									$returnedOn = date("Y-m-d",$creationDate);
									$updateQuery = "UPDATE inventory SET avail_copy=avail_copy+1 WHERE resourceId = (SELECT resourceId FROM issuedresources WHERE id='$id')";
									mysql_query($updateQuery) or die ("Not able to update the entry in database");
									$insertQuery = "INSERT INTO issuedresourceshistory (username, resourceId,resource, issuedDate) SELECT username, resourceId, resource,issuedDate from issuedresources WHERE id='$id'";
									mysql_query($insertQuery) or die ("Cannot insert the data into database");
									$deleteQuery = "DELETE FROM issuedresources WHERE ID='$id'";
									mysql_query($deleteQuery) or die ("Cannot delete the data from database");
								}

								if($designation == 'admin') {
									if($_POST){
										$issuedresourcesRows = mysql_num_rows(mysql_query("SELECT a.id, a.resourceId, a.resource, a.issuedDate, b.full_name, b.standard FROM issuedresources a, users b WHERE a.username = b.username AND a.username LIKE '$studentName'"));
									} else {
										$issuedresourcesRows = mysql_num_rows(mysql_query("a.id, a.resourceId, a.resource, a.issuedDate, b.full_name, b.standard FROM issuedresources a, users b WHERE a.username = b.username"));
									}
									$noOfRecords = 10;
									$noOfPages = ceil($issuedresourcesRows/$noOfRecords);
									if($_GET['pageNo'] > 0) {
										$pageNo = $_GET['pageNo'];
										if($pageNo >= $noOfPages){
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
									if($_POST['search'] == 'Search Student'){
										$studentName = $_POST['s'];
										$studentName=str_replace("*","%",$studentName);
										$issuedresourcesQuery = "SELECT a.id, a.resourceId, a.resource, a.issuedDate, b.full_name, b.standard FROM issuedresources a, users b WHERE a.username = b.username AND a.username LIKE '$studentName' LIMIT ";
										$issuedresourcesQuery .= $startRow.', '.$noOfRecords;
										$issuedresourcesResult = mysql_query($issuedresourcesQuery);
									} else {
										$issuedresourcesQuery = "SELECT a.id, a.resourceId, a.resource, a.issuedDate, b.full_name, b.standard FROM issuedresources a, users b WHERE a.username = b.username LIMIT ";
										$issuedresourcesQuery .= $startRow.', '.$noOfRecords;
										$issuedresourcesResult = mysql_query($issuedresourcesQuery);
									}
									echo '<form id="searchform" method="post" action="issued.php">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="s" size="20" value="'.$_POST['s'].'">';
									echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="search" value="Search Student" id="z"></form><br>';
									echo "<div align='right'><a class='pagination' href='issued.php?pageNo=$previousPage'>Previous Page</a>&nbsp;&nbsp;<a class='pagination' href='issued.php?pageNo=$nextPage'>Next Page</a></div><br>";

									if (!$issuedresourcesResult) {
										die("query to show fields from table failed");
									} else {
										$fields_num = mysql_num_fields($issuedresourcesResult);
										echo '<form method="post" action="issued.php"><br>';

										echo '<table cellpadding=5 cellspacing=1 class="maintable">';
										echo '<tr><td width="3%">&nbsp;</td>';
										echo '<td width="5%" style="background-color: rgb(19,77,91); color:white;">&nbsp;</td>';
										echo '<td width="15%" style="background-color: rgb(19,77,91); color:white;" align="center"><b>Resource ID</b></td>';
										echo '<td width="25%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Resource Name</b></td>';
										echo '<td width="20%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Issued Date</b></td>';
										echo '<td width="20%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Issued To</b></td>';
										echo '<td width="12%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Standard</b></td></tr>';

										if(mysql_num_rows($issuedresourcesResult) > 0){
											while($row = mysql_fetch_array($issuedresourcesResult)) {
												echo '<tr><td width="3%">&nbsp;</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="5%">';
												echo '<input type="checkbox" name="resource[]" value="'.$row['id'].'"></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="15%" align="center">';
												echo '<b>'.$row['resourceId'].'</b></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="25%">';
												echo '<b>'.$row['resource'].'</b></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
												echo '<b>'.$row['issuedDate'].'</b></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
												echo '<b>'.$row['full_name'].'</b></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="12%" align="center">';
												echo '<b>'.$row['standard'].'</b></td>';
												echo '</tr>';
											}
										} else {
											echo '<tr><td width="3%">&nbsp;</td><td colspan=6 align="center" class="cell1"><b>No Resource has been issued.</b></td></tr>';
										}
										mysql_free_result($issuedresourcesResult);
										echo '</table><br><br>';
										echo"<input type='submit' name='request' value='Resource Returned' id='z'>";
										echo"&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='reset' value='Reset' id='z'></form>";
									}

								} else {
									$issuedresourcesResult = mysql_query("SELECT resourceId, resource,issuedDate FROM issuedresources where username='$username'");
									if (!$issuedresourcesResult) {
										die("query to show fields from table failed");
									} else {
										$fields_num = mysql_num_fields($issuedresourcesResult);
									}
									echo "<table class='maintable'><tr class='headline'><td width='10%' align='center'><b>Resource ID</b></td>";
									echo "<td width='29%' align='center'><b>Resource</b></td>";

									echo "<td width='13%' align='center'><b>Issued Date</b></td>";

									if(mysql_num_rows($issuedresourcesResult) > 0){
										while($row = mysql_fetch_array($issuedresourcesResult)) {   // printing data at the row level
											echo '<tr class="mainrow"><td class="cell1" width="10%" align="center"><b>'.$row['resourceId'].'</b></td>';
											echo '<td class="cell1" width="29%"><b>'.$row['resource'].'</b></td>';

											echo '<td class="cell1" width="13%" align="center"><b>'.$row['issuedDate'].'</b></td>';

										}
									} else {
										echo '<tr class="mainrow"><td colspan=3 align="center" class="cell1"><b>No Resources has been issued.</b></td></tr>';
									}
									mysql_free_result($issuedresourcesResult);
									echo '</table><br><br>';
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
