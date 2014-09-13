<?php
class Tracitest {
	/* Class Variables */
	private $probeEntranceTemp = array(0, 0, 0);
	private $alarms = array();
	
	
	public function comm_temp_fire($probe, $temp){
		var_dump($temp);
		/* We need some constants */
		$TEMP_HIGH = 60;
		$TEMP_LOW = 10;
		$TEMP_NEUTRAL_ZONE = 35;
		/* No clue what this variable is for so I am just going to set it as true */
		$ALARMS_MASK_TEMP1_ALARM = true;
	
		if(($temp >= $TEMP_HIGH || $temp <= $TEMP_LOW) && !$this->_alarm_test($ALARMS_MASK_TEMP1_ALARM, $probe)){
			/***
			* if temp is between high and low and no test has been set for probe, 
			* then fire and set new entrance temp for probe
			*/
			$this->probeEntranceTemp[$probe] = $temp;
			return true;
		} else if($this->_alarm_test($ALARMS_MASK_TEMP1_ALARM, $probe)){
			/***
			* if an alarm has been set for this probe, we need to test for deadband
			*/
			$neutralTempHigh = $this->probeEntranceTemp[$probe] + $TEMP_NEUTRAL_ZONE;
			$neutralTempLow = $this->probeEntranceTemp[$probe] - $TEMP_NEUTRAL_ZONE;
      
			if(($temp <= $TEMP_HIGH && $temp >= $TEMP_LOW) && ($temp >= $neutralTempHigh || $temp <= $neutralTempLow)) {
				$this->probeEntranceTemp[$probe] = 0;
				return true; //clear temp alarm if we are in between high and low
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	private function _alarm_test($ALARMS_MASK_TEMP1_ALARM, $probe) {
		if($ALARMS_MASK_TEMP1_ALARM && isset($this->alarms[$probe])) {
			/* Alarm is set for this probe */
			return true;
		} else {
			/* Alarm is not set for this probe */
			return false;
		}
		
	}
	
	public function _alarm_set($probe, $temp) {
		if(isset($this->alarms[$probe])) {
			/* Alarm has already been set for this probe */
			echo "Alarm for Probe {$probe} has already been set. <br />";
		} else {
			/* Setting alarm */
			$this->alarms[$probe] = $temp;
			$this->probeEntranceTemp[$probe] = 0;
			echo "Alarm for Probe {$probe} has been set. <br />";
		}
	}
}

?>
