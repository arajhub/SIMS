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
<title>Request for a Resource</title>

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
								<li><a href="issued.php">Issued</a></li>
							</ul><br><br>
							<?php
								if($_POST) {
									$resourceId = $_POST['resource'];
									$query = "SELECT * FROM inventory WHERE resourceId='$resourceId'";
									$queryResult = mysql_fetch_array(mysql_query($query));
									if(mysql_affected_rows() == 0){
										print "<table><tr><td class='tab_mailbox'>No record found in the database with the given search query !!!</td></tr></table>\n";
									} else {
										$resource = $queryResult['resource'];
										$resource=str_replace("'","\'",$resource);
										$requestedDate=date("Y-m-d G:i:s");
										$insertQuery = "INSERT INTO requestedresources (username, resourceId,resource,requestedDate) VALUES ('$username','$resourceId','$resource','$requestedDate')";
										$requestedresourcesRows = mysql_num_rows(mysql_query("SELECT * FROM requestedresources WHERE username='$username' and resourceId='$resourceId'"));
										$issuedResourcesRows = mysql_num_rows(mysql_query("SELECT * FROM issuedResources WHERE username='$username' and resourceId='$resourceId'"));
										if($requestedresourcesRows >= 1){
                                            print "<table><tr><td class='tab_mailbox'>You have already placed a request for this resource. Go back to <a href='inventory.php'>My inventory Acount</a></td></tr></table>\n";
										} else {
                                            if($issuedResourcesRows >= 1) {
                                                print "<table><tr><td class='tab_mailbox'>You have already placed a request for this Resource. Go back to <a href='inventory.php'>My Inventory Acount</a></td></tr></table>\n";
                                            } else {
                                                mysql_query($insertQuery) or die ("Cannot insert into databse");
                                                print "<table><tr><td class='tab_mailbox'>Your request for the resource has been successfully placed. Go back to <a href='inventory.php'>My Inventory Acount</a></td></tr></table>\n";
                                            }
										}
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
