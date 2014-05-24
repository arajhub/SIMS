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
<title>Manage</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>


 <?php
            if ($_POST){
                $_SESSION['username']=$_POST['uname'];
                $_SESSION['password']=$_POST['passwd'];
            }
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
		    
            $imageFileExten = '.jpg';
            $imageFileName = $username.$imageFileExten;
            $loginQuery = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $userDetailsQuery = "SELECT * FROM user_profile WHERE username='$username'";
	        $loginResult = mysql_query($loginQuery);
	        $userDetailsResult = mysql_fetch_assoc(mysql_query($userDetailsQuery));
			$userStandard = $userDetailsResult['standard'];
			$userSection = $userDetailsResult['section'];
            $fullName = $userDetailsResult['first'];
            if(strlen($userDetailsResult['middle']) > 1) {
                $fullName .= ' '.$userDetailsResult['middle'];
            }
            $fullName .= ' '.$userDetailsResult['last'];
            $_SESSION['fullName']=$fullName;
            $_SESSION['designation']=$userDetailsResult['designation'];
			$designation= $_SESSION['designation'];
	        $result1 = mysql_num_rows($loginResult);

	        function getQuotation1(){
	            $maxQuery = "SELECT max(id) 'MV' FROM quotation";
	            $maxValue = mysql_fetch_array(mysql_query($maxQuery));
	            $randomNum = rand(1,$maxValue['MV']);
	            $quoteQuery = "SELECT * FROM quotation WHERE id='$randomNum'";
	            $quoteResult = mysql_fetch_assoc(mysql_query($quoteQuery));
	            return $quoteResult['quotation'].'  -  <font color="#BB0000"><i>'.$quoteResult['author'].'</i></font>';
	        }
			if($result1 != 0){
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
<div class="pagepink">
<div class="headerpink" id="pageheader" >
				<p class="title">Manage
			 
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
  <?php
  if($designation=='admin' || $designation=='principal')
  {
	?>
  <table class="gridtable">
<tr>
<td>
<div class="griditem">
<a href="manageUsers.php" >
<img    src="jimages/grid/manageusers.png"  alt="Manage Users" />
<div align="center" class="gridtext">
<p align="center"> Manage Users </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="manageUserActivities.php" >
<img    src="jimages/grid/useractivity.png"  alt="User Activity" />
<div align="center" class="gridtext">
<p align="center"> User Activity </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="manageHelpContent.php" >
<img    src="jimages/grid/managehelp.png"  alt="Manage Help" />
<div align="center" class="gridtext">
<p align="center"> Manage Help </p>
</div>
</a>
</div>
</td>

</tr>

<tr>
<td>
<div class="griditem">
<a href="manageCourses.php" >
<img    src="jimages/grid/courses.png"  alt="Manage Cources" />
<div align="center" class="gridtext">
<p align="center"> Manage Cources </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="inventory.php" >
<img    src="jimages/grid/inventory.png"  alt="Manage Inventory" />
<div align="center" class="gridtext">
<p align="center"> Inventory </p>
</div>
</a>
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
	?>
    <?php
  if($designation=='student')
  {
	?>
    
     <table class="gridtable">


<tr>
<td>
<div class="griditem">
<a href="inventory.php" >
<img    src="jimages/grid/inventory.png"  alt="Manage Inventory" />
<div align="center" class="gridtext">
<p align="center"> Inventory </p>
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

</td>
<td>

</td>

<td>

</td>

</tr>

</table>

    <?php
  }
	?>
    
    
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
