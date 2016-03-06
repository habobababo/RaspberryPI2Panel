

<?php
	// Temperatur
	$temp = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
	$temprdy = substr($temp, 0, 2);
	
	// Speicherplatz
	$diskspace = round(number_format(disk_free_space("/media/hdd")));
	$disktotalspace = round(number_format(disk_total_space("/media/hdd"))) . "000";
	$useddiskspace = $disktotalspace - $diskspace;
	$donevar = $useddiskspace . "GB / " .$disktotalspace . "GB";

	//Executes
	exec("service plexmediaserver status", $plexstatus);
	exec("ifconfig", $ipoutput);
	exec("free", $ramoutput);
	exec("uptime", $uptimeoutput);
	//Ip Adressen
	$ip = substr($ipoutput[1],4,-39 );
	$ip1 = substr($ip,-15,13);
	$externalContent = file_get_contents('http://checkip.dyndns.com/');
	preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
	$externalIp = $m[1];
	
	//RAM
	$ram = substr($ramoutput[1],4);
	$ramcalc = explode(" ", preg_replace('!\s+!', ' ',trim(substr($ram,0,40))));
	
	$TotalRAM = substr($ramcalc[0],0,3);
	$UsedRAM = substr($ramcalc[1],0,3);
	$FreeRAM = $TotalRAM - $UsedRAM;
	
	//Uptime
	$uptime = substr($uptimeoutput[0],12,6);


?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8" />
	<title></title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no" />
	<link href="style.css" rel="stylesheet" type="text/css" media="all"/>
</head>

<body>
  <div class="wrap">
    <header>
    	<div class="logo">	
			<img src="images/logo.png"/>
			<span class="title"><span>Raspberry</span> Ziegele</span>
    		<p>RaspberryPi2 Control Panel</p>
    	</div>   
    </header>
    <div class="content">
    	<article>
    		<section class="head">
				<h3>Statistik</h3>
				<?php 
					echo '<div class="date"> CPU Temperatur: ' . $temprdy . '°C</div>';
					echo '<div class="date"> RAM Auslastung </div>';
					echo '<div class="date"> Total: ' . $TotalRAM . 'MB / Used: ' . $UsedRAM . 'MB / Free: ' . $FreeRAM . 'MB</div>';
					echo '<div class="date"> Uptime: ' . $uptime . '</div>';
				?>
			</section>
		</article>
    	<article>
    		<section class="head">
				<h3>Speicherplatz</h3>
				<?php echo '<div class="date">' . $donevar . '</div>' ?>
			</section>
		</article>
		<article>
    		<section class="head">
				<h3>IP Adressen</h3>
				<?php 
				echo '<div class="date"> Intern: ' . $ip1 . '</div>';
				echo '<div class="date"> Extern: ' . $externalIp . '</div>' 
				?>
			</section>
		</article>
		<article onclick="window.location = 'sites/href.html'">
    		<section class="head">
				<h3>Plexstatus</h3>
				<?php 
					echo '<div class="date1">' . $plexstatus[2]. '</div>' 
				?>
			</section>
		</article>
		<article>
    		<section class="head">
			</section>
		</article>
		<article onclick="$.get( 'sites/reboot.php', function( data ) {});">
    		<section class="head">
				<h3>Reboot!</h3>
				<?php echo '<div class="date"> PI Neustarten!</div>' ?>
			</section>
		</article>
		
    </div>
    <footer>
	 	<div align="center">&copy; 2016 <a href="http://core-community.de">core-community.de</a></div>
    </footer>
  </div>
</body>
</html>
