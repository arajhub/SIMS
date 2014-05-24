<?php
    include ("dbconnect.php");
	
    function mainBar($currentLink  = NULL){
	loadtheme();
$returnValue =	'<div  id="headerbox">';

$returnValue .= '<div id="header">';
$returnValue .= '<a href="dashboard.php"><div class="logo"></div></a>';
$returnValue .= '<div id="searchbox" >';
	//include "search.html";
$returnValue .= searchbox();
	$returnValue .= '</div>';
$returnValue .= '<div class="companylogo"></div>';




$returnValue .= '<div id="menudiv">';
$returnValue .='<script type="text/javascript">';


$returnValue .='function showlogout() {';

$returnValue .=' var o=document.getElementById("logoutbox");';

 $returnValue .='   o.style.display=(o.style.display=="block")?"none":"block";';
 
$returnValue .='}';

$returnValue .=' </script>';
$returnValue .= '<ul class="nav-main" id="navigation" name="navigation">';


if($currentLink == 'home' || isset($currentLink)==false ) {
	   		$returnValue .= '<li class="active"><a href="dashboard.php">Home</a></li>';
}
else
{
	$returnValue .= '<li><a href="dashboard.php">Home</a></li>';
	}
				if($currentLink == 'facilities') {
			$returnValue .= '<li class="active"><a href="facilities.php" onMouseOver="window.status='."'Facilities'; return true".'">Facilities</a></li>';
		} else {
			$returnValue .= '<li><a href="facilities.php" onMouseOver="window.status='."'Facilities'; return true".'">Facilities</a></li>';
		}
		if($currentLink == 'news') {
			$returnValue .= '<li class="active"><a href="news.php" onMouseOver="window.status='."'News'; return true".'">News</a></li>';
		} else {
			$returnValue .= '<li><a href="news.php" onMouseOver="window.status='."'News'; return true".'">News</a></li>';
		}
		if($currentLink == 'photos') {
			$returnValue .= '<li class="active"><a href="photos.php" onMouseOver="window.status='."'Photo Gallery'; return true".'">Photo Gallery</a></li>';
		} else {
			$returnValue .= '<li><a href="photos.php" onMouseOver="window.status='."'Photo Gallery'; return true".'">Photo Gallery</a></li>';
		}
		
		
		if($currentLink == 'help') {
			$returnValue .= '<li class="active"><a href="help.php" onMouseOver="window.status='."'Help'; return true".'">Help</a></li>';
		} else {
			$returnValue .= '<li><a href="help.php" onMouseOver="window.status='."'Help'; return true".'">Help</a></li>';
		}
	
    $usernames = $_SESSION['fullName'];

$returnValue .='<li id="logoutmenu"><a href="javascript:;" onClick="showlogout();">'. $usernames.'</a></li>';
$returnValue .= '</ul>';


$returnValue .= '</div>';
$returnValue .= '<div id="logoutbox">';
$returnValue .='<div id="logoutpart1">    ';
$username = $_SESSION['username'];
$fname=$_SESSION['fullName'];
$desig=$_SESSION['designation'];
	$imageFileExten = '.jpg';
			$imageFileName = $username.$imageFileExten;
$filename='profilePhotos/'.$imageFileName;
$returnValue .='<p  class="closebutton"><a href="javascript:;" onClick="showlogout();"> x </a></p>';
if (file_exists($filename)) {
 $returnValue .= '<img  src=profilePhotos/'.$imageFileName.'  width="100" height="120" alt="ProfilePicture" align="center" />';
} else {
   $returnValue .='<img src=profilePhotos/profilepicture.png  width="100" height="120" alt="ProfilePicture" align="center" />';
}
$returnValue .='<p class="fname"><br/>'.$fname.'</p>';
$returnValue .='<p class="dsg">'.$desig.'<br/></p>';
$returnValue .=' <a href="profile.php" style="float:left;" class="bluebutton">View Profile</a>   ';
$returnValue .='</div>    ';
$returnValue .='<div id="logoutpart2">    ';
$returnValue .=' <a href="settings-menu.php" style="float:left;" class="logoutbutton">Settings</a>   ';
$returnValue .=' <a href="logout.php" style="float:right;" class="logoutbutton">Sign Out</a>   ';


$returnValue .='</div>     ';

$returnValue .= '</div>';

$returnValue .= '</div>';

$returnValue .= '</div>';
		
		return $returnValue;
    }
	
	function topMenuBar($currentLink){
		
 loadtheme();

		$returnValue =	'<div  class="ui-layout-north"  style="width:100%; height:90px;">';

$returnValue .= '<div id="header">';

$returnValue .= '<div id="mainmenu">';
$returnValue .= '<ul class="nav-main" id="navigation" name="navigation">';
		$returnValue .= '<li><a href="dashboard.php">Home</a></li>';
				if($currentLink == 'facilities') {
			$returnValue .= '<li class="active"><a href="facilities.php" onMouseOver="window.status='."'Facilities'; return true".'">Facilities</a></li>';
		} else {
			$returnValue .= '<li><a href="facilities.php" onMouseOver="window.status='."'Facilities'; return true".'">Facilities</a></li>';
		}
		if($currentLink == 'news') {
			$returnValue .= '<li class="active"><a href="news.php" onMouseOver="window.status='."'News'; return true".'">News</a></li>';
		} else {
			$returnValue .= '<li><a href="news.php" onMouseOver="window.status='."'News'; return true".'">News</a></li>';
		}
		if($currentLink == 'photos') {
			$returnValue .= '<li class="active"><a href="photos.php" onMouseOver="window.status='."'Photo Gallery'; return true".'">Photo Gallery</a></li>';
		} else {
			$returnValue .= '<li><a href="photos.php" onMouseOver="window.status='."'Photo Gallery'; return true".'">Photo Gallery</a></li>';
		}
		
		if($currentLink == 'feedback') {
			$returnValue .= '<li class="active"><a href="feedback.php" onMouseOver="window.status='."'Send Feedback'; return true".'">Feedback</a></li>';
		} else {
			$returnValue .= '<li><a href="feedback.php" onMouseOver="window.status='."'Send Feedback'; return true".'">Feedback</a></li>';
		}
		if($currentLink == 'contactUs') {
			$returnValue .= '<li class="active"><a href="contactUs.php" onMouseOver="window.status='."'Out Contact Details'; return true".'">Contact Us</a></li>';
		} else {
			$returnValue .= '<li><a href="contactUs.php" onMouseOver="window.status='."'Our Contact Details'; return true".'">Contact Us</a></li>';
		}
		if($currentLink == 'help') {
			$returnValue .= '<li class="active"><a href="help.php" onMouseOver="window.status='."'Help'; return true".'">Help</a></li>';
		} else {
			$returnValue .= '<li><a href="help.php" onMouseOver="window.status='."'Help'; return true".'">Help</a></li>';
		}
		$returnValue .= '</ul></div>';
		$returnValue .= '<div class="logo"><img name="ProductLogo" src="jimages/productlogo.png" width="200" height="70" alt="" /> </div>';
$returnValue .= '<img name="CompanyLogo" src="jimages/Christel.png" width="200" height="70" alt="" align="right"/>';
$returnValue .= '</div>';
$returnValue .= '</div>';
		return $returnValue;
	}
	
	function SearchBar($name=null, $selectedDesignation=null){
	echo '<div id="searchbar">';
		echo '<center>';
		echo '<form id="searchform" method="post" action="peopleSearch.php">';
		echo '<div>';
		echo 'Find People';
		echo '<input type="text" name="name" size="20" id="s" value="'.$name.'" />';
		
		echo '<input type="submit" value="Search" id="z" />';
		echo '</div>';
		echo '</form>';
		echo '</center>';
		echo '</div>';
	}
	
	function getHelpContent($designation){
		$returnValue = '<div class="entry">';
		$helpContentQuery = "SELECT * FROM help_content WHERE designation='$designation'";
		$helpContentResult = mysql_query($helpContentQuery) or die ("Cannot find the required table in database");
		while($line = mysql_fetch_assoc($helpContentResult)){
			$returnValue .= '<b><u>'.$line['link_name'].'</u></b>: ';
			$returnValue .= $line['help_text'].'<br>';
		}
		$returnValue .= '</div>';
		
		return $returnValue;
	}
	
	class studentPerformance {
		function getForm($standard) {
			$subjectQuery = "SELECT * FROM users";
			$subjectResults = mysql_query($subjectQuery) or die ("Cannot connect to the database");
			$helpContentQuery = "SELECT * FROM help_content WHERE designation='$designation'";
			$helpContentResult = mysql_query($helpContentQuery) or die ("Cannot find the required table in database");
			while($line = mysql_fetch_assoc($helpContentResult)){
				$returnValue .= '<b><u>'.$line['link_name'].'</u></b>: ';
				$returnValue .= $line['help_text'].'<br>';
			}
			echo $returnValue;
		}
	}
	 
	function stringReplacement($string){
		$string=str_replace("'","\'",$string);
		$string=str_replace('"','\"',$string);
		$string=str_replace('*','%',$string);
		return trim($string);
	}

    function sideBar1($currentLink,$designation) {
	$returnValue .= '<div id="leftsidebar">';
        $returnValue .= '<div id="sidebar1" class="sidebar">';
		if($designation=='student'){
		$returnValue .= '<ul><li><h2>Main Menu</h2><ul>';
			if($currentLink == 'profile'){
                $returnValue .= '<li class="current_li"><a href="profile.php" onMouseOver="window.status='."'Visit your Profile'; return true".'">Profile</a></li>';
			} else {
                $returnValue .= '<li><a href="profile.php" onMouseOver="window.status='."'Visit your Profile'; return true".'">Profile</a></li>';
			}
			if($currentLink == 'attendance'){
                $returnValue .= '<li class="current_li"><a href="attendance.php" onMouseOver="window.status='."'View Attendance'; return true".'">Attendance</a></li>';
			} else {
                $returnValue .= '<li><a href="attendance.php" onMouseOver="window.status='."'View Attendance'; return true".'">Attendance</a></li>';
			}
			if($currentLink == 'library'){
                $returnValue .= '<li class="current_li"><a href="library.php" onMouseOver="window.status='."'View Books in Library'; return true".'">Library</a></li>';
			} else {
                $returnValue .= '<li><a href="library.php" onMouseOver="window.status='."'View Books in Library'; return true".'">Library</a></li>';
			}	 
			if($currentLink == 'forum'){
                $returnValue .= '<li class="current_li"><a href="forum.php" onMouseOver="window.status='."'Forum'; return true".'">Forum</a></li>';
			} else {
                $returnValue .= '<li><a href="forum.php" onMouseOver="window.status='."'Forum'; return true".'">Forum</a></li>';
			}
			if($currentLink == 'mailBox'){
                $returnValue .= '<li class="current_li"><a href="mailBox.php" onMouseOver="window.status='."'Your Mailbox'; return true".'">Mail Box</a></li>';
			} else {
                $returnValue .= '<li><a href="mailBox.php" onMouseOver="window.status='."'Your Mailbox'; return true".'">Mail Box</a></li>';
			}
			if($currentLink == 'performance'){
                $returnValue .= '<li class="current_li"><a href="performance.php" onMouseOver="window.status='."'Performance'; return true".'">Performance</a></li>';
			} else {
                $returnValue .= '<li><a href="performance.php" onMouseOver="window.status='."'Performance'; return true".'">Performance</a></li>';
			}
			if($currentLink == 'inventory'){
                $returnValue .= '<li class="current_li"><a href="inventory.php" onMouseOver="window.status='."'Inventory'; return true".'">Inventory</a></li>';
			} else {
                $returnValue .= '<li><a href="inventory.php" onMouseOver="window.status='."'Inventory'; return true".'">Inventory</a></li>';
			}
			if($currentLink == 'announcements'){
                $returnValue .= '<li class="current_li"><a href="announcements.php" onMouseOver="window.status='."'Important Announcements'; return true".'">Announcements</a></li>';
			} else {
                $returnValue .= '<li><a href="announcements.php" onMouseOver="window.status='."'Important Announcements'; return true".'">Announcements</a></li>';
			}
			if($currentLink == 'classmates'){
                $returnValue .= '<li class="current_li"><a href="classmates.php" onMouseOver="window.status='."'Classmates'; return true".'">Classmates</a></li>';
			} else {
                $returnValue .= '<li><a href="classmates.php" onMouseOver="window.status='."'Classmates'; return true".'">Classmates</a></li>';
			}
			if($currentLink == 'faculty'){
                $returnValue .= '<li class="current_li"><a href="faculty.php" onMouseOver="window.status='."'Faculty'; return true".'">Faculty</a></li>';
			} else {
                $returnValue .= '<li><a href="faculty.php" onMouseOver="window.status='."'Faculty'; return true".'">Faculty</a></li>';
			}
			if($currentLink == 'courses'){
				$returnValue .= '<li class="current_li"><a href="courses.php" onMouseOver="window.status='."'Courses'; return true".'">Courses Offered</a></li>';
			} else {
				$returnValue .= '<li><a href="courses.php" onMouseOver="window.status='."'Courses'; return true".'">Courses Offered</a></li>';
			}
			if($currentLink == 'events'){
                $returnValue .= '<li class="current_li"><a href="events.php" onMouseOver="window.status='."'Ongoing Events'; return true".'">Ongoing Events</a></li>';
			} else {
                $returnValue .= '<li><a href="events.php" onMouseOver="window.status='."'Ongoing Events'; return true".'">Ongoing Events</a></li>';
			}
			if($currentLink == 'settings'){
                $returnValue .= '<li class="current_li"><a href="settings.php" onMouseOver="window.status='."'Change Password'; return true".'">Change Password</a></li>';
			} else {
                $returnValue .= '<li><a href="settings.php" onMouseOver="window.status='."'Change Password'; return true".'">Change Password</a></li>';
			}
			if($currentLink == 'logout'){
                $returnValue .= '<li class="current_li"><a href="logout.php" onMouseOver="window.status='."'Logout'; return true".'">Logout</a></li>';
			} else {
                $returnValue .= '<li><a href="logout.php" onMouseOver="window.status='."'Logout'; return true".'">Logout</a></li>';
			}
			$returnValue .=  '</ul></li></ul></div> </div>';
			return $returnValue;
		} elseif($designation=='parent'){
		$returnValue .= '<ul><li><h2>Main Menu</h2><ul>';
			if($currentLink == 'profile'){
				$returnValue .= '<li class="current_li"><a href="profile.php" onMouseOver="window.status='."'View Profile'; return true".'">Profile</a></li>';
			} else {
				$returnValue .= '<li><a href="profile.php" onMouseOver="window.status='."'View Profile'; return true".'">Profile</a></li>';
			}
			if($currentLink == 'attendance'){
				$returnValue .= '<li class="current_li"><a href="attendance.php" onMouseOver="window.status='."'Attendance'; return true".'">Attendance</a></li>';
			} else {
				$returnValue .= '<li><a href="attendance.php" onMouseOver="window.status='."'Attendance'; return true".'">Attendance</a></li>';
			}
			if($currentLink == 'leaveApplication'){
				$returnValue .= '<li class="current_li"><a href="leaveApplication.php" onMouseOver="window.status='."'Apply for Leave'; return true".'">Leave Application</a></li>';
			} else {
				$returnValue .= '<li><a href="leaveApplication.php" onMouseOver="window.status='."'Apply for Leave'; return true".'">Leave Application</a></li>';
			}	 
			if($currentLink == 'feeStructure'){
				$returnValue .= '<li class="current_li"><a href="feeStructure.php" onMouseOver="window.status='."'Fee Structure'; return true".'">Fee Structure</a></li>';
			} else {
				$returnValue .= '<li><a href="feeStructure.php" onMouseOver="window.status='."'Fee Structure'; return true".'">Fee Structure</a></li>';
			} 
			if($currentLink == 'onlineMeeting'){
				$returnValue .= '<li class="current_li"><a href="onlineMeeting.php" onMouseOver="window.status='."'Online Meeting'; return true".'">Online Meeting</a></li>';
			} else {
				$returnValue .= '<li><a href="onlineMeeting.php" onMouseOver="window.status='."'Online Meeting'; return true".'">Online Meeting</a></li>';
			}	 
			if($currentLink == 'mailBox'){
				$returnValue .= '<li class="current_li"><a href="mailBox.php" onMouseOver="window.status='."'Mailbox'; return true".'">Mail Box</a></li>';
			} else {
				$returnValue .= '<li><a href="mailBox.php" onMouseOver="window.status='."'Mailbox'; return true".'">Mail Box</a></li>';
			}
			if($currentLink == 'performance'){
				$returnValue .= '<li class="current_li"><a href="performance.php" onMouseOver="window.status='."'Children\'s Performance'; return true".'">Performance</a></li>';
			} else {
				$returnValue .= '<li><a href="performance.php" onMouseOver="window.status='."'Children\'s Performance'; return true".'">Performance</a></li>';
			}
			if($currentLink == 'announcements'){
				$returnValue .= '<li class="current_li"><a href="announcements.php" onMouseOver="window.status='."'Important Announcements'; return true".'">Announcements</a></li>';
			} else {
				$returnValue .= '<li><a href="announcements.php" onMouseOver="window.status='."'Important Announcements'; return true".'">Announcements</a></li>';
			}
			if($currentLink == 'students'){
				$returnValue .= '<li class="current_li"><a href="students.php" onMouseOver="window.status='."'Students'; return true".'">Students</a></li>';
			} else {
				$returnValue .= '<li><a href="students.php" onMouseOver="window.status='."'Students'; return true".'">Students</a></li>';
			}
			if($currentLink == 'faculty'){
				$returnValue .= '<li class="current_li"><a href="faculty.php" onMouseOver="window.status='."'Faculty'; return true".'">Faculty</a></li>';
			} else {
				$returnValue .= '<li><a href="faculty.php" onMouseOver="window.status='."'Faculty'; return true".'">Faculty</a></li>';
			}
			if($currentLink == 'courses'){
				$returnValue .= '<li class="current_li"><a href="courses.php" onMouseOver="window.status='."'Courses Offered'; return true".'">Courses Offered</a></li>';
			} else {
				$returnValue .= '<li><a href="courses.php" onMouseOver="window.status='."'Courses Offered'; return true".'">Courses Offered</a></li>';
			}
			if($currentLink == 'events'){
				$returnValue .= '<li class="current_li"><a href="events.php" onMouseOver="window.status='."'Ongoing Events'; return true".'">Ongoing Events</a></li>';
			} else {
				$returnValue .= '<li><a href="events.php" onMouseOver="window.status='."'Ongoing Events'; return true".'">Ongoing Events</a></li>';
			}
			if($currentLink == 'settings'){
				$returnValue .= '<li class="current_li"><a href="settings.php" onMouseOver="window.status='."'Change Password'; return true".'">Change Password</a></li>';
			} else {
				$returnValue .= '<li><a href="settings.php" onMouseOver="window.status='."'Change Password'; return true".'">Change Password</a></li>';
			}
			if($currentLink == 'logout'){
				$returnValue .= '<li class="current_li" onMouseOver="window.status='."'Logout'; return true".'"><a href="logout.php">Logout</a></li>';
			} else {
				$returnValue .= '<li><a href="logout.php" onMouseOver="window.status='."'Logout'; return true".'">Logout</a></li>';
			}
			$returnValue .=  '</ul></li></ul></div> </div>';
			return $returnValue;
		} elseif($designation=='teacher') {
		$returnValue .= '<ul><li><h2>Main Menu</h2><ul>';
			if($currentLink == 'profile'){
				$returnValue .= '<li class="current_li"><a href="profile.php" onMouseOver="window.status='."'View Profile'; return true".'">Profile</a></li>';
			} else {
				$returnValue .= '<li><a href="profile.php" onMouseOver="window.status='."'View Profile'; return true".'">Profile</a></li>';
			}
			if($currentLink == 'attendance'){
				$returnValue .= '<li class="current_li"><a href="attendance.php" onMouseOver="window.status='."'Student\'s Attendance'; return true".'">Attendance</a></li>';
			} else {
				$returnValue .= '<li><a href="attendance.php" onMouseOver="window.status='."'Student\'s Attendance'; return true".'">Attendance</a></li>';
			}
			if($currentLink == 'leaveApplication'){
				$returnValue .= '<li class="current_li"><a href="leaveApplication.php" onMouseOver="window.status='."'Leave Applications'; return true".'">Leave Application</a></li>';
			} else {
				$returnValue .= '<li><a href="leaveApplication.php" onMouseOver="window.status='."'Leave Applicaions'; return true".'">Leave Application</a></li>';
			}	 
			if($currentLink == 'feeStructure'){
				$returnValue .= '<li class="current_li"><a href="feeStructure.php" onMouseOver="window.status='."'Fee Structure'; return true".'">Fee Structure</a></li>';
			} else {
				$returnValue .= '<li><a href="feeStructure.php" onMouseOver="window.status='."'Fee Structure'; return true".'">Fee Structure</a></li>';
			}
			if($currentLink == 'library'){
				$returnValue .= '<li class="current_li"><a href="library.php" onMouseOver="window.status='."'View Library Details'; return true".'">Library</a></li>';
			} else {
				$returnValue .= '<li><a href="library.php" onMouseOver="window.status='."'View Library Details'; return true".'">Library</a></li>';
			}
			if($currentLink == 'salaryPlan'){
				$returnValue .= '<li class="current_li"><a href="salaryPlan.php" onMouseOver="window.status='."'View Salary Plan'; return true".'">Salary Plan</a></li>';
			} else {
				$returnValue .= '<li><a href="salaryPlan.php" onMouseOver="window.status='."'View Salary Plan'; return true".'">Salary Plan</a></li>';
			}	 
			if($currentLink == 'onlineMeeting'){
				$returnValue .= '<li class="current_li"><a href="onlineMeeting.php" onMouseOver="window.status='."'Online Meetings'; return true".'">Online Meeting</a></li>';
			} else {
				$returnValue .= '<li><a href="onlineMeeting.php" onMouseOver="window.status='."'Online Meetings'; return true".'">Online Meeting</a></li>';
			}	 
			if($currentLink == 'mailBox'){
				$returnValue .= '<li class="current_li"><a href="mailBox.php" onMouseOver="window.status='."'Mailbox'; return true".'">Mail Box</a></li>';
			} else {
				$returnValue .= '<li><a href="mailBox.php" onMouseOver="window.status='."'Mailbox'; return true".'">Mail Box</a></li>';
			}
			if($currentLink == 'performance'){
				$returnValue .= '<li class="current_li"><a href="performance.php" onMouseOver="window.status='."'Student\'s Performance'; return true".'">Performance</a></li>';
			} else {
				$returnValue .= '<li><a href="performance.php" onMouseOver="window.status='."'Student\'s Performace'; return true".'">Performance</a></li>';
			}
			if($currentLink == 'announcements'){
				$returnValue .= '<li class="current_li"><a href="announcements.php" onMouseOver="window.status='."'Important Announcements'; return true".'">Annoucements</a></li>';
			} else {
				$returnValue .= '<li><a href="announcements.php" onMouseOver="window.status='."'Important Annoucements'; return true".'">Annoucements</a></li>';
			}
			if($currentLink == 'students'){
				$returnValue .= '<li class="current_li"><a href="students.php" onMouseOver="window.status='."'Students'; return true".'">Students</a></li>';
			} else {
				$returnValue .= '<li><a href="students.php" onMouseOver="window.status='."'Students'; return true".'">Students</a></li>';
			}
			if($currentLink == 'faculty'){
				$returnValue .= '<li class="current_li"><a href="faculty.php" onMouseOver="window.status='."'Faculty'; return true".'">Faculty</a></li>';
			} else {
				$returnValue .= '<li><a href="faculty.php" onMouseOver="window.status='."'Faculty'; return true".'">Faculty</a></li>';
			}
			if($currentLink == 'courses'){
				$returnValue .= '<li class="current_li" onMouseOver="window.status='."'Courses Offered'; return true".'"><a href="courses.php">Courses Offered</a></li>';
			} else {
				$returnValue .= '<li><a href="courses.php" onMouseOver="window.status='."'Courses Offered'; return true".'">Courses Offered</a></li>';
			}
			if($currentLink == 'classUndertaken'){
				$returnValue .= '<li class="current_li"><a href="classUndertaken.php" onMouseOver="window.status='."'Timetable'; return true".'">Timetable</a></li>';
			} else {
				$returnValue .= '<li><a href="classUndertaken.php" onMouseOver="window.status='."'Timetable'; return true".'">Timetable</a></li>';
			}
			if($currentLink == 'events'){
				$returnValue .= '<li class="current_li"><a href="events.php" onMouseOver="window.status='."'Ongoing Events'; return true".'">Ongoing Events</a></li>';
			} else {
				$returnValue .= '<li><a href="events.php" onMouseOver="window.status='."'Ongoing Events'; return true".'">Ongoing Events</a></li>';
			}
			if($currentLink == 'settings'){
				$returnValue .= '<li class="current_li"><a href="settings.php" onMouseOver="window.status='."'Change Password'; return true".'">Change Password</a></li>';
			} else {
				$returnValue .= '<li><a href="settings.php" onMouseOver="window.status='."'Change Password'; return true".'">Change Password</a></li>';
			}
			if($currentLink == 'logout'){
				$returnValue .= '<li class="current_li"><a href="logout.php" onMouseOver="window.status='."'Logout'; return true".'">Logout</a></li>';
			} else {
				$returnValue .= '<li><a href="logout.php" onMouseOver="window.status='."'Logout'; return true".'">Logout</a></li>';
			}
			$returnValue .=  '</ul></li></ul></div> </div>';
			return $returnValue;
		} elseif($designation=='admin' || $designation=='principal'){
		$returnValue .= '<ul><li><h2>Admin Panel</h2><ul>';
			if($currentLink == 'profile'){
				$returnValue .= '<li class="current_li"><a href="profile.php" onMouseOver="window.status='."'View Profile'; return true".'">Profile</a></li>';
			} else {
				$returnValue .= '<li><a href="profile.php" onMouseOver="window.status='."'View Profile'; return true".'">Profile</a></li>';
			}
			if($currentLink == 'attendance'){
				$returnValue .= '<li class="current_li"><a href="attendance.php" onMouseOver="window.status='."'Attendance'; return true".'">Attendance</a></li>';
			} else {
				$returnValue .= '<li><a href="attendance.php" onMouseOver="window.status='."'Attendance'; return true".'">Attendance</a></li>';
			}
				 
			if($currentLink == 'salaryPlan'){
				$returnValue .= '<li class="current_li"><a href="salaryPlan.php" onMouseOver="window.status='."'Salary Plan'; return true".'">Salary Plan</a></li>';
			} else {
				$returnValue .= '<li><a href="salaryPlan.php" onMouseOver="window.status='."'Salary Plan'; return true".'">Salary Plan</a></li>';
			}	 
			if($currentLink == 'feeStructure'){
				$returnValue .= '<li class="current_li"><a href="feeStructure.php" onMouseOver="window.status='."'Fee Structure'; return true".'">Fee Structure</a></li>';
			} else {
				$returnValue .= '<li><a href="feeStructure.php" onMouseOver="window.status='."'Fee Structure'; return true".'">Fee Structure</a></li>';
			}	 
			if($currentLink == 'onlineMeeting'){
				$returnValue .= '<li class="current_li"><a href="onlineMeeting.php" onMouseOver="window.status='."'Online Meeting'; return true".'">Online Meeting</a></li>';
			} else {
				$returnValue .= '<li><a href="onlineMeeting.php" onMouseOver="window.status='."'Online Meeting'; return true".'">Online Meeting</a></li>';
			}	 
			if($currentLink == 'mailBox'){
				$returnValue .= '<li class="current_li"><a href="mailBox.php" onMouseOver="window.status='."'Mail Box'; return true".'">Mail Box</a></li>';
			} else {
				$returnValue .= '<li><a href="mailBox.php" onMouseOver="window.status='."'Mail Box'; return true".'">Mail Box</a></li>';
			}
			if($currentLink == 'performance'){
				$returnValue .= '<li class="current_li"><a href="performance.php" onMouseOver="window.status='."'Performance'; return true".'">Performance</a></li>';
			} else {
				$returnValue .= '<li><a href="performance.php" onMouseOver="window.status='."'Performance'; return true".'">Performance</a></li>';
			}
			if($currentLink == 'library'){
				$returnValue .= '<li class="current_li"><a href="library.php" onMouseOver="window.status='."'View Library Details'; return true".'">Library</a></li>';
			} else {
				$returnValue .= '<li><a href="library.php" onMouseOver="window.status='."'View Library Details'; return true".'">Library</a></li>';
			}
			if($currentLink == 'announcements'){
				$returnValue .= '<li class="current_li"><a href="announcements.php" onMouseOver="window.status='."'Announcements'; return true".'">Announcements</a></li>';
			} else {
				$returnValue .= '<li><a href="announcements.php" onMouseOver="window.status='."'Announcements'; return true".'">Announcements</a></li>';
			}
			if($currentLink == 'faculty'){
				$returnValue .= '<li class="current_li"><a href="faculty.php" onMouseOver="window.status='."'Faculty'; return true".'">Faculty</a></li>';
			} else {
				$returnValue .= '<li><a href="faculty.php" onMouseOver="window.status='."'Faculty'; return true".'">Faculty</a></li>';
			}
			if($currentLink == 'courses'){
				$returnValue .= '<li class="current_li"><a href="courses.php" onMouseOver="window.status='."'Courses'; return true".'">Courses</a></li>';
			} else {
				$returnValue .= '<li><a href="courses.php" onMouseOver="window.status='."'Courses'; return true".'">Courses</a></li>';
			}
			if($currentLink == 'events'){
				$returnValue .= '<li class="current_li"><a href="events.php" onMouseOver="window.status='."'Events'; return true".'">Events</a></li>';
			} else {
				$returnValue .= '<li><a href="events.php" onMouseOver="window.status='."'Events'; return true".'">Events</a></li>';
			}
			if($currentLink == 'settings'){
				$returnValue .= '<li class="current_li"><a href="settings.php" onMouseOver="window.status='."'Settings'; return true".'">Settings</a></li>';
			} else {
				$returnValue .= '<li><a href="settings.php" onMouseOver="window.status='."'Settings'; return true".'">Settings</a></li>';
			}
			if($currentLink == 'manageUsers'){
				$returnValue .= '<li class="current_li"><a href="manageUsers.php" onMouseOver="window.status='."'Manage Users'; return true".'">Manage Users</a></li>';
			} else {
				$returnValue .= '<li><a href="manageUsers.php" onMouseOver="window.status='."'Manage Users'; return true".'">Manage Users</a></li>';
			}
			if($currentLink == 'manageUserActivity'){
				$returnValue .= '<li class="current_li"><a href="manageUserActivities.php" onMouseOver="window.status='."'Manage User Activities'; return true".'">Manage User Activities</a></li>';
			} else {
				$returnValue .= '<li><a href="manageUserActivities.php" onMouseOver="window.status='."'Manage User Activities'; return true".'">Manage User Activities</a></li>';
			}
			if($currentLink == 'manageHelpContent'){
				$returnValue .= '<li class="current_li"><a href="manageHelpContent.php" onMouseOver="window.status='."'Manage Help content'; return true".'">Manage Help content</a></li>';
			} else {
				$returnValue .= '<li><a href="manageHelpContent.php" onMouseOver="window.status='."'Manage Help content'; return true".'">Manage Help content</a></li>';
			}
			if($currentLink == 'manageCourses'){
				$returnValue .= '<li class="current_li"><a href="manageCourses.php" onMouseOver="window.status='."'Manage Courses'; return true".'">Manage Courses</a></li>';
			} else {
				$returnValue .= '<li><a href="manageCourses.php" onMouseOver="window.status='."'Manage Courses'; return true".'">Manage Courses</a></li>';
			}
			if($currentLink == 'inventory'){
				$returnValue .= '<li class="current_li"><a href="inventory.php" onMouseOver="window.status='."'Inventory Management'; return true".'">Inventory Management</a></li>';
			} else {
				$returnValue .= '<li><a href="inventory.php" onMouseOver="window.status='."'Inventory Management'; return true".'">Inventory Management</a></li>';
			}
			if($currentLink == 'logout'){
				$returnValue .= '<li class="current_li"><a href="logout.php" onMouseOver="window.status='."'Logout'; return true".'">Logout</a></li>';
			} else {
				$returnValue .= '<li><a href="logout.php" onMouseOver="window.status='."'Logout'; return true".'">Logout</a></li>';
			}
			$returnValue .=  '</ul></li></ul></div> </div>';
			return $returnValue;
		} elseif($designation=='librarian') {
			if($currentLink == 'profile'){
				$returnValue .= '<li class="current_li"><a href="profile.php">Profile</a></li>';
			} else {
				$returnValue .= '<li><a href="profile.php">Profile</a></li>';
			}
			if($currentLink == 'library'){
                $returnValue .= '<li class="current_li"><a href="library.php">Library</a></li>';
			} else {
                $returnValue .= '<li><a href="library.php">Library</a></li>';
			}
			if($currentLink == 'salaryPlan'){
				$returnValue .= '<li class="current_li"><a href="salaryPlan.php">Salary Plan</a></li>';
			} else {
				$returnValue .= '<li><a href="salaryPlan.php">Salary Plan</a></li>';
			}	 
			if($currentLink == 'onlineMeeting'){
				$returnValue .= '<li class="current_li"><a href="onlineMeeting.php">Online Meeting</a></li>';
			} else {
				$returnValue .= '<li><a href="onlineMeeting.php">Online Meeting</a></li>';
			}	 
			if($currentLink == 'feeStructure'){
				$returnValue .= '<li class="current_li"><a href="feeStructure.php" onMouseOver="window.status='."'Fee Structure'; return true".'">Fee Structure</a></li>';
			} else {
				$returnValue .= '<li><a href="feeStructure.php" onMouseOver="window.status='."'Fee Structure'; return true".'">Fee Structure</a></li>';
			}	 
			if($currentLink == 'mailBox'){
				$returnValue .= '<li class="current_li"><a href="mailBox.php">Mail Box</a></li>';
			} else {
				$returnValue .= '<li><a href="mailBox.php">Mail Box</a></li>';
			}
			if($currentLink == 'announcements'){
				$returnValue .= '<li class="current_li"><a href="announcements.php">Announcements</a></li>';
			} else {
				$returnValue .= '<li><a href="announcements.php">Announcements</a></li>';
			}
			if($currentLink == 'faculty'){
				$returnValue .= '<li class="current_li"><a href="faculty.php">Faculty</a></li>';
			} else {
				$returnValue .= '<li><a href="faculty.php">Faculty</a></li>';
			}
			if($currentLink == 'courses'){
				$returnValue .= '<li class="current_li"><a href="courses.php">Courses</a></li>';
			} else {
				$returnValue .= '<li><a href="courses.php">Courses</a></li>';
			}
			if($currentLink == 'events'){
				$returnValue .= '<li class="current_li"><a href="events.php">Events</a></li>';
			} else {
				$returnValue .= '<li><a href="events.php">Events</a></li>';
			}
			if($currentLink == 'settings'){
				$returnValue .= '<li class="current_li"><a href="settings.php">Settings</a></li>';
			} else {
				$returnValue .= '<li><a href="settings.php">Settings</a></li>';
			}
			if($currentLink == 'logout'){
				$returnValue .= '<li class="current_li"><a href="logout.php">Logout</a></li>';
			} else {
				$returnValue .= '<li><a href="logout.php">Logout</a></li>';
			}
			$returnValue .=  '</ul></li></ul></div> </div>';
			return $returnValue;
		}
    }
	
	function roleDropdown($selectedRole) {
		$sessionUser = $_SESSION['username'];
		if($sessionUser == 'vinod') {
			$roleListQuery = "SELECT * FROM mst_table WHERE type_id='ROLE'";
		} else {
			$roleListQuery = "SELECT * FROM mst_table WHERE type_id='ROLE' AND value != 'admin'";
		}
		$roleListResult = mysql_query($roleListQuery);
		$returnValue = '<option value="select">Select ...</option>';
		while($line = mysql_fetch_array($roleListResult)){
			$id = $line['value'];
			$returnValue .= '<option value="'.$id.'"';
			if($id == $selectedRole){
				   $returnValue .= ' selected';
			}
			$returnValue .= '>'.$id.'</option>';
		}
		return $returnValue;
	}

	function standardDropdown($selectedStandard) {
		$roleListQuery = "SELECT * FROM mst_table WHERE type_id='STANDARD'";
		$roleListResult = mysql_query($roleListQuery);
		$returnValue = '<option value="select">Select ...</option>';
		while($line = mysql_fetch_array($roleListResult)){
			$id = $line['value'];
			$selected = ($id == $selectedStandard) ? 'selected': '';
			$returnValue .= "<option value=\"$id\" $selected>$id</option>";
		}
		return $returnValue;
	}
	
	function getFeeTypeDropdown($selectedStandard, $selectedFeeType) {
		$feeTypeQuery = "SELECT * FROM fee_structure WHERE standard = '$selectedStandard' AND admission_type = 'Present Students' ORDER BY type";
		$feeTypeResult = mysql_query($feeTypeQuery);
		$returnValue = '<option value="select">Select ...</option>';
		while($line = mysql_fetch_array($feeTypeResult)){
			$id = $line['id'];
			$returnValue .= '<option value="'.$id.'"';
			if($id == $selectedFeeType){
				$returnValue .= ' selected';
			}
			$returnValue .= '>'.$line['type'].'</option>';
		}
		return $returnValue;
	}

	function studentDropdown($selectedStandard, $selectedSection, $selectedStudent) {
		$userListQuery = "SELECT * FROM users WHERE standard = '$selectedStandard' AND designation = 'student'";
		$userListResult = mysql_query($userListQuery);
		$returnValue = '<option value="select">Select ...</option>';
		while($line = mysql_fetch_array($userListResult)){
			$id = $line['username'];
			$selected = ($id == $selectedStudent) ? 'selected':'';
			$returnValue .= "<option value=\"$id\" $selected>".$line['full_name']."</option>";
		}
		return $returnValue;
	}
	
	function getDynamicStandardDropdown($selectedStandard){
		$returnValue = '<form name="dynamicStandard" id="searchform1" method="GET">';
		$returnValue .= '<font class="font1">Select Standard: &nbsp;&nbsp;</font><select class="dynamicstandard" onchange="javascript:selectStandard();" name="standard">';
		$returnValue .= standardDropdown($selectedStandard);
		$returnValue .= '</select><br><br></form>';				
		return $returnValue;
	}
	
	function getDynamicStanStuDropdown($selectedStandard, $selectedStudent){
		$returnValue = '<form name="dynamicStandard" id="searchform1" method="GET">';
		$returnValue .= '<font class="font1">Select Standard: &nbsp;&nbsp;</font><select class="dynamicstandard" onchange="javascript:selectStandard();" name="standard">';
		$returnValue .= standardDropdown($selectedStandard);
		$returnValue .= '</select><br><br>';
		if($selectedStandard != null)
		{
			$returnValue .= '<font class="font1">Select Student: &nbsp;&nbsp;</font><select class="dynamicstudent" onchange="javascript:selectStudent();" name="student">';
			$returnValue .= studentDropdown($selectedStandard, $selectedSection, $selectedStudent);
			$returnValue .= '</select>';
		}
		$returnValue .= '</form>';				
		return $returnValue;
	}
	
	function studentTypeDropdown($selectedStudentType) {
		$studentTypeQuery = "SELECT * FROM mst_table WHERE type_id='STUDENTTYPE'";
		$studentTypeResult = mysql_query($studentTypeQuery);
		$returnValue = '<option value="select">Select ...</option>';
		while($line = mysql_fetch_array($studentTypeResult)){
			$id = $line['value'];
			$selected = ($id == $selectedStudentType) ? 'selected':'';
			$returnValue .= "<option value=\"$id\" $selected>$id</option>";
		}
		return $returnValue;
	}
	
	function feeTypeDropdown($selectedFeeType) {
		$feeTypeQuery = "SELECT * FROM mst_table WHERE type_id='FEEDURATION'";
		$feeTypeResult = mysql_query($feeTypeQuery);
		while($line = mysql_fetch_array($feeTypeResult)){
			$id = $line['value'];
			$selected = ($id == $selectedFeeType) ? 'selected' : '';
			$returnValue .= "<option value=\"$id\" $selected>$id</option>";
		}
		return $returnValue;
	}
	
	function getFeeCategoryDropdown($selectedFeeCategory)
	{
		$feeCategoryResults = mysql_query("SELECT DISTINCT category FROM fee_structure ORDER BY category ASC");
		while($line = mysql_fetch_array($feeCategoryResults)){
			$id = $line['category'];
			$selected = ($id == $selectedFeeCategory) ? 'selected' : '';
			$returnValue .= "<option value=\"$id\" $selected>$id</option>";
		}
		return $returnValue;
	}
	
	function userDropdown($selectedRole, $selectedUser) {
		$query = mysql_query("SELECT * FROM users WHERE designation='$selectedRole' ORDER BY full_name ASC");
		while($line = mysql_fetch_array($query)){
			$id = $line['username'];
			$value = $line['full_name'];
			$returnValue .= '<option value="'.$id.'"';
			if($id == $selectedUser){
				$returnValue .= ' selected';
			}
			$returnValue .='>'.$value.'</option>';
		}
		return $returnValue;
	}	
	
	function userActivities($selectedRole, $selectedUser) {
		$returnValue = '<form name="userActivityForm" id="searchform" method="POST">';
		$returnValue .= '<font class="font1">&emsp;&emsp;&emsp;Select Role: &nbsp;&nbsp;</font><select onchange="javascript:selectRole();" name="selRole">';
		$returnValue .= roleDropdown($selectedRole);
		$returnValue .= '</select><br><br>';
		if($selectedRole != null) {
			$returnValue .= '<font class="font1">&emsp;&emsp;&emsp;Select User: &nbsp;&nbsp;</font><select name="selUser">';
			$returnValue .= userDropdown($selectedRole, $selectedUser);
			$returnValue .= '</select>';
			$returnValue .= '<input type="submit" value="Show User Activity" name="submit" id="y" /></form><br>';
		}		
		return $returnValue;
	}
	
	function updateAttendanceCorrectly($student){
		$attendanceResults = mysql_query("SELECT * FROM attendance WHERE username = '$student'");
		while($line = mysql_fetch_array($attendanceResults)) {
			$username = $line['username'];
			$month = $line['month'];
			$year = $line['year'];
			$present = 0;
			$absent = 0;
			$leave = 0;
			for ($i = 1; $i <= 31; $i++) {
				$day = 'day'.$i;
				if ($line[$day] == 'PR') {
					$present ++;
				} elseif ($line[$day] == 'AB') {
					$absent++;
				} elseif ($line[$day] == 'VA') {
					$leave++;
				}
			}
			$workingDays = $present + $absent + $leave;
			$updateQuery = "UPDATE attendance SET days_present = '$present', days_absent = '$absent', days_leave = '$leave', working_days = '$workingDays' WHERE username = '$username' AND month = '$month' AND year = '$year'";
			mysql_query($updateQuery);
		
		}
	
	}
	
	
	
?>
