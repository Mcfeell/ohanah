<?php
/**
 * @version		2.0.1
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ComOhanahViewEventIcs extends KViewFile
{
	public function display()
	{
		$event = $this->getModel()->getItem();

  		header("Content-Description: File Transfer");
  		header("Content-Disposition: attachment; filename= ".$event->title.".ics");
  		header("Content-Transfer-Encoding: binary");
 		header("Content-type: text/calendar");
 		
  		$date = new KDate();

		$eventStartDate = new KDate(new KConfig(array('date' => $event->date)));
		$eventEndDate = new KDate(new KConfig(array('date' => $event->end_date)));

		echo 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Feedo Feed//NONSGML v1.0//EN
METHOD:PUBLISH
X-WR-CALNAME:'.$event->title.'
X-WR-CALDESC:'.$event->description.'
X-MS-OLK-FORCEINSPECTOROPEN:TRUE
BEGIN:VEVENT
DTSTART:'.$eventStartDate->getDate('%Y%m%dT').str_replace(':', '', $event->start_time).'Z
DTEND:'.$eventEndDate->getDate('%Y%m%dT').str_replace(':', '', $event->end_time).'Z
TRANSP:TRANSPARENT
UID:a408629@plancast.com
SUMMARY:'.$event->title.'
DESCRIPTION:'.$event->description.'
URL:http://'.$_SERVER['HTTP_HOST'].$this->createRoute('format=html&view=event&id='.$event->id).'
CATEGORIES:'.$this->getService('com://site/ohanah.model.categories')->id($event->ohanah_category_id)->getItem()->title.'
LOCATION:'.$this->getService('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title.'
DTSTAMP:'.$date->getDate(DATE_FORMAT_ISO_BASIC).'Z
END:VEVENT
END:VCALENDAR'; exit();
	}	
}