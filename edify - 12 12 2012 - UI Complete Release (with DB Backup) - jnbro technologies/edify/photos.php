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
	<title>Photo Gallery</title>

<link href="jstyle.css" media="screen" rel="stylesheet" type="text/css" />

       

</head>

<body>
<style type="text/css">
			.gallerycontroller{
				width: 250px
			}

			.gallerycontent{
				width: 400px;
				height: 250px;
				border: 2px solid black;
				background-color: #800000;
				padding: 3px;
				display: inline;
				float: center;
			}
		</style>

		<script type="text/javascript">
			var tickspeed = 3000 //ticker speed in miliseconds (2000=2 seconds)
			var displaymode = "auto" //displaymode ("auto" or "manual"). No need to modify as form at the bottom will control it, unless you wish to remove form.
			if (document.getElementById){
				document.write('<style type="text/css">\n')
				document.write('.gallerycontent{display:block;}\n')
				document.write('</style>\n')
			}
			var selectedDiv = 0
			var totalDivs = 0
			
			function getElementbyClass(classname){
				partscollect = new Array()
				var inc = 0
				var alltags = document.all? document.all.tags("DIV") : document.getElementsByTagName("*")
				for (i = 0; i < alltags.length; i++){
					if (alltags[i].className == classname)
					partscollect[inc++] = alltags[i]
				}
			}

			function contractall(){
				var inc=0
				while (partscollect[inc]){
					partscollect[inc].style.display="none"
					inc++
				}
			}

			function expandone(){
				var selectedDivObj=partscollect[selectedDiv]
				contractall()
				selectedDivObj.style.display="block"
				if (document.gallerycontrol)
					temp.options[selectedDiv].selected=true
					selectedDiv = (selectedDiv < totalDivs - 1)? selectedDiv + 1 : 0
				if (displaymode == "auto")
					autocontrolvar = setTimeout("expandone()",tickspeed)
			}

			function populatemenu(){
				temp=document.gallerycontrol.menu
				for (m = temp.options.length - 1; m > 0; m--)
					temp.options[m]=null
				for (i=0;i<totalDivs;i++){
					var thesubject=partscollect[i].getAttribute("subject")
					thesubject=(thesubject=="" || thesubject==null)? "HTML Content "+(i+1) : thesubject
					temp.options[i]=new Option(thesubject,"")
				}
				temp.options[0].selected=true
			}

			function manualcontrol(menuobj){
				if (displaymode=="manual"){
					selectedDiv=menuobj
					expandone()
				}
			}

			function preparemode(themode){
				displaymode=themode
				if (typeof autocontrolvar!="undefined")
					clearTimeout(autocontrolvar)
				if (themode=="auto"){
					document.gallerycontrol.menu.disabled=true
					autocontrolvar=setTimeout("expandone()",tickspeed)
				}
				else
					document.gallerycontrol.menu.disabled=false
			}

			function startgallery(){
				if (document.getElementById("controldiv")) //if it exists
					document.getElementById("controldiv").style.display="none"
				getElementbyClass("gallerycontent")
				totalDivs=partscollect.length
				if (document.gallerycontrol){
					populatemenu()
					if (document.gallerycontrol.mode){
						for (i=0; i<document.gallerycontrol.mode.length; i++){
							if (document.gallerycontrol.mode[i].checked)
								displaymode=document.gallerycontrol.mode[i].value
						}
					}
				}
				if (displaymode=="auto" && document.gallerycontrol)
					document.gallerycontrol.menu.disabled=true
				expandone()
			}

			if (window.addEventListener)
				window.addEventListener("load", startgallery, false)
			else if (window.attachEvent)
				window.attachEvent("onload", startgallery)
			else if (document.getElementById)
				window.onload=startgallery
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
				<p class="title">Photos
			
			  
				</p>
	  
	</div>
<?php

echo vmenu($designation);
?>
<div id="pagecontent">
  
      <div class="gallerycontent" subject="School main gate">
								<img src="./images/web-back9.JPG" alt="Angry face" width="400px" height="250px"/>
							</div>
							<div class="gallerycontent" subject="Playing Ground">
								<img src="./images/web-back8.JPG" alt="Angry face" width="400px" height="250px"/>
							</div>
							<div class="gallerycontent" subject="Playing Ground">
								<img src="./images/web-back7.JPG" alt="Angry face" width="400px" height="250px"/>
							</div>
							<div class="gallerycontent" subject="Playing Ground">
								<img src="./images/web-back6.GIF" alt="Angry face" width="400px" height="250px"/>
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
