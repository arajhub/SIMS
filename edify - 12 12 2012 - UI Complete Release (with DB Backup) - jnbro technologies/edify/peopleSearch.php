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
<title>Search</title>

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
				<p class="title">Search Results
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">

    <ul>
    <li></li>
     
   <?php
					if($_GET)
					{
						
						$name = $_GET['name'];
					echo '<p class="h2"> Search Results for "'.$name.'".  </p>';
								$query = "select username,full_name from users where (username LIKE '%".$name."%' OR full_name LIKE '%".$name."%')";
							//echo $query;
							$queryResult = mysql_query($query);
							$rowsNum = mysql_num_rows($queryResult);
							if($rowsNum > 0) {
							echo '<div style=" width:100%; height:100%; float:left;">';
								for($i = 0;$i < $rowsNum;$i++) {
									$queryArray = mysql_fetch_array($queryResult);
									
									echo '<div style=" width:245px; height:80px; float:left;">'.smallprofilebox($queryArray['username']).'</div>';

								}
								echo '</div>';
								
							} else {
								echo "<b>&nbsp;&nbsp;&nbsp;No Records found!</b>";
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
