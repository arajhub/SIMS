<?php
    include_once "dbconnect.php";
    include_once "myPhpFunctions.php";
    include_once "staticCalendar.php";
	    include_once "jfunctions.php";
?>


<head>

<title>Edify Dashboard</title>



       

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
<div class="pageorange">
<div class="headerorange" id="pageheader" >
				<p class="title">Dashboard
			 <b class="subtitle">Welcome, <?php echo $fullName; ?></b>
			  
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

<a href="profile.php" >
<img     src="jimages/grid/myprofile.png"  alt="My Profile" />
<div align="center" class="gridtext">
<p align="center"> My Profile </p>
</div>
</a>
</div>

</td>
<td>
<div class="griditem">
<a href="mailBox.php" >
<img    src="jimages/grid/mailbox.png"  alt="MailBox" />
<div align="center" class="gridtext">
<p align="center"> MailBox </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="events.php" >
<img    src="jimages/grid/events.png"  alt="Events" />
<div align="center" class="gridtext">
<p align="center"> Reminders </p>
</div>
</a>
</div>
</td>

</tr>

<tr>
<td>
<div class="griditem">
<a href="attendance.php" >
<img    src="jimages/grid/attendance.png"  alt="Attendance" />
<div align="center" class="gridtext">
<p align="center"> Attendance </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="performance.php" >
<img    src="jimages/grid/performance.png"  alt="Performance" />
<div align="center" class="gridtext">
<p align="center"> Performance </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="announcements.php" >
<img    src="jimages/grid/anouncements.png"  alt="Announcements" />
<div align="center" class="gridtext">
<p align="center"> Announcements </p>
</div>
</a>
</div>
</td>

</tr>



<tr>
<td>
<div class="griditem">
<a href="onlineMeeting.php" >
<img    src="jimages/grid/webconfrencing.png"  alt="E-Meeting" />
<div align="center" class="gridtext">
<p align="center"> E-Meeting </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="faculty.php" >
<img    src="jimages/grid/faculty.png"  alt="Faculty" />
<div align="center" class="gridtext">
<p align="center"> Faculty </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="library.php" >
<img    src="jimages/grid/library.png"  alt="Library" />
<div align="center" class="gridtext">
<p align="center"> Library </p>
</div>
</a>
</div>
</td>

</tr>

</table>

<?php
  }
  if($designation=='student')
  { ?>
    <table class="gridtable">
<tr>
<td>
<div class="griditem">
<a href="profile.php" >
<img    src="jimages/grid/myprofile.png"  alt="My Profile" />
<div align="center" class="gridtext">
<p align="center"> My Profile </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="mailBox.php" >
<img    src="jimages/grid/mailbox.png"  alt="MailBox" />
<div align="center" class="gridtext">
<p align="center"> MailBox </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="events.php" >
<img    src="jimages/grid/events.png"  alt="Events" />
<div align="center" class="gridtext">
<p align="center"> Reminders </p>
</div>
</a>
</div>
</td>

</tr>

<tr>
<td>
<div class="griditem">
<a href="attendance.php" >
<img    src="jimages/grid/attendance.png"  alt="Attendance" />
<div align="center" class="gridtext">
<p align="center"> Attendance </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="performance.php" >
<img    src="jimages/grid/performance.png"  alt="Performance" />
<div align="center" class="gridtext">
<p align="center"> Performance </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="announcements.php" >
<img    src="jimages/grid/anouncements.png"  alt="Announcements" />
<div align="center" class="gridtext">
<p align="center"> Announcements </p>
</div>
</a>
</div>
</td>

</tr>



<tr>
<td>
<div class="griditem">
<a href="forum.php" >
<img    src="jimages/grid/forums.png"  alt="Forum" />
<div align="center" class="gridtext">
<p align="center"> Forum </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="classmates.php" >
<img    src="jimages/grid/classmates.png"  alt="Classmates" />
<div align="center" class="gridtext">
<p align="center"> Classmates </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="library.php" >
<img    src="jimages/grid/library.png"  alt="Library" />
<div align="center" class="gridtext">
<p align="center"> Library </p>
</div>
</a>
</div>
</td>

</tr>

</table>
  <?php
  }
	?>
    
    <?php
  if($designation=='librarian')
  {
	 ?>
       <table class="gridtable">
<tr>
<td>
<div class="griditem">
<a href="profile.php" >
<img    src="jimages/grid/myprofile.png"  alt="My Profile" />
<div align="center" class="gridtext">
<p align="center"> My Profile </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="mailBox.php" >
<img    src="jimages/grid/mailbox.png"  alt="MailBox" />
<div align="center" class="gridtext">
<p align="center"> MailBox </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="events.php" >
<img    src="jimages/grid/events.png"  alt="Events" />
<div align="center" class="gridtext">
<p align="center"> Events </p>
</div>
</a>
</div>
</td>

</tr>

<tr>
<td>
<div class="griditem">
<a href="onlineMeeting.php" >
<img    src="jimages/grid/webconfrencing.png"  alt="E-Meeting" />
<div align="center" class="gridtext">
<p align="center"> E-Meeting </p>
</div>
</a>
</div>
</td>
<td>
<div class="griditem">
<a href="library.php" >
<img    src="jimages/grid/library.png"  alt="Library" />
<div align="center" class="gridtext">
<p align="center"> Library </p>
</div>
</a>
</div>
</td>

<td>
<div class="griditem">
<a href="announcements.php" >
<img    src="jimages/grid/anouncements.png"  alt="Announcements" />
<div align="center" class="gridtext">
<p align="center"> Announcements </p>
</div>
</a>
</div>
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
