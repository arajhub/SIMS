<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Search</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="description" content="Google Search" />
<link rel="stylesheet" href="http://meyerweb.com/eric/tools/css/reset/reset.css" type="text/css" media="screen, projection" />
<style>
/* div container containing the form  */


/* Style the search input field. */



</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
<script type="text/javascript">
$().ready(function() {
	// if text input field value is not empty show the "X" button
	$("#s").keyup(function() {
		$("#x").fadeIn();
		if ($.trim($("#s").val()) == "") {
			$("#x").fadeOut();
		}
	});
	// on click of "X", delete input field value and hide "X"
	$("#x").click(function() {
		$("#s").val("");
		$(this).hide();
	});
});
</script>
</head>
<body>
<div id="searchContainer" align="center">
<form id="searchform" method="post" action="peopleSearch.php">
		<input type="text"  name="name" size="20" id="s" value="Search People" />
		<div id="delete"><span id="x">x</span></div>
		<input type="submit"  value="Search" id="searchsubmit" />
</form>
</div>
</div class="fclear"></div>
</body>
</html>