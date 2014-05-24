<?php
	/*$vars = array('DATE' => date("F d, Y"),
				'PLACE' => 'Bangalore',
				'NAME' => 'VINOD KUMAR DONTHI',
				'EXAMINATION' => 'PHP',
				'GRADE' => 'A+', );
	$new_rtf = rtfModifier($vars, "certificate.rtf");
	$fr = fopen('output.rtf', 'w') ;
	fwrite($fr, $new_rtf);
	fclose($fr);
	$username = 'vinod';
	$full_name = 'Mr. Vinod Kumar Donthi';
	$booksAndPeriodicals = 200;
	$basic = 15000;
	$vars = array('FULLNAME' => $full_name,
				'MONBOOKS' => $booksAndPeriodicals,
				'YEARBOOKS' => round($booksAndPeriodicals*12,2),
				'MONBASIC' => $basic,
				'YEARBASIC' => round($basic*12,2));
				
	$new_rtf = rtfModifier($vars, "salaryPlan.rtf");
	$fileName = $username.'_salaryPlan.rtf';
	$fr = fopen($fileName, 'w') ;
	fwrite($fr, $new_rtf);
	fclose($fr);*/

	function rtfModifier($vars, $rftfile) {
		//$xchange = array ('\\' => "\\\\", '{' => "\{", '}' => "\}");
		$document = file_get_contents($rftfile);
		if(!$document) {
			return false;
		}
		foreach($vars as $key=>$value) {
			$search = "%%".strtoupper($key)."%%";
			/*foreach($xchange as $orig => $replace) {
				$value = str_replace($orig, $replace, $value);
			}*/
			$document = str_replace($search, $value, $document);
		}
		return $document;
	}
?>