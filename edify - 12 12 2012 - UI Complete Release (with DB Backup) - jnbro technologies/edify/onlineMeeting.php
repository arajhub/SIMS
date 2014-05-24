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
	<title>Online Meeting</title>

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
<div class="pagegreywide">
<div id="pageheader" class="headergrey">
				<p class="title">Online Meeting
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="Paltalk" width="100%" height="100%" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab"><param name="movie" value="http://express.paltalk.com/embed/Paltalk.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#000000" /><param name="flashvars" value="gid=1490199758&refc=0" /><param name="allowScriptAccess" value="always" /><embed src="http://express.paltalk.com/embed/Paltalk.swf" quality="high" bgcolor="#000000" width="100%" height="100%" name="Paltalk" align="middle" play="true" loop="false" quality="high" flashvars="gid=1490199758&refc=0" allowScriptAccess="always" wmode="window" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer"></embed></object>
     
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
