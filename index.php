<?php 

include 'deadband.php';

$commTemp = new CommTempClass();

$temp = $_POST['temp'];
$tempHigh = $_POST['TempHigh'];
$tempLow = $_POST['TempLow'];
$tempNeutralZone = $_POST['TempNeutralZone'];
if ($_POST['PreviousState'] == "true") 
{
	$previousState = true;
}
else 
{
	$previousState = false;
}


if ((($_POST['temp'] != '')) && ($_POST['TempHigh'] != '') && ($_POST['TempLow'] != '') &&
	($_POST['PreviousState'] != '')) 

{
	/*
	 * SET TEMP HIGH/LOW/NEUTRAL ZONE
	 * */
	$commTemp->TEMP_HIGH = $tempHigh;
	$commTemp->TEMP_LOW = $tempLow;
	$commTemp->TEMP_NEUTRAL_ZONE = $tempNeutralZone;
	$commTemp->ALARMS_MASK_TEMP1_ALARM = $previousState;

	
/*	ALERT ON FORM SUBMISSION*/
	$probe = 3;	
	$toggle = $commTemp->comm_temp_fire($temp, $probe);
	
	if ($toggle == true) 
	
	{
		if ($commTemp->ALARMS_MASK_TEMP1_ALARM == false) 
		{
			
			$alarmMessage = 'The Most Recent State of the Alarm was "OFF", at '.$temp.' degrees, it is necessary to change the alarm state.';
		}
		else 
		{
			
			$alarmMessage = 'The Most Recent State of the Alarm was "ON", at '.$temp.' degrees, it is necessary to change the alarm state.';
		}
		
	}
	if ($toggle == false) 
	
	{
		if ($commTemp->ALARMS_MASK_TEMP1_ALARM == false) 
		{
			
			$alarmMessage = 'The Most Recent State of the Alarm was "OFF", at '.$temp.' degrees, there is no need to change the alarm state.';
		}
		else 
		{
			
			$alarmMessage = 'The Most Recent State of the Alarm was "ON", at '.$temp.' degrees, the alarm state does not need to be changed.';
		}
		
	}
	
	
?>

<!--JAVASCRUPT ALERT-->

<script type="text/javascript">
	alert('<?php echo $alarmMessage;?>');
</script>
<?php 

}



?>

<form action="" method="post">
<span style="text-decoration:underline; font-weight:bold">
Alarm Most Recent State</span> <br>
<input type="radio" name="PreviousState" value="true">On<br/>
<input type="radio" name="PreviousState" value="false" checked>Off<br/> <hr/>
High Temp<input style="margin-left:20px;" type="text" name="TempHigh"/><br/>
Low Temp<input style="margin-left:20px;" type="text" name="TempLow"/><br/>

Current Temp<input type="text" name="temp"/><br/>
<input type="submit" value="Set Temp"/>
</form>