
comm_temp_fire($temp, $probe){
   if(($temp >= $TEMP_HIGH || temp <= $TEMP_LOW) && !$this->_alarm_test($ALARMS_MASK_TEMP1_ALARM, $probe)){
      /***
      * if temp is between high and low and no test has been set for probe, 
      * then fire and set new entrance temp for probe
      */
      $probeEntranceTemp[$probe] = $temp;
      return true;
   } else if($this->_alarm_test($ALARMS_MASK_TEMP1_ALARM, $probe)){
      /***
      * if an alarm has been set for this probe, we need to test for deadband
      */
      $neutralTempHigh = $probeEntranceTemp[probe] + $TEMP_NEUTRAL_ZONE;
      $neutralTempLow = $probeEntranceTemp[$probe] - $TEMP_NEUTRAL_ZONE;
      
      if(($temp <= $TEMP_HIGH && $temp >= $TEMP_LOW) && ($temp >= $neutralTempHigh || $temp <= $neutralTempLow)) {
         $probeEntranceTemp[$probe] = 0;
         return true; //clear temp alarm if we are in between high and low
      } else {
         return false;
      }
   } else {
      return false;
   }
}
?>
