<?php
/**
 * @version		1.0.9
 * @package		mod_ohanahcalendar
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanahcalendarHtml extends ModDefaultHtml
{
	public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }
	
	public function getDaysBetweenDates($event) {  
		$days[] = substr($event->date,0,10);
		
		if ($event->end_time_enabled) {

			$sStartDate = $event->date;
			$sEndDate = $event->end_date;

			$sStartDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($event->date)));  	

			$sCurrentDate = $event->date;

			if (substr($event->date,0,10) != substr($event->end_date,0,10)) {
				while(substr($sCurrentDate,0,10) < substr($event->end_date,0,10)){  
					$oldCurrentDate = $sCurrentDate;
					if ($oldCurrentDate == gmdate("Y-m-d", strtotime("+1 days", strtotime($sCurrentDate)))) 
						$sCurrentDate = gmdate("Y-m-d", strtotime("+2 days", strtotime($sCurrentDate)));
					else 
				  		$sCurrentDate = gmdate("Y-m-d", strtotime("+1 days", strtotime($sCurrentDate)));
				  	$days[] = $sCurrentDate;  
				}
			}
		}	

		return $days; 
	}
}
