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
<title>Official</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
         
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
		    $designation =$_SESSION['designation'];
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
<div class="pagered">
<div class="headerred" id="pageheader" >
				<p class="title">Official	 
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);

	 ?>
  <div>   
<?php

  if($designation=="admin" || $designation=="principal" || $designation=="teacher" || $designation=="librarian")
  {
	 ?>
  <table class="gridtable">
<tr>
<td>
<div class="griditem">
<a href="salaryPlan.php" >
<img    src="jimages/grid/salaryplan.png"  alt="SalaryPlan" />
<div align="center" class="gridtext">
<p align="center"> Salary Plan </p>
</div>
</a>
</div>
</td>
<td>
<div>
</div>
</td>

<td>
<div>
</div>
</td>

</tr>
<tr>
<td>
<div>
</div>
</td>
<td>
<div>
</div>
</td>

<td>
<div>
</div>
</td>

</tr>






</table>


<?php

  }
  else
  {
	  header( 'Location: dashboard.php' ) ;
	  }
	 ?>
     
</div>
</div>

</div>

<div class="quote" align="center">
                <?php
				echo getQuotation1();
				?>
                </div>
<?php
			} else {
		?>
	
	
<center>Please login to continue!!.</center>
						
						 <?php
						 loginbox();
						 ?>
			      
		        <?php
		            }
					
		        ?>
                
		        <div class="footer">
            Powered By ChrisTel Info Solutions (P) Ltd.
        </div>
</body>
</html>
