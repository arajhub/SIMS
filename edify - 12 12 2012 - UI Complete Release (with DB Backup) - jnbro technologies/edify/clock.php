<?php
	header("Pragma: no-cache");
	$gDate = time();
	$gClockShowsSeconds = false;

	function getServerDateItems($inDate) {
		return date('Y,n,j,G,',$inDate).intval(date('i',$inDate)).','.intval(date('s',$inDate));
	}

	function clockDateString($inDate) {
		return date('l, F j, Y',$inDate);    // eg "Monday, January 1, 2002"
	}

	function clockTimeString($inDate, $showSeconds) {
		return date($showSeconds ? 'g:i:s' : 'g:i',$inDate).' ';
	}
?>
<html>
	<head>
		<title>Clock</title>
		<meta name="template" content="none">
		<script language="JavaScript" type="text/javascript">
			var clockLocalStartTime = new Date();
			var clockServerStartTime = new Date(<?php echo(getServerDateItems($gDate))?>);
			function clockInit() {
			}
		</script>
		<script language="JavaScript1.2" type="text/javascript">
			function simpleFindObj(name, inLayer) {
				return document[name] || (document.all && document.all[name])
					|| (document.getElementById && document.getElementById(name))
					|| (document.layers && inLayer && document.layers[inLayer].document[name]);
			}
			var clockIncrementMillis = 60000;
			var localTime;
			var clockOffset;
			var clockExpirationLocal;
			var clockShowsSeconds = false;
			var clockTimerID = null;

			function clockInit(localDateObject, serverDateObject) {
				var origRemoteClock = parseInt(clockGetCookieData("remoteClock"));
				var origLocalClock = parseInt(clockGetCookieData("localClock"));
				var newRemoteClock = serverDateObject.getTime();
				var newLocalClock = localDateObject.getTime();
				var maxClockAge = 60 * 60 * 1000;

				if (newRemoteClock != origRemoteClock) {
					document.cookie = "remoteClock=" + newRemoteClock;
					document.cookie = "localClock=" + newLocalClock;
					clockOffset = newRemoteClock - newLocalClock;
					clockExpirationLocal = newLocalClock + maxClockAge;
					localTime = newLocalClock;
				} else if (origLocalClock != origLocalClock) {
					clockOffset = null;
					clockExpirationLocal = null;
				} else {
					// fall back to clocks in cookies
					clockOffset = origRemoteClock - origLocalClock;
					clockExpirationLocal = origLocalClock + maxClockAge;
					localTime = origLocalClock;
					// so clockUpdate() will reload if newLocalClock
					// is earlier (clock was reset)
				}
				var nextDayLocal = (new Date(serverDateObject.getFullYear(),
						serverDateObject.getMonth(),
						serverDateObject.getDate() + 1)).getTime() - clockOffset;
				if (nextDayLocal < clockExpirationLocal) {
					clockExpirationLocal = nextDayLocal;
				}
			}

			function clockOnLoad() {
				clockUpdate();
			}

			function clockOnUnload() {
				clockClearTimeout();
			}

			function clockClearTimeout() {
				if (clockTimerID) {
					clearTimeout(clockTimerID);
					clockTimerID = null;
				}
			}

			function clockToggleSeconds() {
				clockClearTimeout();
				if (clockShowsSeconds) {
					clockShowsSeconds = false;
					clockIncrementMillis = 60000;
				}
				else {
					clockShowsSeconds = true;
					clockIncrementMillis = 1000;
				}
				clockUpdate();
			}

			function clockTimeString(inHours, inMinutes, inSeconds) {
				return inHours == null ? "-:--" : ((inHours == 0 ? "12" : (inHours <= 12 ? inHours : inHours - 12)) + (inMinutes < 10 ? ":0" : ":") + inMinutes + (clockShowsSeconds ? ((inSeconds < 10 ? ":0" : ":") + inSeconds) : "") + (inHours < 12 ? " AM" : " PM"));
			}

			function clockDisplayTime(inHours, inMinutes, inSeconds) {
				clockWriteToDiv("ClockTime", clockTimeString(inHours, inMinutes, inSeconds));
			}

			function clockWriteToDiv(divName, newValue) {
				var divObject = simpleFindObj(divName);
				newValue = '<p>' + newValue + '<' + '/p>';
				if (divObject && divObject.innerHTML) {
					divObject.innerHTML = newValue;
				} else if (divObject && divObject.document) {
					divObject.document.writeln(newValue);
					divObject.document.close();
				}
			}

			function clockGetCookieData(label) {
				var c = document.cookie;
				if (c) {
					var labelLen = label.length, cEnd = c.length;
					while (cEnd > 0) {
						var cStart = c.lastIndexOf(';',cEnd-1) + 1;
						while (cStart < cEnd && c.charAt(cStart)==" ") cStart++;
						if (cStart + labelLen <= cEnd && c.substr(cStart,labelLen) == label) {
							if (cStart + labelLen == cEnd) {                
								return "";
							} else if (c.charAt(cStart+labelLen) == "=") {
								return unescape(c.substring(cStart + labelLen + 1,cEnd));
							}
						}
						cEnd = cStart - 1;
					}
				}
				return null;
			}

			function clockUpdate() {
				var lastLocalTime = localTime;
				localTime = (new Date()).getTime();

				if (clockOffset == null) {
					clockDisplayTime(null, null, null);
				} else if (localTime < lastLocalTime || clockExpirationLocal < localTime) {
					document.cookie = 'remoteClock=-';
					document.cookie = 'localClock=-';
					location.reload();
				} else {
					var serverTime = new Date(localTime + clockOffset);
					clockDisplayTime(serverTime.getHours(), serverTime.getMinutes(), serverTime.getSeconds());
					clockTimerID = setTimeout("clockUpdate()", clockIncrementMillis - (serverTime.getTime() % clockIncrementMillis));
				}
			}
		</script>
	</head>

	<body bgcolor="#FFFFFF" onload="clockInit(clockLocalStartTime, clockServerStartTime);clockOnLoad();" onunload="clockOnUnload()">
		<div id="ClockTime" style="position: absolute; left: 406px; top: 28px; width: 200px; height: 20px; z-index: 11; cursor: pointer" onclick="clockToggleSeconds()">
		  <p><?php echo(clockTimeString($gDate,$gClockShowsSeconds));?></p>
		</div>
		<div id="ClockBkgnd" style="position: absolute; left: 406px; top: 28px; width: 200px; z-index: 10">
			<p> <br>
				<?php
					echo(clockDateString($gDate));
				?>
			</p>
		</div>
		<p><i>Click on the time to show or hide seconds.</i></p>
	</body>
</html>