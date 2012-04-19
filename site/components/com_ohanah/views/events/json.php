<?php
/**
 * @version		2.0.1
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ComOhanahViewEventsJson extends KViewJson
{
	public function display()
	{
		$model = $this->getModel();
		
		$start_date = new KDate();
		$end_date = new KDate();

		//This breaks the model if used in the calendar module, so I check the layout param
		if (KRequest::get('get.layout', 'string') == 'calendar') {
			if (KRequest::get('get.start', 'string')) {
				$start_date->setDate(KRequest::get('get.start', 'string'));
				$model->set('calendar_start_date', $start_date->getDate('%Y-%m-%d'));			
			} else {
				$model->set('calendar_start_date', $start_date->getDate('%Y-%m').'-01');
			}

			if (KRequest::get('get.end', 'string')) {
				$end_date->setDate(KRequest::get('get.end', 'string'));
				$model->set('calendar_end_date', $end_date->getDate('%Y-%m-%d'));				
			} else {
				$model->set('calendar_end_date', $start_date->getDate('%Y-%m').'-31');
			}	
		}
		
		if ($starting_date = KRequest::get('get.starting_date', 'string')) {
			$start_date->setDate($starting_date);
			$model->set('calendar_start_date', $start_date->getDate('%Y-%m-%d'));
		}
		
		if ($ending_date = KRequest::get('get.ending_date', 'string')) {
			$end_date->setDate($ending_date);
			$model->set('calendar_end_date', $end_date->getDate('%Y-%m-%d'));
		}
		
		$model->set('ohanah_category_id', KRequest::get('get.ohanah_category_id', 'int'));
			
		$model->set('enabled', 1);
		$data = $model->getList()->toArray();

		$json = array();
		
		foreach($data as $values) {
			if (KRequest::get('get.showAddressOfEvents', 'int'))
				$values['title'].= ' '.$values['address'];

			$json[]= $values;
		}
		
		echo json_encode($json);
	}	
}