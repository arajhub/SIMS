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
<title>Events</title>

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
<div id="pageheader" class="headergreywide">
				<p class="title">Event Calendar
			
			  
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
    <ul>
								<?php
									$originaldatetime = date("Y-m-d H:i:s");
									$time = 19800;
									$currentDate= strtotime($originaldatetime) + $time;
									$current_year = date("Y",$currentDate);
									$current_day = date("d",$currentDate);
									if(!$_GET) {
										$current_month = date("n",$currentDate);
									}
									else {
										$current_month = $_GET['month'];
									}
									$daysCount = cal_days_in_month(CAL_GREGORIAN,$current_month,$current_year);
									$eventsSearchQuery = "SELECT * FROM events where username='$username' and month='$current_month' and year='$current_year'";
									if($_POST) {
										$rowsPresent = mysql_num_rows(mysql_query($eventsSearchQuery));
										$eventsSearchResult = mysql_fetch_assoc(mysql_query($eventsSearchQuery));
										for($k = 1; $k <= $daysCount; $k++) {
											$columnName .= 'day'.$k.', ';
											$updateColumns .= 'day'.$k."='".stringReplacement($_POST[$k])."', ";
											$event = stringReplacement($_POST[$k]);
											$columnValue .= "'$event', ";
										}
										$columnName .= 'username, month, year';
										$columnValue .= "'$username', '$current_month', '$current_year'";
										$updateColumns = substr($updateColumns, 0, -2);
										if($rowsPresent != 0){
											$updateEventsQuery = "UPDATE events set $updateColumns WHERE username = '$username' AND month = '$current_month' AND year = '$current_year'";
											mysql_query($updateEventsQuery) or die ('Cannot insert into database due to some technical errors');
										} else {
											$insertEventsQuery = "INSERT INTO events ($columnName) VALUES ($columnValue)";
											mysql_query($insertEventsQuery) or die ('Cannot insert into database due to some technical errors');
										}
									}
									if($current_month == 1) {
										echo '<li class="current_page_item"><a href="events.php?month=1">Jan</a></li>';
									} else{
										echo '<li><a href="events.php?month=1">Jan</a></li>';
									}
									if($current_month == 2) {
										echo '<li class="current_page_item"><a href="events.php?month=2">Feb</a></li>';
									} else {
										echo '<li><a href="events.php?month=2">Feb</a></li>';
									}
									if($current_month == 3) {
										echo '<li class="current_page_item"><a href="events.php?month=3">Mar</a></li>';
									} else {
										echo '<li><a href="events.php?month=3">Mar</a></li>';
									}
									if($current_month == 4) {
										echo '<li class="current_page_item"><a href="events.php?month=4">Apr</a></li>';
									} else {
										echo '<li><a href="events.php?month=4">Apr</a></li>';
									}
									if($current_month == 5) {
										echo '<li class="current_page_item"><a href="events.php?month=5">May</a></li>';
									} else {
										echo '<li><a href="events.php?month=5">May</a></li>';
									}
									if($current_month == 6) {
										echo '<li class="current_page_item"><a href="events.php?month=6">Jun</a></li>';
									} else {
										echo '<li><a href="events.php?month=6">Jun</a></li>';
									}
									if($current_month == 7) {
										echo '<li class="current_page_item"><a href="events.php?month=7">Jul</a></li>';
									} else {
										echo '<li><a href="events.php?month=7">Jul</a></li>';
									}
									if($current_month == 8) {
										echo '<li class="current_page_item"><a href="events.php?month=8">Aug</a></li>';
									} else {
										echo '<li><a href="events.php?month=8">Aug</a></li>';
									}
									if($current_month == 9) {
										echo '<li class="current_page_item"><a href="events.php?month=9">Sep</a></li>';
									} else {
										echo '<li><a href="events.php?month=9">Sep</a></li>';
									}
									if($current_month == 10) {
										echo '<li class="current_page_item"><a href="events.php?month=10">Oct</a></li>';
									} else {
										echo '<li><a href="events.php?month=10">Oct</a></li>';
									}
									if($current_month == 11) {
										echo '<li class="current_page_item"><a href="events.php?month=11">Nov</a></li>';
									} else {
										echo '<li><a href="events.php?month=11">Nov</a></li>';
									}
									if($current_month == 12) {
										echo '<li class="current_page_item"><a href="events.php?month=12">Dec</a></li>';
									} else {
										echo '<li><a href="events.php?month=12">Dec</a></li>';
									}
								?>
							</ul>
							<?php
								$current_year = date("Y",$currentDate);
								$current_day = date("d",$currentDate);
								$daysCount = cal_days_in_month(CAL_GREGORIAN,$current_month,$current_year);
								$weeks_in_month = date("w",mktime(0,0,0,$current_month,1,$current_year));
								$dayArray = array("0"=>"Sun","1"=>"Mon","2"=>"Tue","3"=>"Wed","4"=>"Thu","5"=>"Fri","6"=>"Sat");
								$monthArray = array("1"=>"Jan","2"=>"Feb","3"=>"Mar","4"=>"Apr","5"=>"May","6"=>"Jun","7"=>"Jul","8"=>"Aug","9"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
								echo '<form name ="eventForm" action="events.php" method="post"><table class="tab_event">';
								echo '<tr>';
								echo '<td><tdcolspan=7></td></tr> ';
								
								echo '<tr>';
								echo '<td  class="tab_event_header"> Monday </td>';
								echo '<td  class="tab_event_header"> Tuesday </td>';
								echo '<td  class="tab_event_header"> Wednesday </td>';
								echo '<td  class="tab_event_header"> Thursday </td>';
								echo '<td  class="tab_event_header"> Friday </td>';
								echo '<td  class="tab_event_header"> Saturday </td>';
								echo '<td  class="tab_event_header"> Sunday </td>';
								echo '</tr>';
								$eventsSearchResult = mysql_fetch_assoc(mysql_query($eventsSearchQuery));
								
								echo '<tr>';
								$curcol=0;
								
								if($dayArray[$weeks_in_month]=='Tue')
								{
									echo '<td> </td>';
									$curcol++;
									
									}
									if($dayArray[$weeks_in_month]=='Wed')
								{
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									
									}
									if($dayArray[$weeks_in_month]=='Thu')
								{
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									
									}
									if($dayArray[$weeks_in_month]=='Fri')
								{
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									
									}
									if($dayArray[$weeks_in_month]=='Sat')
								{
									echo '<td> </td>';
									$curcol++;
										echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									
									}
									if($dayArray[$weeks_in_month]=='Sun')
								{
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
										echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									echo '<td> </td>';
									$curcol++;
									
									}
								for($k = 1; $k <= $daysCount; $k++) {
									$colName = 'day'.$k;
									if($eventsSearchResult[$colName])
									{
									echo '<td class="eventtab_highlight"  width="15%">';
									}
									else
									{
										echo '<td  width="15%">';
										}
									echo '<p><b>'.$k.'</b></p>';
									
									
									echo '<p><input type="text" size=10  name="'.$k.'" value="'.$eventsSearchResult[$colName].'"/></p></td>';
								
									$curcol++;
									if($curcol ==7)
									{
									echo '</tr> <tr>';
									$curcol =0;
									}
								
									if($weeks_in_month == 7){
										$weeks_in_month = 0;
									}
								}
									echo '</tr>';
								echo '<tr>';
								echo '<td align="right" colspan=7 ><input type="reset" id="z" value="Reset"name="reset"/>&nbsp;&nbsp;';
								echo '<input type="submit" id="z" value="Save"name="save"/></td></tr><tr /><tr /><tr />';
								echo '</table></form>';
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
