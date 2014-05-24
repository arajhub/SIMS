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
	<title>Theme Options</title>





</head>
<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />
<body>


 

<script type="text/javascript">
function loadimg()
{
	
	var selected=document.getElementById("backimg");
	document.body.style.background="#EBEBEB url(jimages/backs/"+selected.value+".jpg) center no-repeat fixed";
	document.getElementById('thumb').src='jimages/backs/'+selected.value+".jpg";
	}
	
	function showui()
{
	
	var selected=document.getElementById("themeid");
	
	document.getElementById('thumb').src='jimages/themepreview/'+selected.value+".png";
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
				<p class="title">Theme Options
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>

<?php

if($_POST)
{
	$uname=$_SESSION['username'];
	$themeid=$_POST['themeid'];
	$backimg=$_POST['backimg'];
	if($uname)
	{
	$databaseQuery = 'INSERT INTO themepreferences (username,themeid,backgroundimage) 
VALUES ("'.$uname.'","'.$themeid.'","'.$backimg.'")
ON DUPLICATE KEY UPDATE
username="'.$uname.'", themeid="'.$themeid.'", backgroundimage="'.$backimg.'"';

	$result = mysql_query($databaseQuery) or die('Query failed: ' . mysql_error());
	if($result)
	{
		echo 'Theme Options Saved Successfully..!';
		
//loadtheme();
?>
<script type="text/javascript">
alert("Theme Options Saved Successfully..!");
 window.location="dashboard.php";
//location.reload(true);
</script>
<?php
		}
	}
	}
		  ?>

<div id="pagecontent">
<?php

echo "<p class='h2'> Current Theme : ".$_SESSION['themeid']."&nbsp;&nbsp;&nbsp; Current Background Image : ".$_SESSION['backimg']."</p>";
?>
 <form name="thems" method="post" action="themes.php">
  Color Theme : <select name="themeid" id="themeid" onChange="showui();">
     <option>Elegant_Gloss</option>
      <option>Smart_Blue</option>   
        <option>Basic_Html</option>
        
   </select>
   
   &nbsp;&nbsp; Background Image :<select name="backimg" id="backimg" onChange="loadimg();">
   <?php
$dir_handle = 'jimages/backs/';
// Loop through the files
foreach(array_diff(scandir($dir_handle), array('.', '..')) as $file) {
echo '<option><h2>'.str_replace('.jpg', ' ', str_replace('name', 'Name', $file)).'</h2>';
echo '</option>';
}
?>
 </select>
   <input type="submit" value="Apply" id="z" />
 </form>
 <div id="imagebox">
 <img name="thumb" id="thumb" src="" width="100%" alt="Background Image" />
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
