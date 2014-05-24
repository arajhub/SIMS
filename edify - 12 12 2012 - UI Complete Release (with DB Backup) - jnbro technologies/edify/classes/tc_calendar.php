<?php
	class tc_calendar{
		var $icon;
		var $objname;
		var $txt;
		var $date_format;
		var $year_display_from_current = 30;

		var $date_picker;
		var $path = '';

		var $day = 00;
		var $month = 00;
		var $year = 0000;

		var $width = 150;
		var $height = 205;

		var $year_start;
		var $year_end;

		var $startMonday = false;

		var $date_allow1;
		var $date_allow2;
		var $show_not_allow = false;

		var $auto_submit = false;
		var $form_container;
		var $target_url;

		//calendar constructor
		function tc_calendar($objname, $date_picker = false){
			$this->objname = $objname;
			$this->txt = "Select";
			$this->date_format = "Y-m-d";
			$this->date_picker = $date_picker;

			//set default year display from current year
			$thisyear = date('Y');
			$this->year_start = $thisyear-$this->year_display_from_current;
			$this->year_end = $thisyear+$this->year_display_from_current;
		}

		//check for leapyear
		function is_leapyear($year){
			return ($year % 4 == 0) ?
				!($year % 100 == 0 && $year % 400 <> 0)	: false;
		}

		//get the total day of each month in year
		function total_days($month,$year){
			$days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
			return ($month == 2 && $this->is_leapYear($year)) ? 29 : $days[$month-1];
		}

		function getDayNum($day){
			$headers = $this->getDayHeaders();
			return isset($headers[$day]) ? $headers[$day] : 0;
		}

		//get the day headers start from sunday till saturday
		function getDayHeaders(){
			if($this->startMonday)
				return array("1"=>"Mo", "2"=>"Tu", "3"=>"We", "4"=>"Th", "5"=>"Fr", "6"=>"Sa","7"=>"Su");
			else
				return array("7"=>"Su", "1"=>"Mo", "2"=>"Tu", "3"=>"We", "4"=>"Th", "5"=>"Fr", "6"=>"Sa");
		}

		function setIcon($icon){
			$this->icon = $icon;
		}

		function setText($txt){
			$this->txt = $txt;
		}

		function setDateFormat($format){
			$this->date_format = $format;
		}

		//set default selected date
		function setDate($day, $month, $year){
			$this->day = $day;
			$this->month = $month;
			$this->year = $year;
		}

		//specified location of the calendar_form.php
		function setPath($path){
			$last_char = substr($path, strlen($path)-1, strlen($path));
			if($last_char != "/") $path .= "/";
			$this->path = $path;
		}

		function writeScript(){
			$this->writeHidden();

			//check whether it is a date picker
			if($this->date_picker){
				$this->writeDay();
				$this->writeMonth();
				$this->writeYear();
				echo(" <a href=\"javascript:toggleCalendar('div_".$this->objname."');\">");
				if(is_file($this->icon)){
					echo("<img src=\"".$this->icon."\" id=\"tcbtn_".$this->objname."\" name=\"tcbtn_".$this->objname."\" border=\"0\" align=\"absmiddle\" />");
				}else echo($this->txt);
				echo("</a>");

				$div_display = "none";
				$iframe_position = "absolute";
				$dp=1;
			}else{
				$div_display = "block";
				$iframe_position = "relative";
				$dp=0;
			}

			$params = array();
			$params[] = "objname=".$this->objname;
			$params[] = "selected_day=".$this->day;
			$params[] = "selected_month=".$this->month;
			$params[] = "selected_year=".$this->year;
			$params[] = "year_start=".$this->year_start;
			$params[] = "year_end=".$this->year_end;
			$params[] = "dp=".$dp;
			$params[] = "mon=".$this->startMonday;
			$params[] = "da1=".$this->date_allow1;
			$params[] = "da2=".$this->date_allow2;
			$params[] = "sna=".$this->show_not_allow;

			$params[] = "aut=".$this->auto_submit;
			$params[] = "frm=".$this->form_container;
			$params[] = "tar=".$this->target_url;

			$paramStr = (sizeof($params)>0) ? "?".implode("&", $params) : "";

			//write the calendar container
			echo("<div id=\"div_".$this->objname."\" style=\"position: relative;display:".$div_display.";z-index:10000;\"><IFRAME id=\"".$this->objname."_frame\" style=\"DISPLAY:block; LEFT:0px; POSITION:".$iframe_position."; TOP:0px;\" src=\"".$this->path."calendar_form.php".$paramStr."\" frameBorder=\"0\" scrolling=\"no\" height=\"$this->height\" width=\"$this->width\"></IFRAME></div>");
		}

		//write the select box of days
		function writeDay(){
			echo("<select name=\"".$this->objname."_day\" id=\"".$this->objname."_day\" onChange=\"javascript:tc_setDay('".$this->objname."', this[this.selectedIndex].value, '$this->path');\" class=\"tcday\">");
			echo("<option value=\"00\">Day</option>");
			for($i=1; $i<=31; $i++){
				$selected = ((int)$this->day == $i) ? " selected" : "";
				echo("<option value=\"".str_pad($i, 2, "0", STR_PAD_LEFT)."\"$selected>".str_pad($i, 2, "0", STR_PAD_LEFT)."</option>");
			}
			echo("</select> ");
		}

		//write the select box of months
		function writeMonth(){
			echo("<select name=\"".$this->objname."_month\" id=\"".$this->objname."_month\" onChange=\"javascript:tc_setMonth('".$this->objname."', this[this.selectedIndex].value, '$this->path');\" class=\"tcmonth\">");
			echo("<option value=\"00\">Month</option>");

			$monthnames = $this->getMonthNames();
			for($i=1; $i<=sizeof($monthnames); $i++){
				$selected = ((int)$this->month == $i) ? " selected" : "";
				echo("<option value=\"".str_pad($i, 2, "0", STR_PAD_LEFT)."\"$selected>".$monthnames[$i-1]."</option>");
			}
			echo("</select> ");
		}

		//write the year textbox
		function writeYear(){
			
			echo("<select name=\"".$this->objname."_year\" id=\"".$this->objname."_year\" onChange=\"javascript:tc_setYear('".$this->objname."', this[this.selectedIndex].value, '$this->path');\" class=\"tcyear\">");
			


			$year_start = $this->year_start;
			$year_end = $this->year_end;
			
			if($year_start<$year_end)
			{
				echo("<option value=\"0000\">Year</option>");
			}

			//check year to be select in case of date_allow is set
			  if(!$this->show_not_allow && ($this->date_allow1 || $this->date_allow2)){
				if($this->date_allow1 && $this->date_allow2){
					$da1Time = strtotime($this->date_allow1);
					$da2Time = strtotime($this->date_allow2);

					if($da1Time < $da2Time){
						$year_start = date('Y', $da1Time);
						$year_end = date('Y', $da2Time);
					}else{
						$year_start = date('Y', $da2Time);
						$year_end = date('Y', $da1Time);
					}
				}elseif($this->date_allow1){
					//only date 1 specified
					$da1Time = strtotime($this->date_allow1);
					$year_start = date('Y', $da1Time);
				}elseif($this->date_allow2){
					//only date 2 specified
					$da2Time = strtotime($this->date_allow2);
					$year_end = date('Y', $da2Time);
				}
			  }

			for($i=$year_start; $i<=$year_end; $i++){
				$selected = ((int)$this->year == $i) ? " selected" : "";
				echo("<option value=\"$i\"$selected>$i</option>");
			}
			echo("</select> ");
		}

		//write hidden components
		function writeHidden(){
			$svalue = str_pad($this->year, 4, "0", STR_PAD_LEFT)."-".str_pad($this->month, 2, "0", STR_PAD_LEFT)."-".str_pad($this->day, 2, "0", STR_PAD_LEFT);
			echo("<input type=\"hidden\" name=\"".$this->objname."\" id=\"".$this->objname."\" value=\"$svalue\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_dp\" id=\"".$this->objname."_dp\" value=\"".$this->date_picker."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_year_start\" id=\"".$this->objname."_year_start\" value=\"".$this->year_start."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_year_end\" id=\"".$this->objname."_year_end\" value=\"".$this->year_end."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_mon\" id=\"".$this->objname."_mon\" value=\"".$this->startMonday."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_da1\" id=\"".$this->objname."_da1\" value=\"".$this->date_allow1."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_da2\" id=\"".$this->objname."_da2\" value=\"".$this->date_allow2."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_sna\" id=\"".$this->objname."_sna\" value=\"".$this->show_not_allow."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_aut\" id=\"".$this->objname."_aut\" value=\"".$this->auto_submit."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_frm\" id=\"".$this->objname."_frm\" value=\"".$this->form_container."\">");
			echo("<input type=\"hidden\" name=\"".$this->objname."_tar\" id=\"".$this->objname."_tar\" value=\"".$this->target_url."\">");
		}

		//set width of calendar
		function setWidth($width){
			if($width) $this->width = $width;
		}

		//set height of calendar
		function setHeight($height){
			if($height) $this->height = $height;
		}

		function setYearInterval($start, $end){
			$this->year_start = $start;
			$this->year_end = $end;
		}

		function getMonthNames(){
			return array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		}

		function startMonday($flag){
			$this->startMonday = $flag;
		}

		function dateAllow($from = "", $to = "", $show_not_allow = true){
			$this->date_allow1 = $from;
			$this->date_allow2 = $to;
			$this->show_not_allow = $show_not_allow;
		}

		function autoSubmit($auto, $form_name, $target = ""){
			$this->auto_submit = $auto;
			$this->form_container = $form_name;
			$this->target_url = $target;
		}

		function getDate(){
			return $this->year."-".str_pad($this->month, 2, "0", STR_PAD_LEFT)."-".str_pad($this->day, 2, "0", STR_PAD_LEFT);
		}
	}
?>