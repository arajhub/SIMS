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
<title>School Inventory</title>

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
							</ul><br><br><br>
							<?php
								if($designation == 'admin') {
									$issuedresourcesResult = mysql_num_rows(mysql_query("SELECT * FROM issuedresources"));
									$requestedresourcesResult = mysql_num_rows(mysql_query("SELECT * FROM requestedresources"));
								} else {
									$issuedresourcesResult = mysql_num_rows(mysql_query("SELECT * FROM issuedresources where username='$username'"));
									$requestedresourcesResult = mysql_num_rows(mysql_query("SELECT * FROM requestedresources where username='$username'"));
								}
							?>
							<div class="detailBox">
								<p style="margin-left:10px;">
									<font class="font1">No. of Inventories Issued: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="issued.php"><?php echo $issuedresourcesResult; ?></a></font>
								</p>
								<p style="margin-left:10px;">
									<font class="font1">No. of Inventories Requested: </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font class="font2"><a href="requested.php"><?php echo $requestedresourcesResult; ?></a></font>
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
