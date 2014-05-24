<?php
	
	function monthDropdown() {
		$dd = ' ';
		for ($i = 1; $i <= 12; $i++) {
			$dd .= '<option value="'.$i.'"';
			$mon = date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));
			$dd .= '>'.$mon.'</option>';
		}
		return $dd;
	}	
	
	function classDropdown($standard) {
		$standardArray = Array('Select...','LKG','UKG','I','II','III','IV','V','VI','VII','VIII','IX','X');
		for ($i = 0; $i < count($standardArray); $i++) {
			$returnValue .= '<option value="'.$standardArray[$i].'"';
			if($standardArray[$i] == $standard){
				$returnValue .= ' selected';
			}
			$returnValue .='>'.$standardArray[$i].'</option>';
		}
		return $returnValue;
	}
	
	function subjectList($standard){
		$query = mysql_query("SELECT * FROM ex_subjects WHERE standard='$standard' ORDER BY id ASC");
		while($line = mysql_fetch_array($query)){
			$currSubject = $line['sub_code'];
			$currSubjectDesc = $line['sub_desc'];
			$returnValue .= '<tr><td width="5%" class="td5"> </td><td width="50%" class="td5">'.$line['sub_code'].'&nbsp;-&nbsp;'.$line['sub_desc'].': </td>';
			$returnValue .= '<td width="40%" class="td5" style="align:right"><input type="number" size=10 maxlength=15 name="'.$line['sub_code'].'" /></td>';
			$returnValue .= '<td width="5%" class="td5">&nbsp;</td></tr>';
		}
		print_r($subjectArray);
		return $returnValue;
	}
	
	function studentsDropdown($standard='', $section='', $designation='', $username='',$selectedStudent) {
		if($designation == 'parent'){
			$query = mysql_query("SELECT username,full_name FROM users WHERE parent='$username' and designation='student' ORDER BY full_name ASC");
		} else {
			$query = mysql_query("SELECT username,full_name FROM users WHERE standard='$standard' and section='$section' and designation='student' ORDER BY full_name ASC");
		}
		while($line = mysql_fetch_array($query)){
			$id = $line['username'];
			$value = $line['full_name'];
			$returnValue .= '<option value="'.$id.'"';
			if($id == $selectedStudent){
				$returnValue .= ' selected';
			}
			$returnValue .='>'.$value.'</option>';
		}
		return $returnValue;
	}

	function getFormUpdateForAddPerform($designation,$standard,$section,$selectedStudent){		
		$returnValue = '<form name="performanceForm" id="searchform1" method="POST"><table width="100%">';
		$returnValue .= '<tr><td width="5%" class="td5"> </td>';
		$returnValue .= '<td width="90%" colspan=2 class="td5_1">Select Student and enter Examination Type</td>';
		$returnValue .= '<td width="5%" class="td5">&nbsp;</td></tr>';
		$returnValue .= '<tr><td class="td5" colspan=4></td></tr>';
		$returnValue .='<tr><td width="5%" class="td5">&nbsp;</td><td width="50%" class="td5">Select Month: </td>';
		$returnValue .= '<td width="40%" class="td5"><select name="selMonth">';
		$returnValue .= monthDropdown();
		$returnValue .= '</select> *</td><td width="5%" class="td5"> </td></tr>';
		$returnValue .='<tr><td width="5%" class="td5">&nbsp;</td><td width="50%" class="td5">Select Standard: </td>';
		$returnValue .= '<td width="40%" class="td5"><select onchange="javascript:selectStandard();" name="selStandard">';
		$returnValue .= classDropdown($standard);
		$returnValue .= '</select> *</td><td width="5%" class="td5"> </td></tr>';
		if($standard != null) {
			$returnValue .='<tr><td width="5%" class="td5">&nbsp;</td><td width="50%" class="td5">Select Student Name: </td>';
			$returnValue .= '<td width="40%" class="td5"><select name="selStudent">';
			$returnValue .= studentsDropdown($standard,$section);
			$returnValue .= '</select> *</td><td width="5%" class="td5"> </td></tr>';
			$returnValue .= '<tr><td width="5%" class="td5">&nbsp;</td><td width="50%" class="td5">Examination Type: </td>';
			$returnValue .= '<td width="40%" class="td5"><input type="text" size=20 maxlength=250 name="exam_type" /> *</td>';
			$returnValue .= '<td width="5%" class="td5">&nbsp;</td></tr>';
			$returnValue .= '<tr><td width="5%" class="td5"> </td><td width="90%" colspan=2 class="td5_1">Enter Marks Secured in each Subject :</td>';
			$returnValue .= '<td width="5%" class="td5">&nbsp;</td></tr>';
			$returnValue .= '<tr><td class="td5" colspan=4></td></tr>';
			$returnValue .= subjectList($standard);		
			$returnValue .= '<tr><td width="5%" class="td5">&nbsp;</td><td width="50%" class="td5">Total Marks of Examination: </td>';
			$returnValue .= '<td width="40%" class="td5"><input type="number" size=5 maxlength=10 name="ForTotalMarks" /> *</td>';
			$returnValue .= '<td width="5%" class="td5">&nbsp;</td></tr><tr /><tr /><tr /><tr />';
			$returnValue .= '<tr><td colspan=4><input style="margin-left:480px" type="submit" onClick="return checkAddPerformanceForm();" name="submitPerformance" value="Save Student Performance" id="z" /></td></tr>';
		}
		$returnValue .= '</table><br><br></form><br>';
		return $returnValue;
	}
	
	function getFormUpdateForPerform($designation,$standard,$username,$section,$selectedStudent){
		$returnValue = '<form name="performanceForm" id="searchform1" method="POST">';
		if($designation == 'parent'){
			$returnValue .= '<font class="font1">Select Student: &nbsp;&nbsp;</font><select name="selStudent">';
			$returnValue .= studentsDropdown($standard,$section,$designation,$username,$selectedStudent);
			$returnValue .= '</select>';
			$returnValue .= '<input type="submit" value="Get Performance" id="y" /></form><br>';
		} else {
			$returnValue .= '<font class="font1">Select Standard: &nbsp;&nbsp;</font><select onchange="javascript:selectStandard();" name="selStandard">';
			$returnValue .= classDropdown($standard);
			$returnValue .= '</select><br><br>';
			if($standard != null) {
				$returnValue .= '<font class="font1">Select Student: &nbsp;&nbsp;</font><select name="selStudent">';
				$returnValue .= studentsDropdown($standard,$section,$designation,$username,$selectedStudent);
				$returnValue .= '</select>';
				$returnValue .= '<input type="submit" value="Get Performance" style="margin-left:50px;" id="z" /></form><br>';
			}
		}
		
		return $returnValue;
	}
	
	###########################################################
	#########------- Marks Table and Bar Graph -------#########
	###########################################################
	
	function getMarks($selectedStudent){
		$userQuery = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$selectedStudent'"));
		$standard = $userQuery['standard'];
		$marksQuery = mysql_query("SELECT * FROM ex_marks where username='$selectedStudent' and standard='$standard' ORDER BY year, month ASC");
		$subjectsQuery = mysql_query("SELECT * FROM ex_subjects where standard='$standard' ORDER BY id ASC");
		$noOfSubjects = mysql_num_rows($subjectsQuery);
		$num_rows = mysql_num_rows($marksQuery);
		$tempQuery = "SELECT * FROM ex_subjects where standard='$standard' ORDER BY id ASC";
		$marks = '<br><p class="h2">Marks Secured in each Examination</p><br>';
		$marks .= '<p class="h3">Subject Wise Marks</p>';
		if ($num_rows > 0){
			$marks .= '<br><table cellspacing=0><tr><td width="3%"></td>';
			$marks .= '<td width="7%" class="tdSearchPerformHeader">Exam Type</td>';
			$columnWidth = 90/($noOfSubjects);
			while ($line = mysql_fetch_assoc($subjectsQuery)){
				$marks .= '<td width="'.$columnWidth.'%" class="tdSearchPerformHeader">'.$line['sub_code'].'</td>';
				$footer .= $line['sub_code'].'&nbsp;-&nbsp;'.$line['sub_desc'].',&nbsp;';
			}
			$marks .= '</tr>';
			$j = 0;
			while ($line = mysql_fetch_assoc($marksQuery)){
				$marks .= '<tr><td width="3%"> </td>';
				$marks .= '<td width="7%" class="tdSearchPerformance">'.$line['exam_type'].'</td>';
				for($i = 1; $i <= $noOfSubjects; $i++){
					$currSubject = 'subject'.$i;
					$marks .= '<td width="'.$columnWidth.'%" class="tdSearchPerformance">'.round($line[$currSubject],2).'</td>';
				}
				$marksSecureList[$j] = $line['markssecured'];
				$totalMarksList[$j] = $line['totalmarks'];
				$examTypeList[$j] = $line['exam_type'];
				$gradeList[$j] = $line['grade'];
				$percen = $line['markssecured']/$line['totalmarks']*100;
				$percentageList[$j] = round($percen,2);
				$j++;
				$marks .= '</tr>';
			}
			$marks .='</table><p class="note">* '.$footer.'</p><br><br>';
			$marks .= '<p class="h2">Exam Wise Total Marks</p>';
			$marks .= '<br><table style="align:center" width="100%" cellspacing=0><tr><td width="5%"></td>';
			$marks .= '<td width="30%" class="tdExamWiseMarksHeader">Exam Type</td>';
			$marks .= '<td width="15%" class="tdExamWiseMarksHeader">Total Marks of Examination</td>';
			$marks .= '<td width="15%" class="tdExamWiseMarksHeader">Total Marks Secured</td>';
			$marks .= '<td width="15%" class="tdExamWiseMarksHeader">Percentage</td>';
			$marks .= '<td width="15%" class="tdExamWiseMarksHeader">Grade</td>';
			$marks .='<td width="5%"></td></tr>';
			for($i = 0; $i < $j; $i++){
				$marks .= '<tr><td width="5%"></td>';
				$marks .= '<td width="30%" class="tdExamWiseMarks">'.$examTypeList[$i].'</td>';
				$marks .= '<td width="15%" class="tdExamWiseMarks">'.round($totalMarksList[$i],2).'</td>';
				$marks .= '<td width="15%" class="tdExamWiseMarks">'.round($marksSecureList[$i],2).'</td>';
				$marks .= '<td width="15%" class="tdExamWiseMarks">'.round($percentageList[$i],2).' %</td>';
				$marks .= '<td width="15%" class="tdExamWiseMarks">&nbsp;'.$gradeList[$i].'&nbsp;</td>';
				$marks .= '<td width="5%"></td></tr>';
			}
			$marks .= '</table><br><br>';
			
			$i = 0;
			while ($line = mysql_fetch_assoc($marksDetails)){
				$examType[$i] = $line['exam_type'];
				$percen = $line['TotalMarksSecured']/$line['ForTotalMarks']*100;
				$percentage[$i] = round($percen,2);
				$i = $i + 1;
			}

			$img_width=720;
			$img_height=400;
			$margins=22;

			# ---- Find the size of graph by substracting the size of borders
			$graph_width=$img_width - $margins * 2;
			$graph_height=$img_height - $margins * 2;
			$img=imagecreate($img_width,$img_height);
			$performImgExten = '_performance.png';
			$performImgFileName = $selectedStudent.$performImgExten;

			$bar_width=20;
			$total_bars=$num_rows;
			$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);

			# -------  Define Colors ----------------
			$bar_color=imagecolorallocate($img,50,50,230);
			$background_color=imagecolorallocate($img,222,222,222);
			$border_color=imagecolorallocate($img,255,255,255);
			$line_color=imagecolorallocate($img,230,230,230);
			$line_color2=imagecolorallocate($img,255,255,255);

			# ------ Create the border around the graph ------

			imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
			imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);

			# ------- Max value is required to adjust the scale	-------
			$max_value=100;
			$ratio= $graph_height/$max_value;

			# -------- Create scale and draw horizontal lines  --------
			$horizontal_lines=20;
			$horizontal_gap=$graph_height/$horizontal_lines;

			for($i=1;$i<=$horizontal_lines;$i++){
				$y=$img_height - $margins - $horizontal_gap * $i ;
				imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
				$v=intval($horizontal_gap * $i /$ratio);
				imagestring($img,0,5,$y-5,$v,$bar_color);
			}

			# ----------- Draw the bars here ------
			for($i=0;$i< $total_bars; $i++){
				# ------ Extract key and value pair from the current pointer position
				$key = $examTypeList[$i];
				$value = $percentageList[$i];
				//list($key,$value)=each($values);

				$x1= $margins + $gap + $i * ($gap+$bar_width) ;
				$x2= $x1 + $bar_width;
				$y1=$margins +$graph_height- intval($value * $ratio) ;
				$y2=$img_height-$margins;
				imagestring($img,0,$x1+1,$img_height-15,$key,$bar_color);
				imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
				if($x3 != null){
					$x4 = $x1 + $bar_width/2;
					$y4 = $y1;
					imageline($img,$x3,$y3,$x4,$y4,$line_color2);
				}
				imagestring($img,1,$x1-1,$y1-10,$value,$bar_color);
				$x3 = $x1 + $bar_width/2;
				$y3 = $y1;
			}
			imagepng($img,$performImgFileName);
			$imageCaption = '<p class="h2">Performance Graphs</p><br><p class="h3">Student Performance - Bar Graph</p><br><center><img src="'.$performImgFileName.'" /></center>';
			
		} else {
			$marks .='<p class="perDetails">No records found ...</p><br>';
		}
		return $marks.$imageCaption;
	}
	
	function getClassBarGraph ($standard){
		$avgExamsQuery = "SELECT DISTINCT exam_type from ex_marks where standard='$standard'";
		$averageQuery = "SELECT ROUND(SUM(totalmarks)/count(*),2) Average, exam_type, totalmarks, round(sum(markssecured)*100/(count(*)*totalmarks),2) Percentage FROM ex_marks WHERE standard='$standard' GROUP BY exam_type ORDER BY year, month ASC;";
		$averageDetails = mysql_query($averageQuery);

		$examCountResults = mysql_num_rows(mysql_query($avgExamsQuery));

		if($examCountResults > 0){
			$i = 0;
			while ($line = mysql_fetch_assoc($averageDetails)){
				$examType[$i] = $line['exam_type'];
				$percentage[$i] = $line['Percentage'];
				$i = $i + 1;
			}

			$img_width=720;
			$img_height=400;
			$margins=22;

			$graph_width=$img_width - $margins * 2;
			$graph_height=$img_height - $margins * 2;
			$img=imagecreate($img_width,$img_height);
			$performImgExten = '_performance.png';
			$performImgFileName = 'Class_'.$standard.$performImgExten;

			$bar_width=20;
			$total_bars=$examCountResults;
			$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);

			$bar_color=imagecolorallocate($img,50,50,230);
			$background_color=imagecolorallocate($img,222,222,222);
			$border_color=imagecolorallocate($img,255,255,255);
			$line_color=imagecolorallocate($img,230,230,230);
			$line_color2=imagecolorallocate($img,255,255,255);

			imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
			imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);

			$max_value=100;
			$ratio= $graph_height/$max_value;

			$horizontal_lines=20;
			$horizontal_gap=$graph_height/$horizontal_lines;

			for($i=1;$i<=$horizontal_lines;$i++){
				$y=$img_height - $margins - $horizontal_gap * $i ;
				imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
				$v=intval($horizontal_gap * $i /$ratio);
				imagestring($img,0,5,$y-5,$v,$bar_color);
			}

			for($i=0;$i< $total_bars; $i++){
				# ------ Extract key and value pair from the current pointer position
				$key = $examType[$i];
				$value = round($percentage[$i],2).'%';
				$x1= $margins + $gap + $i * ($gap+$bar_width) ;
				$x2= $x1 + $bar_width;
				$y1=$margins +$graph_height- intval($value * $ratio) ;
				$y2=$img_height-$margins;
				imagestring($img,0,$x1+1,$img_height-15,$key,$bar_color);
				imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
				if($x3 != null){
					$x4 = $x1 + $bar_width/2;
					$y4 = $y1;
					imageline($img,$x3,$y3,$x4,$y4,$line_color2);
				}
				imagestring($img,2,$x1-1,$y1-15,$value,$bar_color);
				$x3 = $x1 + $bar_width/2;
				$y3 = $y1;
			}
			imagepng($img,$performImgFileName);
			$imageCaption = '<br><br><p class="h3">Class Average Performance - Bar Graph</p><br><center><img src="'.$performImgFileName.'" /></center>';
			return $imageCaption;
		}
	}
		
	####################################################
	#########------- Pie Chart Creation -------#########
	####################################################
	
	function getClassPieChart($standard, $exam_type) {		
		# ------- Data for Pie Chart ------- #
		//$gradingSystemArray = array();
		$gradingSystem = mysql_query("SELECT * FROM mst_table WHERE type_id = 'GRADE' ORDER BY subvalue ASC");
		while($line = mysql_fetch_assoc($gradingSystem)) {
			$arrayName = $line['value'];
			$gradingSystemArray[$arrayName] = $line['subvalue'];
		}
		$A1GradeMarks = array_search('A1',$gradingSystemArray);
		$A2GradeMarks = array_search('A2',$gradingSystemArray);
		$B1GradeMarks = array_search('B1',$gradingSystemArray);
		$B2GradeMarks = array_search('B2',$gradingSystemArray);
		$C1GradeMarks = array_search('C1',$gradingSystemArray);
		$C2GradeMarks = array_search('C2',$gradingSystemArray);
		$DGradeMarks = array_search('D',$gradingSystemArray);
		$E1GradeMarks = array_search('E1',$gradingSystemArray);
		$E2GradeMarks = array_search('E2',$gradingSystemArray);
		
		# ------- Students who did not attend the examination ------- #
		$notAttendedStudentsQuery = "SELECT count(*) count FROM user_profile WHERE standard='$standard' and username not in (SELECT username from ex_marks WHERE standard = '$standard')";
		
		$notAttended = mysql_fetch_assoc(mysql_query($notAttendedStudentsQuery));
		
		# ------- Calculate Percentage acquired by each student in the given Examination ------- #
		$percentageQuery = "SELECT ROUND((sum(markssecured)*100/sum(totalmarks)),2) Percentage FROM ex_marks WHERE standard = '$standard' GROUP BY username";
		$percentageDetails = mysql_query($percentageQuery);
		
		# ------- Data Variables - Initialization and Calculation ------- #
		$A1Grade = 0;
		$A2Grade = 0;
		$B1Grade = 0;
		$B2Grade = 0;
		$C1Grade = 0;
		$C2Grade = 0;
		$DGrade = 0;
		$E1Grade = 0;
		$E2Grade = 0;
		
		while($line = mysql_fetch_assoc($percentageDetails)) {
			$currentPercentage = $line['Percentage'];
			if ($currentPercentage >= $A1GradeMarks) {
				$A1Grade++;
			} else if ($currentPercentage >= $A2GradeMarks) {
				$A2Grade++;
			} else if ($currentPercentage >= $B1GradeMarks) {
				$B1Grade++;
			} else if ($currentPercentage >= $B2GradeMarks) {
				$B2Grade++;
			} else if ($currentPercentage >= $C1GradeMarks) {
				$C1Grade++;
			} else if ($currentPercentage >= $C2GradeMarks) {
				$C2Grade++;
			} else if ($currentPercentage >= $DGradeMarks) {
				$DGrade++;
			} else if ($currentPercentage >= $E1GradeMarks) {
				$E1Grade++;
			} else if ($currentPercentage >= $E2GradeMarks) {
				$E2Grade++;
			}
		}
		
		# ------- Image File Name Initialization ------- #
		$imageExt = '.jpg';
		$imageName = $standard.$imageExt;
		
		# ------- Variable Initialization ------- #
		$img_width = 720; // Image Width
		$img_height = 430; // Image Height
		$margins = 3; // Margins for the Image
		$shadow_height = 0; // Height on Shadow.
		$shadow_dark = true; // true = darker shadow, false = lighter shadow...
		$diameterX = 320; // X-Diameter of the Pie Diagram
		$diameterY = 320;  // Y-Diameter of the Pie Diagram
		$centerX = $diameterX/2 + 50; // X-Coordinate of Center of the Pie Diagram
		$centerY = $img_height/2 - 5; // Y-Coordinate of Center of the Pie Diagram
		$label_place = 50; // Y-Coordinate of the Label
		$label_xcoordinate = $img_width - 200; // X-Coordinate of the Label
		

		$myImage = imagecreate($img_width,$img_height);

		# -------  Define Colors ------- #
		$bar_color = imagecolorallocate($myImage,0,0,0);
		$background_color = imagecolorallocate($myImage,225,225,225);
		$border_color = imagecolorallocate($myImage,225,225,225);
		$line_color = imagecolorallocate($myImage,000,0,0);
		$line_color2 = imagecolorallocate($myImage,255,255,255);
		$text_color = '000000'; // text-color.
		$colors = array('0000FF', '00CCFF', '00FFFF', '00FFCC', '00FF00', 'CCFF00', 'CCCC00', 'FF0000', 'CC00CC', 'FFFFFF'); // colors of the slices.
	
		foreach ($colors as $colorkode) {
			$fill_color[] = colorHex($myImage, $colorkode);
			$shadow_color[] = colorHexshadow($myImage, $colorkode, $shadow_dark);
		}

		$white = ImageColorAllocate ($myImage, 255, 255, 255);
		$red  = ImageColorAllocate ($myImage, 255, 0, 0);
		$green = ImageColorAllocate ($myImage, 0, 255, 0);
		$blue = ImageColorAllocate ($myImage, 0, 0, 255);
		$lt_red = ImageColorAllocate($myImage, 255, 150, 150);
		$lt_green = ImageColorAllocate($myImage, 150, 255, 150);
		$lt_blue = ImageColorAllocate($myImage, 150, 150, 255);
		
		# ------- Create the border around the graph ------- #
		imagefilledrectangle($myImage,1,1,$img_width-2,$img_height-2,$border_color);
		imagefilledrectangle($myImage,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
		
		# ------- Label Variables - Initialization ------- #
		$label = 'A1 Grade*A2 Grade*B1 Grade*B2 Grade*C1 Grade*C2 Grade*D Grade*E1 Grarde*E2 Grade*Not Attended';
		$data[0] = $A1Grade;
		$data[1] = $A2Grade;
		$data[2] = $B1Grade;
		$data[3] = $B2Grade;
		$data[4] = $C1Grade;
		$data[5] = $C2Grade;
		$data[6] = $DGrade;
		$data[7] = $E1Grade;
		$data[8] = $E2Grade;
		$data[9] = $notAttended['count'];
		$label = explode('*',$label);
		//print_r($data);
		for ($i = 0; $i < count($label); $i++) {
			if ($data[$i]/array_sum($data) < 0.1) 
				$number[$i] = ' '.number_format(($data[$i]/array_sum($data))*100,1,'.','.').'%';
			else 
				$number[$i] = number_format(($data[$i]/array_sum($data))*100,1,'.','.').'%';
		}
		//print_r($number);
		//print_r($label);

		# ------- Label Variables - Include in Main Image ------- #
		for ($i = 0; $i < count($label); $i++) {

			if ($data[$i] > 0){
				imagefilledrectangle($myImage,$label_xcoordinate,$label_place,$label_xcoordinate+20,$label_place+10,colorHex($myImage, $colors[$i % count($colors)]));
				imagerectangle($myImage,$label_xcoordinate,$label_place,$label_xcoordinate+20,$label_place+10,colorHex($myImage, $bar_color));
				//$data[$i];
				$label_output = $number[$i].'  ';
				$label_output = $label_output.$label[$i];
			
				imagestring($myImage,'2',$label_xcoordinate+35,$label_place,$label_output,$bar_color);
				$label_output = '';
			
				$label_place = $label_place + 15;
			}
		}
		
		$data_sum = array_sum($data);
		
		$start = 270;

		for ($i = 0; $i < count($data); $i++) {
			$value += $data[$i];
			$end = ceil(($value/$data_sum)*360) + 270;
			$slice[] = array($start, $end, $shadow_color[$value_counter % count($shadow_color)], $fill_color[$value_counter % count($fill_color)]);
			$start = $end;
			$value_counter++;
		}

		for ($i = $centerY + $shadow_height; $i > $centerY; $i--) {
			for ($j = 0; $j < count($slice); $j++) {
				if ($slice[$j][0] != $slice[$j][1]) ImageFilledArc($myImage, $centerX, $i, $diameterX, $diameterY, $slice[$j][0], $slice[$j][1], $slice[$j][2], IMG_ARC_PIE);
			}
		}	

		for ($j = 0; $j < count($slice); $j++) {
			if ($slice[$j][0] != $slice[$j][1]) ImageFilledArc($myImage, $centerX, $centerY, $diameterX, $diameterY, $slice[$j][0], $slice[$j][1], $slice[$j][3], IMG_ARC_PIE);
		}
		
		imagepng($myImage,$imageName);
		$returnValue = '<br><p class="h2">Overall Grades - Pie Chart</p><br><center><img src="'.$imageName.'" /></center><br>';
		imagedestroy($myImage);
		
		return $returnValue;
	}
	
	function getGradeForGivenPercentage($currentPercentage){
		$gradingSystem = mysql_query("SELECT * FROM mst_table WHERE type_id = 'GRADE' ORDER BY subvalue ASC");
		while($line = mysql_fetch_assoc($gradingSystem)) {
			$arrayName = $line['value'];
			$gradingSystemArray[$arrayName] = $line['subvalue'];
		}
		$A1GradeMarks = array_search('A1',$gradingSystemArray);
		$A2GradeMarks = array_search('A2',$gradingSystemArray);
		$B1GradeMarks = array_search('B1',$gradingSystemArray);
		$B2GradeMarks = array_search('B2',$gradingSystemArray);
		$C1GradeMarks = array_search('C1',$gradingSystemArray);
		$C2GradeMarks = array_search('C2',$gradingSystemArray);
		$DGradeMarks = array_search('D',$gradingSystemArray);
		$E1GradeMarks = array_search('E1',$gradingSystemArray);
		$E2GradeMarks = array_search('E2',$gradingSystemArray);
		
		if ($currentPercentage >= $A1GradeMarks) {
			return 'A1';
		} else if ($currentPercentage >= $A2GradeMarks) {
			return 'A2';
		} else if ($currentPercentage >= $B1GradeMarks) {
			return 'B1';
		} else if ($currentPercentage >= $B2GradeMarks) {
			return 'B2';
		} else if ($currentPercentage >= $C1GradeMarks) {
			return 'C1';
		} else if ($currentPercentage >= $C2GradeMarks) {
			return 'C2';
		} else if ($currentPercentage >= $DGradeMarks) {
			return 'D';
		} else if ($currentPercentage >= $E1GradeMarks) {
			return 'E1';
		} else if ($currentPercentage >= $E2GradeMarks) {
			return 'E2';
		} else {
			return 'F';
		}
	}
?>