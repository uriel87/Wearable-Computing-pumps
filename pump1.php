<html>
	<head>
		<title>Click to Turn on or OFF the LED in the background</title>
		<meta charset = "utf-8">
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="My_code.js"></script>
		<link rel="stylesheet" text="css\text" href="links.css">
	</head>

	<script>
		var c = 60;
		var t;
		var timer_is_on = 0;

		function timedCount() {
			
			document.getElementById("txt").value = c;
			c = c - 1;
			t = setTimeout(function(){ timedCount() }, 1000);
			if(c==-1)
			{
				stopCount();
			}
		}

		function startCount() {
			c = 60;
			if (!timer_is_on) {
				timer_is_on = 1;
				timedCount();
			}
		}

		function stopCount() {
			clearTimeout(t);
			timer_is_on = 0;
			window.location.href = "pump.php";
		}
	</script>

	<body>
	<?php
		// Check of PUMP2 is set.  If it is use it
		if (isset($_POST["PUMP2"])) { $PUMP2= $_POST["PUMP2"]; }
		else { $PUMP2 =""; }
		if ($PUMP2 == "ON")
		{
			
			// Set PUMP2 ON by calling the Arduino using fopen
			//ini_set("allow_url_fopen On", true);
			$h = @fopen("http://192.168.1.200/?PUMP2=ON", "rb");
			date_default_timezone_set("Israel");
			$onTime = date("h:i:sa");
			echo "<input type='text' id='txt'>";
		}
		else
		{
			$PUMP2 == "OFF";
			// Set PUMP2 OFF by calling the Arduino using fopen
			//ini_set("allow_url_fopen On", true);
			$h = @fopen("http://192.168.1.200/?PUMP2=OFF", "rb");
			date_default_timezone_set("Israel");
			$offTime = date("h:i:sa");
		}
	?>
		<div id=container>
		<div id=information>
		<script>window.onload=startCount();</script>
			<table id=table>
				<tr>
					<?php
						echo"<b>Pumps is $PUMP2</b>"."<br>";
					?>
					<td>Turn on and off the pumps<br><br></td>
				</tr>
				<tr>
					<td>
						<?php if ( isset($onTime) ){echo $onTime;}?>
						<form action="pump.php" method="post" onsubmit="startCount()">
							<input type="hidden" name="PUMP2" value="ON">
							<input type="submit" name="submit" value="ON">
						</form>
					</td>
					<td>
						<?php if ( isset($offTime) ) {echo $offTime;} ?>
						<form action="pump.php" method="post" onsubmit="stopCount()">
							<input type="hidden" name="PUMP2" value="OFF">
							<input type="submit" name="submit" value="OFF">
						</form>
					</td>
				</tr>
			</table>
		</div>
		</div>
	</body>
</html>