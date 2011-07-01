<?PHP
	class CommTempClass {
		
		private $probe1State = false;
		private $probe2State;
		private $probe3State;
		public $ALARMS_MASK_TEMP1_ALARM = false;
		public $TEMP_HIGH = 80;
		public $TEMP_LOW = 50;
		public $TEMP_NEUTRAL_ZONE = 10;
		
		function _alarm_test($ALARMS_MASK_TEMP1_ALARM, $probe) 
		
		{
			
						
			if ($ALARMS_MASK_TEMP1_ALARM == true) 
			
			{	
				
				/*STORE PROBE STATE TO CLASS VARIABLE*/
				switch ($probe)
				{
					case 1:
						$this->probe1State = true;
						break;
					case 2:
						$this->probe2State = true;
						break;
					case 3:
						$this->probe3State = true;
						break;
					
				}
				
				
			}
			
			else 
			
			{
				switch ($probe)
					{
						case 1:
							$this->probe1State = false;
							break;
						case 2:
							$this->probe2State = false;
							break;
						case 3:
							$this->probe3State = false;
							break;
						
					}
			}
			
			
		/*RETURN PROBE STATE BASED ON PROBE NUMBER*/
			
			switch ($probe)
			{
				case 1:
					return $this->probe1State;
					break;
				case 2:
					return $this->probe2State;
					break;
				case 3:
					return $this->probe3State;
					break;
			}
			
			
		}
		
		
		function comm_temp_fire($temp, $probe) 
	
		{
			$TEMP_HIGH = $this->TEMP_HIGH;
			$TEMP_LOW = $this->TEMP_LOW;
			$TEMP_NEUTRAL_ZONE = $this->TEMP_NEUTRAL_ZONE;
			
			/*
			 * ALARM MOST RECENT STATE
			 * */
			 $ALARMS_MASK_TEMP1_ALARM = $this->ALARMS_MASK_TEMP1_ALARM;
			
		
	
			if (($temp >= $TEMP_HIGH || $temp <= $TEMP_LOW) && ! $this->_alarm_test ( $ALARMS_MASK_TEMP1_ALARM, $probe )) 
			
			{
				/***
				 * if temp isn't between high and low and no test has been set for probe, 
				 * then fire and set new entrance temp for probe
				 */
				
				
				$this->_alarm_test($ALARMS_MASK_TEMP1_ALARM, $probe);
				$probeEntranceTemp [$probe] = $temp;
				return true;
			}

			else if ($this->_alarm_test ( $ALARMS_MASK_TEMP1_ALARM, $probe )) 
			
			{
				/***
				 * if an alarm has been set for this probe, we need to test for deadband
				 */
				$neutralTempHigh = $probeEntranceTemp [$probe] + $TEMP_NEUTRAL_ZONE;
				$neutralTempLow = $probeEntranceTemp [$probe] - $TEMP_NEUTRAL_ZONE;
				
				if (($temp <= $TEMP_HIGH && $temp >= $TEMP_LOW) && ($temp >= $neutralTempHigh || $temp <= $neutralTempLow)) 
				
				{
					$probeEntranceTemp [$probe] = 0;
					return true; //clear temp alarm if we are in between high and low
				} 
				
				else 
				
				{
					return false;
				}
			} 
			
			else 
			{
				return false;
			}
		}
	}
?>
