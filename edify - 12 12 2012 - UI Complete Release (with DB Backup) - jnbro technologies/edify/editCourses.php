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
<title>Edit Courses Offered</title>

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
				<p class="title">Courses Offered in the School
			
			  
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
      <?php
								if($designation == 'admin') {
									$selectedClass = $_POST['selectClass'];
									echo '<ul><li class="current_page_item"><a href="editCourses.php">Edit Courses</a></li></ul>';
									$distinctClassQuery = "SELECT DISTINCT standard FROM courses_offered ORDER BY id ASC";
									$distinctClassResult = mysql_query($distinctClassQuery);
									echo '<br><form id="searchform" method="post" style="margin-right:50px" action="editCourses.php">';
									echo '<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="selectClass">';
									while ($line = mysql_fetch_assoc($distinctClassResult)){
										$id = $line['standard'];
										echo '<option value="'.$id.'"';
										if($id == $selectedClass){
											echo ' selected';
										}
										echo '>'.$id.'</option>';
									}
									echo '</select>';
									echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Get Courses" id="z"><br><br><br>';
									if($_POST['subValue'] == 'Get Courses'){
										$coursesQuery = "SELECT * FROM courses_offered WHERE standard='$selectedClass' ORDER BY courseId ASC";
										$coursesResult = mysql_query($coursesQuery);
										echo '<h2 class="h2" style="margin-left:350px;">Class - '.$selectedClass.' Courses</h2>';
										echo '<table cellpadding=5 cellspacing=1 style="color:rgb(19,77,91); font-size: 14px; float:center;  width:700px">';
										echo '<tr><td width="10%">&nbsp;</td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); color:white;" width="30%">Course ID</td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); color:white" width="50%">Course Description</td>';
										echo '<td width="10%">&nbsp;</td></tr>';
										while ($line2 = mysql_fetch_assoc($coursesResult)){									
											echo '<tr><td width="10%">&nbsp;</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="30%">&nbsp;'.$line2['courseId'].'&nbsp;</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="50%">&nbsp;'.$line2['courseDesc'].'&nbsp;</td>';
											echo '<td width="10%">&nbsp;</td></tr>';
										}
										echo '</table>';
										echo '<input type="submit" name="subValue" value="Edit"  id="z"><br>';
									} elseif ($_POST['subValue'] == 'Edit' || $_POST['subValue'] == 'Add New Course') {
										if ($_POST['subValue'] == 'Add New Course'){
											$newRows = $_POST['newRows'] + 1;
										} else {
											$newRows = 0;
										}
										$coursesQuery = "SELECT * FROM courses_offered WHERE standard='$selectedClass' ORDER BY courseId ASC";
										$coursesResult = mysql_query($coursesQuery);
										echo '<h2 class="h2" style="margin-left:350px;">Class - '.$selectedClass.' Courses</h2>';
										echo '<table cellpadding=5 cellspacing=1 style="color:rgb(19,77,91); font-size: 14px; float:center;  width:700px">';
										echo '<tr><td width="10%">&nbsp;</td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); color:white;" width="5%">&nbsp;</td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); color:white; color:white;" width="25%">Course ID</td>';
										echo '<td align="center" style="background-color: rgb(19,77,91); color:white;" width="45%">Course Description</td>';
										echo '<td width="15%">&nbsp;</td></tr>';
										while ($line2 = mysql_fetch_assoc($coursesResult)){									
											echo '<tr><td width="10%">&nbsp;</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="5%"><input type="hidden" name="ids[]" value="'.$line2['id'].'"><input type="checkbox" name="courses[]" value="'.$line2['id'].'"></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="25%">'.$line2['courseId'].'</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="45%"><input type="text" name="courseDescs[]" size="35" style="color:rgb(14,71,33);" value="'.$line2['courseDesc'].'"/></td>';
											echo '<td width="15%">&nbsp;</td></tr>';
										}
										$newlyAddedCourseIds = $_POST['newCourseIds'];
										$newlyAddedCourseDescs = $_POST['newCourseDescs'];
										for($j = 0; $j < $newRows; $j++){
											echo '<tr><td width="10%">&nbsp;</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="5%">&nbsp;</td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="25%"><input type="text" name="newCourseIds[]" size="15" style="color:rgb(14,71,33);" value="'.$newlyAddedCourseIds[$j].'"/></td>';
											echo '<td style="border: 1px solid rgb(19,77,91);" align="center" width="45%"><input type="text" name="newCourseDescs[]" size="35" style="color:rgb(14,71,33);" value="'.$newlyAddedCourseDescs[$j].'"/></td></tr><tr /><tr />';									
										}
										echo '</table><br>';
										echo '<input type="hidden" name="newRows" value="'.$newRows.'">';
										echo '<div style="">';
										echo '&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Delete" id="z">';
										echo '&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Store" id="z">';
										echo '&nbsp;&nbsp;&nbsp;<input type="submit" name="subValue" value="Add New Course" id="z"></div><br>';
									} elseif ($_POST['subValue'] == 'Store') {
										$ids = $_POST['ids'];
										$courseIds = $_POST['courseIds'];
										$courseDescs = $_POST['courseDescs'];
										$newCourseIds = $_POST['newCourseIds'];
										$newCourseDescs = $_POST['newCourseDescs'];
										$existingArrayLength = count($ids);
										$newArrayLength = count($newCourseIds);
										for($i = 0; $i < $existingArrayLength; $i++){
											$currentId = $ids[$i];
											$currentCourseId = $courseIds[$i];
											$currentCourseId = stringReplacement($currentCourseId);
											$currentCourseDesc = $courseDescs[$i];
											$currentCourseDesc = stringReplacement($currentCourseDesc);
											$courseUpdateQuery = "UPDATE courses_offered SET courseDesc = '$currentCourseDesc' WHERE id = '$currentId'";
											mysql_query($courseUpdateQuery) or die ('Cannot update the statement in the database');
											
											$activityDate = date("Y-m-d G:i:s");
											$activityMsg = 'Edited Courses offered for standard '.$selectedClass;
											$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
											mysql_query($userActivityQuery);
										}
										for($j = 0; $j < $newArrayLength; $j++){
											$currentCourseId = $newCourseIds[$j];
											$currentCourseId = stringReplacement($currentCourseId);
											$currentCourseDesc = $newCourseDescs[$j];
											$currentCourseDesc = stringReplacement($currentCourseDesc);
											$courseInsertQuery = "INSERT INTO courses_offered (class, courseId, courseDesc) VALUES ('$selectedClass', '$currentCourseId', '$currentCourseDesc')";
											mysql_query($courseInsertQuery) or die ('Cannot insert the new lines in the database');
											
											$activityDate = date("Y-m-d G:i:s");
											$activityMsg = 'Edited Courses offered for standard '.$selectedClass;
											$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
											mysql_query($userActivityQuery);
										}
										echo '<br><br><p style="font-size:15px; color:rgb(19,77,91); margin-left:80px; font-weight:bold">Updated '.$existingArrayLength.' records and inserted '.$newArrayLength.' new records !!!</p>';
									} elseif ($_POST['subValue'] == 'Delete') {
										$ids = $_POST['courses'];
										$arrayLength = count($ids);
										for($k = 0; $k < $arrayLength; $k++){
											$currentId = $ids[$k];
											$courseDeleteQuery = "DELETE FROM courses_offered WHERE id = '$currentId'";
											mysql_query($courseDeleteQuery) or die ('Cannot delete the selected courses from the database');
										}
										$activityDate = date("Y-m-d G:i:s");
										$activityMsg = 'Edited Courses offered for standard '.$selectedClass;
										$userActivityQuery = "INSERT INTO useractivities (username, creationdate, activity) VALUES ('$username', '$activityDate', '$activityMsg')";
										mysql_query($userActivityQuery);
										echo '<br><br><p style="font-size:15px; color:rgb(19,77,91); margin-left:80px; font-weight:bold">Deleted '.$arrayLength.' records from the database !!!</p>';
									}
									echo '</form>';
								}
							?>
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
