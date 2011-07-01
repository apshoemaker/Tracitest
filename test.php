<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
require("deadband.php");
/* Call our class */
$tracitest = new Tracitest;

/* Set 3 Alarms / Probes / temps */
$probes = array(rand(0,100), rand(0,100), rand(0,100));

$tracitest->_alarm_set(1, 60);

// Lets try to recreate an alarm just for fun
$tracitest->_alarm_set(1, 60);

// comm_temp_fire these bad boys
foreach($probes as $probe => $temp) {
	echo "Probe {$probe}: ";
	echo ($tracitest->comm_temp_fire($probe, $temp)) ? 'true' : 'false';
	echo "<br />";
}
?>