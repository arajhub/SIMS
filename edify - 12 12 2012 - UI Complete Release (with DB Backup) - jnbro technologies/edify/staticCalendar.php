<?php

	function staticCalendar() {
		$calendar['current_day'] = date("d");
		$calendar['current_month'] = date("m");
		$calendar['current_year'] = date("y");
		$calendar['days_in_month'] = date("t",mktime(0,0,0,$calendar['current_month'],$calendar['current_day'],$calendar['current_year']));
		$calendar['month_year'] = date("F - Y",mktime(0,0,0,$calendar['current_month'],$calendar['current_day'],$calendar['current_year']));
		$calendar['weeks_in_month'] = date("w",mktime(0,0,0,$calendar['current_month'],1,$calendar['current_year']));
		$calendar['adj_starting_date'] = '&nbsp;';
		for($k=1;$k<=$calendar['weeks_in_month'] ;$k++){
			$calendar['adj_starting_date'] .= "<td>&nbsp;</td>";
		}
		$returnValue = "<table cellspacing='0' cellpadding='2' align=center width='200' border='0'>";
		$returnValue .= "<tr style='font-weight:bold;'><td>&nbsp;</td>";
		$returnValue .= "<td colspan=5 align='center' bgcolor='rgb(27,109,131)'><font color='white' size='2px'>".$calendar['month_year']."</font></td>";
		$returnValue .= "<td>&nbsp;</td></tr><tr>";
		$returnValue .= "<td colspan=7></td></tr><tr bgcolor='rgb(27,109,131)' align='center'>";
		$returnValue .= "<td><font size='2' color='white' face='Tahoma'>Sun</font></td>";
		$returnValue .= "<td><font size='2' color='white' face='Tahoma'>Mon</font></td>";
		$returnValue .= "<td><font size='2' color='white' face='Tahoma'>Tue</font></td>";
		$returnValue .= "<td><font size='2' color='white' face='Tahoma'>Wed</font></td>";
		$returnValue .= "<td><font size='2' color='white' face='Tahoma'>Thu</font></td>";
		$returnValue .= "<td><font size='2' color='white' face='Tahoma'>Fri</font></td>";
		$returnValue .= "<td><font size='2' color='white' face='Tahoma'>Sat</font></td>";
		$returnValue .= "</tr><tr style='font-weight:bold;' align='center'>";
		for($i=1;$i<=$calendar['days_in_month'];$i++){
			$returnValue .= $calendar['adj_starting_date']."<td valign=top><font size='2' color='rgb(27,109,131)' face='calibri'>".$i."<br>";
		    $returnValue .= "</font></td>";
			$calendar['adj_starting_date']='';
			$calendar['weeks_in_month'] ++;
			if($calendar['weeks_in_month']==7){
				$returnValue .= "</tr><tr style='font-weight:bold;' align='center'>";
				$calendar['weeks_in_month']=0;
			}
		}
		$returnValue .= "</tr></table>";
		
		return $returnValue;
	}

 ?>