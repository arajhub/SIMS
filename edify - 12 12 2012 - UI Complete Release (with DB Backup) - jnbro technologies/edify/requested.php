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
<title>Requested</title>

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
								<li class="current_page_item"><a href="requested.php">Requested</a></li>
								<li><a href="issued.php">Issued</a></li>
							</ul><br>

							<?php
								$approveList = $_POST['resource'];
								$arrayLength = count($approveList);
								for($i = 0; $i < $arrayLength; $i++){
									$id = $approveList[$i];
									$issuedDate = date('Y-m-d');
									$returnDate = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+15,date('Y')));
									$updateQuery = "UPDATE inventory SET avail_copy=avail_copy-1 WHERE resourceId = (SELECT resourceId FROM requestedresources WHERE id='$id')";
									mysql_query($updateQuery) or die ("Not able to update the entry in database");
									$insertQuery = "INSERT INTO issuedresources (username, resourceId, resource,issuedDate) SELECT username, resourceId, resource,'$issuedDate' from requestedresources WHERE id='$id'";
									mysql_query($insertQuery) or die ("Cannot insert the data into database");
									$deleteQuery = "DELETE FROM requestedresources WHERE ID='$id'";
									mysql_query($deleteQuery) or die ("Cannot delete the data from database");
									$activityDate = date("Y-m-d G:i:s");
									$activityMsg = 'Issued resources from the Inventory';
									$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
									mysql_query($userActivityQuery);
								}

								if($designation == 'admin') {
									if($_POST){
										$requestedresourcesRows = mysql_num_rows(mysql_query("SELECT a.id, a.resourceId, a.resource, a.requestedDate, b.full_name, b.standard FROM requestedresources a, users b WHERE a.username = b.username AND a.username LIKE '$studentName'"));
									} else {
										$requestedresourcesRows = mysql_num_rows(mysql_query("SELECT a.id, a.resourceId, a.resource, a.requestedDate, b.full_name, b.standard FROM requestedresources a, users b WHERE a.username = b.username"));
									}
									$noOfRecords = 10;
									$noOfPages = ceil($requestedresourcesRows/$noOfRecords);
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
									if($_POST['search'] == 'Search Student'){
										$studentName = $_POST['s'];
										$studentName=str_replace("*","%",$studentName);
										$requestedresourcesQuery = "SELECT a.id, a.resourceId, a.resource, a.requestedDate, b.full_name, b.standard FROM requestedresources a, users b WHERE a.username = b.username AND a.username LIKE '$studentName' LIMIT ";
										$requestedresourcesQuery .= $startRow.', '.$noOfRecords;
										$requestedresourcesResult = mysql_query($requestedresourcesQuery);
									} else {
										$requestedresourcesQuery = "SELECT a.id, a.resourceId, a.resource, a.requestedDate, b.full_name, b.standard FROM requestedresources a, users b WHERE a.username = b.username LIMIT ";
										$requestedresourcesQuery .= $startRow.', '.$noOfRecords;
										$requestedresourcesResult = mysql_query($requestedresourcesQuery);
									}
									echo '<br><form id="searchform" method="post" action="requested.php">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="s" size="20" value="'.$_POST['s'].'">';
									echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="search" value="Search Student" id="z"></form><br>';
									echo "<div align='right'><a class='pagination' href='requested.php?pageNo=$previousPage'>Previous Page</a>&nbsp;&nbsp;<a class='pagination' href='requested.php?pageNo=$nextPage'>Next Page</a></div><br>";

									if (!$requestedresourcesResult) {
										die("query to show fields from table failed");
									} else {
										echo '<form method="post" action="requested.php"><br>';
										echo '<table cellpadding=5 cellspacing=1 style="color:rgb(19,77,91); font-size: 14px; float:center; margin-left:0px; width:95%">';
										echo '<tr><td width="3%">&nbsp;</td>';
										echo '<td width="5%" style="background-color: rgb(19,77,91); color:white;">&nbsp;</td>';
										echo '<td width="15%" style="background-color: rgb(19,77,91); color:white;" align="center"><b>Resource ID</b></td>';
										echo '<td width="25%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Resource Name</b></td>';
										echo '<td width="20%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Requested Date</b></td>';
										echo '<td width="20%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Requested By</b></td>';
										echo '<td width="12%" style="background-color: rgb(19,77,91); color:white" align="center"><b>Standard</b></td></tr>';

										if(mysql_num_rows($requestedresourcesResult) > 0){
											while($row = mysql_fetch_array($requestedresourcesResult)) {
												echo '<tr><td width="3%">&nbsp;</td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="7%">';
												echo '<input type="checkbox" name="resource[]" value="'.$row['id'].'"></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="15%" align="center">';
												echo '<b>'.$row['resourceId'].'</b></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="25%">';
												echo '<b>'.$row['resource'].'</b></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
												echo '<b>'.$row['requestedDate'].'</b></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
												echo '<b>'.$row['full_name'].'</b></td>';
												echo '<td style="border: 1px solid rgb(19,77,91);" width="20%" align="center">';
												echo '<b>'.$row['standard'].'</b></td>';
												echo '</tr>';
											}
										} else {
											echo '<tr class="mainrow"><td width="3%">&nbsp;</td><td colspan=6 align="center" class="cell1"><b>No requests left.</b></td></tr>';
										}
										mysql_free_result($requestedresourcesResult);
										echo '</table><br>';
										echo"<input type='submit' name='request' value='Approve' id='z'>";
										echo"&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='reset' value='Reset' id='z'></form>";
									}
								} else {
									$requestedresourcesResult = mysql_query("SELECT resourceId,resource,requestedDate FROM requestedresources where username='$username'");
									if (!$requestedresourcesResult) {
										die("query to show fields from table failed");
									} else {
										echo "<table class='maintable'><tr class='headline'><td width='10%' align='center'><b>Resource ID</b></td><td width='34%' align='center'><b>Resource</b></td>";
										echo "<td width='13%' align='center'><b>Requested Date</b></td></tr>";

										if(mysql_num_rows($requestedresourcesResult) > 0){
											while($row = mysql_fetch_array($requestedresourcesResult)) {
												echo '<tr class="mainrow"><td class="cell1" width="10%" align="center"><b>'.$row['resourceId'].'</b></td>';
												echo '<td class="cell1" width="34%"><b>'.$row['resource'].'</b></td>';
												echo '<td class="cell1" width="13%" align="center"><b>'.$row['requestedDate'].'</b></td></tr>';
											}
										} else {
											echo '<tr class="mainrow"><td colspan=3 align="center" class="cell1"><b>You don\'t have any requested Resources.</b></td></tr>';
										}
										mysql_free_result($requestedresourcesResult);
										echo '</table>';
									}
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
