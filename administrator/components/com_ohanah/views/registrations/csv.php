<?php
/**
 * @version		1.0.15
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined('_JEXEC') or die('Restricted access');


class ComOhanahViewRegistrationsCsv extends KViewCsv
{
	public function display()
	{
		$event = $this->getService('com://admin/ohanah.model.events')->set('id', KRequest::get('get.ohanah_event_id', 'int'))->getItem();
		$registrations = $this->getService('com://admin/ohanah.model.registrations')->set('ohanah_event_id', $event->id)->getList();
		$this->output .= $this->_arrayToString(array('name', 'surname', 'email', 'number_of_tickets', 'notes', 'registration_date', 'paid', 'checked_in', 'params')).$this->eol;
		
		$alreadyIn = array();
		
		foreach($registrations as $row) {
			$this->output .= $this->_arrayToString(
				array(
					'name' => $row->name,
					'surname' => $row->surname,
					'email' => $row->email,
					'number_of_tickets' => $row->number_of_tickets,
					'notes' => $row->notes,
					'registration_date' => $row->created_on,
					'paid' => $row->paid,
					'checked_in' => $row->checked_in,
					'params' => $row->params
					)).$this->eol;
		}
		
		return KViewFile::display();
	}
}