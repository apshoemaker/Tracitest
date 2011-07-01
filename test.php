<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
require("deadband.php");
/* Call our class */
$tracitest = new Tracitest;

/* Set 3 Alarms / Probes / temps */
$probes = array(2, 4, 8); 
foreach ($probes as $probe) {
	$probes[$probe] = rand(0, 100);
	$tracitest->_alarm_set($probe);
}
var_dump($probes);
//
?>