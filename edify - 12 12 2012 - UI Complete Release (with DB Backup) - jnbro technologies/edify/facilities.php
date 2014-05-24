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
<title>School Facilities</title>

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
echo mainBar('facilities');
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
				<p class="title">School Facilities
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  <div>
    <ul>
    <li></li>
      <div>
        <div>
      <h2 class="h2">Bus Service</h2>
							<div class="entry"><b>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;School provides bus service for students who leaves very far from the school. They can register to any of the existing routes which will be near to their home. If the student doesn't find any route which is close to their home, they can directly contact administration for the same. <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bus stops shall be no closer together then 0.2 miles. Each student must be at the designated stop at the time of the bus's arrival.  Service personnel shall maintain buses to ensure greatest fuel economy.<br><br>
								<u>Routing and Scheduling</u><br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;School bus routing and scheduling shall be the responsibility of the Transportation Department. For safety, whenever possible, school buses should not be routed onto major highways. All exceptional students added to their school buses must be approved through the Exceptional Children's Program Department.<br><br>
								<u>Scheduling a Stop</u><br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Parents should visit their school for information on bus routes, assignments or requests.
							</b></div><br><br><br>
							<h2 class="h2">Hostel</h2>
							<div class="entry"><b>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Owing to the academic excellence of the School, a large number of outstation students wish to be a part of its community and this number is increasing annually. The school provides hostel facility for both boys and girls with a capacity of 200 each. The boys�hostel is located near the school building whereas the girls� hostel is within the school premises. There is constant supervision and monitoring of the students� activities and emphasis is laid on their safety. Movement outside both the hostels requires a written permission from the respective wardens.
							</b></div><br><br><br>
							<h2 class="h2">Computer Lab</h2>
							<div class="entry"><b>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The campus has 6 computer laboratories accessible to students during and after school hours with advanced infrastructure in terms of hardware and software to cater to the requirements of the students, teachers and the curriculum. Two of the laboratories cater to students learning C++ in classes XI and XII; one laboratory is dedicated to students of class IX learning Oracle database programming; another is dedicated to classes VI and VII where HTML and DHTML is taught.
							</b></div><br><br><br>
						</div>
        </div>
      </div>
      
    </ul>
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
