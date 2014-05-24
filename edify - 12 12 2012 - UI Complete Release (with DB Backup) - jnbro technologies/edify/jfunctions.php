<?php
function loginbox(){

include 'index.php';
}

function vmenu($designation){
	
	 
$returnvalue ='<div id="vertmenu" align="right">';
$returnvalue .='<ul id="vmenu" >';
if($designation=='admin' || $designation=='principal' || $designation=='teacher')
{
$returnvalue .='	 <li>   <a class="dashboard"  href="dashboard.php"> <span>Dashboard</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="myprofile" href="profile.php"> <span>MyProfile</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="academics" href="academics-menu.php"> <span>Academics</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="official" href="official.php"> <span>Official</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="manage" href="manage.php"> <span>Manage</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="settings" href="settings-menu.php"> <span>Settings</span>        </a>    </li>';
 }  
 
 if($designation=='student')
{
$returnvalue .='	 <li>   <a class="dashboard"  href="dashboard.php"> <span>Dashboard</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="myprofile" href="profile.php"> <span>My Profile</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="academics" href="academics-menu.php"> <span>Academics</span>        </a>    </li>';

$returnvalue .='	 <li>   <a class="manage" href="manage.php"> <span>Manage</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="settings" href="settings-menu.php"> <span>Settings</span>        </a>    </li>';
 }  
 
  if($designation=='parent')
{
$returnvalue .='	 <li>   <a class="dashboard"  href="dashboard.php"> <span>Dashboard</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="myprofile" href="profile.php"> <span>My Profile</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="academics" href="academics-menu.php"> <span>Academics</span>        </a>    </li>';


$returnvalue .='	 <li>   <a class="settings" href="settings-menu.php"> <span>Settings</span>        </a>    </li>';
 } 
 
 if($designation=='librarian')
{
$returnvalue .='	 <li>   <a class="dashboard"  href="dashboard.php"> <span>Dashboard</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="myprofile" href="profile.php"> <span>My Profile</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="academics" href="academics-menu.php"> <span>Academics</span>        </a>    </li>';
$returnvalue .='	 <li>   <a class="official" href="official.php"> <span>Official</span>        </a>    </li>';

$returnvalue .='	 <li>   <a class="settings" href="settings-menu.php"> <span>Settings</span>        </a>    </li>';
 } 
  
$returnvalue .=' </ul>';

$returnvalue .=' </div>';

return $returnvalue;

}
function loadtheme(){
	$uname = $_SESSION['username'];
	if($uname)
	{
	$databaseQuery = 'SELECT * FROM themepreferences WHERE username="'.$uname.'"';
	$result = mysql_query($databaseQuery) or die('Query failed: ' . mysql_error());
	$returntext="";
	while($row = mysql_fetch_array($result))
  {
 $themeid=$row['themeid'];
 $backimg=$row['backgroundimage'];
$_SESSION['themeid']=$themeid;
$_SESSION['backimg']=$backimg;
 
  }
  if($themeid)
  {
	  echo '<link href="'.$themeid.'.css" rel="stylesheet" type="text/css" />';
	  
	  }
	  else
	  {
		  echo '<link href="Basic_Html.css" rel="stylesheet" type="text/css" />';
		  }
  
 echo "<script language=\"JavaScript1.2\">\n";
    echo "<!--\n";
	    echo "if (document.all||document.getElementById) \n";
		
		if(($backimg != null) && ($themeid != "Basic_Html"))
		{
   echo "document.body.style.background=\"url('jimages/backs/" .$backimg. ".jpg') white center no-repeat fixed\"\n";
		}
		else
		{
		  echo "document.body.style.background=\"url('jimages/bg.png') white center repeat fixed\"\n";	
			}
    echo "//-->\n";
    echo "</script>  \n";
	}
}
function rightbar()
{
	 $username = $_SESSION['username'];
	$imageFileExten = '.jpg';
			$imageFileName = $username.$imageFileExten;
echo '<div id="rightsidebar">';
echo '<div id="rightsidebarbutton">';
echo '<div id="rightico" alt="" > </div>';
echo '</div>';
echo '<div id="rightsidebarcontent">';
echo '<div id="profile"  align="center">';
$filename='profilePhotos/'.$imageFileName;
if (file_exists($filename)) {
    echo '<img id="ProfilePicture" src=profilePhotos/'.$imageFileName.'  width="150" height="190" alt="ProfilePicture" align="center" />';
} else {
    echo '<img id="ProfilePicture" src=profilePhotos/profilepicture.png  width="150" height="190" alt="ProfilePicture" align="center" />';
}

echo '<p class="text1" id="profileinfo">'.$username.'</p>';
	echo '</div>';
	echo '<div>';
echo '<h2>Calendar</h2>';
						
							echo staticCalendar();

echo '</div>';
echo '<div ID="clock">';
echo '</div>';
echo '</div>';

echo '</div>';
}

	
	
function searchbox()
{ return '<link rel="stylesheet" href="searchreset.css" type="text/css" media="screen, projection" />
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript">
$().ready(function() {
	// if text input field value is not empty show the "X" button
	$("#s").keyup(function() {
		$("#x").fadeIn();
		if ($.trim($("#s").val()) == "") {
			$("#x").fadeOut();
		}
		
	});
	$("#s").click(function() {
		if($("#s").val()=="Search People")
		{
			$("#s").val("");
			}
		
	});
	// on click of "X", delete input field value and hide "X"
	$("#x").click(function() {
		$("#s").val("");
		$(this).hide();
	});
});
</script>

<div id="searchContainer" align="center">
<form id="searchform" method="get" action="peopleSearch.php">
		<input type="text"  name="name" size="20" id="s" value="Search People" />
		<div id="delete"><span id="x">x</span></div>
		<input type="submit"  value="Search" id="searchsubmit" />
</form>';
	}
	
function smallprofilebox($uname , $fulldesg=null)
{
//	echo $uname;
	$returnValue .='<div class="miniprofile">    ';
	
$username = $uname;
 $userDetailsQuery = "SELECT * FROM user_profile WHERE username='".$username."'";
	      
	        $userDetailsResult = mysql_fetch_assoc(mysql_query($userDetailsQuery));
			
			 $fname = $userDetailsResult['first'];
            if(strlen($userDetailsResult['middle']) > 1) {
                $fname .= ' '.$userDetailsResult['middle'];
            }
           $fname .= ' '.$userDetailsResult['last'];



$desig=$userDetailsResult['designation'];
if($fulldesg)
{
	
	$desig=$desig." - ".$fulldesg;
}

	$imageFileExten = '.jpg';
			$imageFileName = $username.$imageFileExten;
$filename='profilePhotos/'.$imageFileName;
$returnValue .='';
if (file_exists($filename)) {
 $returnValue .= '<img  src=profilePhotos/'.$imageFileName.'  width="50" height="57" alt="Avatar" align="center" />';
} else {
   $returnValue .='<img src=profilePhotos/profilepicture.png  width="50" height="57" alt="Avatar" align="center" />';
}


$returnValue .='<p style="float:left; width:150px; overflow:hidden;"> <a href="profile.php?id='.$uname.'" style="float:left;">'.$fname.'</a>  ';
$returnValue .='<p><br/>'.$desig.'<br/></p>  </p>';
$returnValue .='</div>    ';

return $returnValue;
	
	}
?>