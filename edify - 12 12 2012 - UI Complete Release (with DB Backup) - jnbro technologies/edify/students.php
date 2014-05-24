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
<title>Students</title>

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
				<p class="title">Students
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  <?php
							$query = "select standard,section from users where username='$username'";
							$queryResult = mysql_query($query);
							$userClass = mysql_fetch_assoc($queryResult);
							$class = $userClass['standard'];
							$section = $userClass['section'];
							$classQuery = "select username,full_name from users where standard='$class' AND section='$section' AND username!='$username' AND designation != 'teacher'";
							if($designation == 'parent'){
								$classQuery = "select username, full_name from users WHERE standard in (select standard from users where parent = '$username') and designation = 'student'";
							}
							$classQueryResult = mysql_query($classQuery);
							$rows = mysql_num_rows($classQueryResult);
							if($designation == 'teacher' || $designation == 'parent'){
								if($rows>0) {
									echo '<form method="post" name="search" action="profile.php">';
									echo '<table class="tab_search"><tr><td width="8%">&nbsp;</td>';
									echo '<td class="tab_mailbox" width="35%"><b><u>UserId</u></b></td>';
									echo '<td class="tab_mailbox" width="57%"><b><u>Name</u></b></td></tr><tr /><tr /><tr />';
									for($i=0;$i<$rows;$i++) {
										$classArray=mysql_fetch_array($classQueryResult);
										echo '<tr><td width="8%"><input name="id" type="radio" value="'.$classArray['username'].'"></td>';
										echo '<td width="35%"><b>'.$classArray['username'].'</b></td>';
										echo '<td width="57%"><b>'.$classArray['full_name'].'</b></td></tr>';
									}
									echo '</table>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="View" id="z" /><br><br></form>';
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
