<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @version		2.0.1
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

jimport('joomla.filesystem.file');

class ComOhanahControllerEvent extends ComOhanahControllerCommon 
{
	public function __construct(KConfig $config)
	{
		if (KRequest::get('get.view', 'string') == 'events' && !KRequest::get('get.recurringParent', 'int')) {
			$config->request->append(array('recurringParent' => 0));	
		}

		if (KRequest::get('get.view', 'string') == 'events' && !KRequest::get('get.filterEvents', 'string')) {
			$config->request->append(array('filterEvents' => 'notpast'));	
		}

		parent::__construct($config);

		if (JComponentHelper::getParams('com_ohanah')->get('enableMailchimp')) {
			$this->registerCallback('before.apply', array($this, 'populateListOnMailchimp'));
		}
	}	
		
	public function populateListOnMailchimp() {
		$event = $this->getService('com://admin/ohanah.model.events')->id(KRequest::get('get.id', 'int'))->getItem();

		$currentListId = $event->mailchimp_list_id;
		$newListId = KRequest::get('post.mailchimp_list_id', 'string');

		if ($currentListId) {
			if ($currentListId != $newListId) {		
				foreach ($event->getAttendees() as $subscriber) //Populate new list
					$this->getService('com://site/ohanah.controller.registration')->pushOnMailchimp($subscriber->email, $subscriber->name, $newListId);
			}	
		}
	}

	public function sendNotifications($params) {

		if (JComponentHelper::getParams('com_ohanah')->get('enableEmailNewEventFrontend')) 
		{
			$subject = JComponentHelper::getParams('com_ohanah')->get('subject_mail_new_event');
			$message = JComponentHelper::getParams('com_ohanah')->get('text_mail_new_event');

			$subject = str_replace('{NAME}', KRequest::get('post.created_by_name', 'string'), $subject);
			$subject = str_replace('{EMAIL}', KRequest::get('post.created_by_email', 'string'), $subject);
			$subject = str_replace('{EVENT_TITLE}', KRequest::get('post.title', 'string'), $subject);
			$subject = str_replace('{EVENT_LINK}', '', $subject);

			$message = str_replace('{NAME}', KRequest::get('post.created_by_name', 'string'), $message);
			$message = str_replace('{EMAIL}', KRequest::get('post.created_by_email', 'string'), $message);
			$message = str_replace('{EVENT_TITLE}', KRequest::get('post.title', 'string'), $message);

			if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '';
			$message = str_replace('{EVENT_LINK}', 'http://'.$_SERVER['HTTP_HOST'].JRoute::_('index.php?option=com_ohanah&view=event&id='.$this->getModel()->getItem()->id.$itemid), $message);


			$emailAddress = JFactory::getConfig()->getValue('mailfrom');
			if (JComponentHelper::getParams('com_ohanah')->get('destination_email')) {
				$emailAddress = JComponentHelper::getParams('com_ohanah')->get('destination_email');
			}		

			JUtility::sendMail(JFactory::getConfig()->getValue('mailfrom'), JFactory::getConfig()->getValue('fromname'), $emailAddress, $subject, $message, true);
		}
	}

	protected function _actionCopy(KCommandContext $context)
	{
		foreach (KRequest::get('get.id', 'int') as $eventid) {
			$event = $this->getService('com://admin/ohanah.model.events')->id($eventid)->getItem();
			$event->id = null;
			$event->title = 'Copy of '.$event->title;
			$event->slug = 'copy-of-'.$event->slug;

			$append = '';
			$i = 0;

			while ($count = $this->getService('com://admin/ohanah.model.events')->set('slug', $event->slug.$append)->getTotal())
			{
				$append = '-'.++$i;
			}

			$event->slug = $event->slug.$append;

			$event->setStatus(NULL);

			if($event->save()) {
				$this->getService('com://admin/ohanah.controller.mixpanel')->ohstats('event_added', array());

				$images = $this->getService('com://admin/ohanah.model.attachments')->set('target_type', 'event')->set('target_id', $eventid)->getList();

				if ($images) foreach ($images as $image) {
					$new_image = $this->getService('com://admin/ohanah.database.row.attachment');
					
					$new_image->name = $image->name;
					$new_image->target_type = 'event';
					$new_image->target_id = $event->id;
					$new_image->save();

				}
			}
		}		
	}
	
	protected function _processRecurring($context, $row)
	{
		$data = $context->data;

		if ($data['isRecurring'])
		{
			$original_id = $row->id;

   			$eventStartDate = new KDate(new KConfig(array('date' => $data['date'])));
   			$endOnDate = new KDate(new KConfig(array('date' => $data['endOnDate'])));

   			$daysDifference = $endOnDate->toDays() - $eventStartDate->toDays();
   			$divideByWhat = 1;

			if ($data['everyWhat'] == 'year') {
   				$divideByWhat = 365;
			} else if ($data['everyWhat'] == 'month') {
   				$divideByWhat = 31;
			} else if ($data['everyWhat'] == 'week') {
   				$divideByWhat = 7;
			} else if ($data['everyWhat'] == 'day') {
   				$divideByWhat = 1;
			}

			$divideByWhat *= $data['everyNumber'];

			$number = (int)($daysDifference / $divideByWhat);

			$everyWhat = $data['everyWhat'];
			$everyNumber = $data['everyNumber'];

			if ($data['slug']) {
				$originalSlug = $data['slug'];
			}
			else {
				$originalSlug = $this->getService('com://admin/ohanah.filter.slug')->sanitize($data['title']);
			}

			$originalDate = $data['date'];
			$originalEndDate = $data['end_date'];

			unset($data['isRecurring']);
			unset($data['everyNumber']);
			unset($data['everyWhat']);
			unset($data['endAfterNumber']);
			unset($data['endAfterWhat']);			
			unset($data['id']);

			$data['recurringParent'] = $row->id;

			$images = $this->getService('com://admin/ohanah.model.attachments')->set('target_type', 'event')->set('target_id', $original_id)->getList();

			for ($i = 1; $i <= $number; $i++) {
				$data['slug'] = $originalSlug.'-'.$i;
				$new_event = $this->getService('com://admin/ohanah.model.events')->getItem();
												
				$new_event->id = null;

    			$startDateEvent = new KDate(new KConfig(array('date' => $originalDate)));
   		 		$endDateEvent = new KDate(new KConfig(array('date' => $originalEndDate)));

    			if ($everyWhat == 'year') {
    				$startDateEvent->addYears($i * $everyNumber);
    				$endDateEvent->addYears($i * $everyNumber);
				} else if ($everyWhat == 'month') {
					$startDateEvent->addMonths($i * $everyNumber);
					$endDateEvent->addMonths($i * $everyNumber);
				} else if ($everyWhat == 'week') {
					$startDateEvent->addDays(7 * $i * $everyNumber);
					$endDateEvent->addDays(7 * $i * $everyNumber);
				} else if ($everyWhat == 'day') {
					$startDateEvent->addDays($i * $everyNumber);
					$endDateEvent->addDays($i * $everyNumber);
				}

				$data['date'] = $startDateEvent->getDate();
				$data['end_date'] = $endDateEvent->getDate();

				$new_event->setData(KConfig::unbox($data));

			    if($new_event->save()) {
					$this->getService('com://admin/ohanah.controller.mixpanel')->ohstats('event_added', array());

					if ($images) foreach ($images as $image) {
						if (!$this->getService('com://admin/ohanah.model.attachments')->set('target_type', 'event')->set('target_id', $new_event->id)->set('name', $image->name)->getTotal()) {
							$new_image = $this->getService('com://admin/ohanah.database.row.attachment');
							$new_image->name = $image->name;
							$new_image->target_type = 'event';
							$new_image->target_id = $new_event->id;
							$new_image->save();	
						}
					}
				}
			}			
		}
	}
	
	protected function _modifyAllRecurringChildren($context, $row, $eventDataBeforeEdit)
	{
		$data = KConfig::unbox($context->data);

		$oldStartDate = new KDate(new KConfig(array('date' => $eventDataBeforeEdit->date)));
   		$newStartDate = new KDate(new KConfig(array('date' => $data['date'])));
		$oldEndDate = new KDate(new KConfig(array('date' => $eventDataBeforeEdit->end_date)));
   		$newEndDate = new KDate(new KConfig(array('date' => $data['end_date'])));

		$daysToAddToStartDate = ($newStartDate->toDays() - $oldStartDate->toDays());
		$daysToAddToEndDate = ($newEndDate->toDays() - $oldEndDate->toDays());

		$date = $data['date'];
		$end_date = $data['end_date'];

		unset($data['id']);
		unset($data['recurringParent']);
		unset($data['date']);
		unset($data['end_date']);
		unset($data['slug']);
		unset($data['title']);
		unset($data['created_on']);

		$children = $this->getService('com://admin/ohanah.model.events')->set('recurringParent', $row->id)->getList();
		
		foreach ($children as $child) {
    		$newStartDate = new KDate(new KConfig(array('date' => $child->date)));
			$child->set('date', $newStartDate->addDays((int)$daysToAddToStartDate)->getDate());
			$newEndDate = new KDate(new KConfig(array('date' => $child->end_date)));
			$child->set('end_date', $newEndDate->addDays((int)$daysToAddToEndDate)->getDate());

			$child->setData($data)->save();
		}
	}
	
	protected function _processChangeInEndOfRecurringSeries($context, $row, $eventDataBeforeEdit)
	{
		$data = KConfig::unbox($context->data);

		$oldEndSeriesDate = new KDate(new KConfig(array('date' => $eventDataBeforeEdit->endOnDate)));
   		$newEndSeriesDate = new KDate(new KConfig(array('date' => $data['endOnDate'])));

   		if ($newEndSeriesDate->toDays() > $oldEndSeriesDate->toDays()) {
			
			//Scopro la data dell'ultimo evento della serie
			$children = $this->getService('com://admin/ohanah.model.events')->set('recurringParent', $row->id)->getList();

			$oldest = null;
						
			foreach ($children as $child) {
				if (!$oldest) {
					$oldest = $child;
				} else {
					if ($child->date > $oldest->date) $oldest = $child;
				}
			}

			if ($newEndSeriesDate->getDate() > $oldest->date) {
				//Vedo quanti ce ne stanno ancora

   				$oldestStartDate = new KDate(new KConfig(array('date' => $oldest->date)));
	   			$daysDifference = $newEndSeriesDate->toDays() - $oldestStartDate->toDays();
	   			$divideByWhat = 1;

				if ($row->everyWhat == 'year') {
	   				$divideByWhat = 365;
				} else if ($row->everyWhat == 'month') {
	   				$divideByWhat = 31;
				} else if ($row->everyWhat == 'week') {
	   				$divideByWhat = 7;
				} else if ($row->everyWhat == 'day') {
	   				$divideByWhat = 1;
				}

				$divideByWhat *= $row->everyNumber;

				$number = (int)($daysDifference / $divideByWhat);

				$everyWhat = $row->everyWhat;
				$everyNumber = $row->everyNumber;
				$originalSlug = $data['slug'];
				$originalDate = $oldest->date;
				$originalEndDate = $oldest->end_date;

				unset($data['isRecurring']);
				unset($data['everyNumber']);
				unset($data['everyWhat']);
				unset($data['endAfterNumber']);
				unset($data['endAfterWhat']);			
				$data['recurringParent'] = $row->id;

				for ($i = 1; $i <= $number; $i++) {

					$data['slug'] = $originalSlug.'-'.$i; //TODO: FIxo per slug tetetete-2-1 tetetete-3-1
					$row = $this->getService('com://admin/ohanah.model.events')->getItem();
													
	    			$startDateEvent = new KDate(new KConfig(array('date' => $oldest->date)));
	   		 		$endDateEvent = new KDate(new KConfig(array('date' => $oldest->end_date)));

	    			if ($everyWhat == 'year') {
	    				$startDateEvent->addYears($i * $everyNumber);
	    				$endDateEvent->addYears($i * $everyNumber);
					} else if ($everyWhat == 'month') {
						$startDateEvent->addMonths($i * $everyNumber);
						$endDateEvent->addMonths($i * $everyNumber);
					} else if ($everyWhat == 'week') {
						$startDateEvent->addDays(7 * $i * $everyNumber);
						$endDateEvent->addDays(7 * $i * $everyNumber);
					} else if ($everyWhat == 'day') {
						$startDateEvent->addDays($i * $everyNumber);
						$endDateEvent->addDays($i * $everyNumber);
					}

					$data['date'] = $startDateEvent->getDate();
					$data['end_date'] = $endDateEvent->getDate();

					$row->setData(KConfig::unbox($data));
					$row->id = '';

				    if($row->save()) {
						$this->getService('com://admin/ohanah.controller.mixpanel')->ohstats('event_added', array());
					}
				}			
			}
   		} else if ($newEndSeriesDate->toDays() < $oldEndSeriesDate->toDays()) {
   			
			$children = $this->getService('com://admin/ohanah.model.events')->set('recurringParent', $row->id)->getList();
						
			foreach ($children as $child) {
				if ($newEndSeriesDate->getDate() < $child->date) {
					$child->delete();
				}
			}
   		}
	}

	protected function _processCustomFields($data)
	{
		$data['customfields'] = '';

		for ($i = 1; $i <= 10; $i++) {
			if ($data['cf'.$i]) $data['customfields'] .= 'cf'.$i.'=1'.PHP_EOL;  
			else $data['customfields'] .= 'cf'.$i.'=0'. PHP_EOL;	

			if ($label = $data['custom_field_label_'.$i]) $data['customfields'] .= 'custom_field_label_'.$i.'='.$label.PHP_EOL; 
			else $data['customfields'] .= 'custom_field_label_'.$i.'='. PHP_EOL;	
			
			if ($mandatory = $data['custom_field_label_'.$i.'_mandatory']) $data['customfields'] .= 'custom_field_label_'.$i.'_mandatory=1'.PHP_EOL; 
			else $data['customfields'] .= 'custom_field_label_'.$i.'_mandatory=0'. PHP_EOL;	
		}

		return $data;
	}

	private function _processData($data) 
	{
		$data = $this->reverseGeocode($data);
		$data = $this->_processCustomFields($data);
		$data = $this->_processVenue($data);
		
		if ($data['end_time_enabled'] != null) $data['end_time_enabled'] = 1; else $data['end_time_enabled'] = 0;

		if ($data['title'] && !$data['ohanah_category_id']) {
			//check that title is there, if not I'm disabling/enabling the event, not editing it
			$data['ohanah_category_id'] = 1;
		}

		return $data;
	}
	
	protected function _actionAdd(KCommandContext $context) 
	{
		$data = $context->data;

		$context->data = $this->_processData($data);
		$row = parent::_actionAdd($context);

		$this->_processImages('temp_event', $data->random_id, $row->id);
		$this->_processRecurring($context, $row);
		$this->getService('com://admin/ohanah.controller.mixpanel')->ohstats('event_added', array());
				
		$this->_message = JText::_('OHANAH_EVENT_ADDED');

		return $row;
	}

	protected function _actionEdit(KCommandContext $context)
	{ 	
		if (KRequest::get('get.view', 'string') == 'event') {
			$data = $context->data; 
			$eventDataBeforeEdit = $this->getService('com://admin/ohanah.model.events')->id(KRequest::get('get.id', 'int'))->getItem();
			$wasRecurring = $eventDataBeforeEdit->isRecurring();
			$context->data = $this->_processData($data);			
		}

		$row = parent::_actionEdit($context);

		if (KRequest::get('get.view', 'string') == 'event') {

			if (!$eventDataBeforeEdit->isRecurring() && $data['isRecurring']) $this->_processRecurring($context, $row);

			if ($wasRecurring) {
				$this->_modifyAllRecurringChildren($context, $row, $eventDataBeforeEdit);
				$this->_processChangeInEndOfRecurringSeries($context, $row, $eventDataBeforeEdit);
			}

			//cleanup recurring data, when the recurring set has been freed by removing the master
			if ($data['isRecurring'] && !KService::get('com://site/ohanah.model.events')->set('id', $data['isRecurring'])->getTotal()) {
				$data['recurringParent'] = 0;
			}
		}
		
		$this->_message = JText::_('OHANAH_EVENT_SETTINGS_SAVED');
		return $row;		
	}

	protected function _actionRemovefromrecurringset(KCommandContext $context) 
	{
		$data = $context->data;
		$data['recurringParent'] = 0;
		$context->data = $data;
		
		$row = $this->_actionEdit($context);

		return $row;
	}
	
	public function getRedirect()
	{
		$action = KRequest::get('post.action', 'string');
		if ($action == "cancel" || $action == "save") 
		{
			$url = 'index.php?option=com_ohanah&view=events';
			
			return $result = array(
				'url' 			=> JRoute::_($url, false),
				'message' 		=> $this->_message,
				'messageType' 	=> $this->_messageType
			);
		}
		else 
		{			
			$result = array();
			
			if(!empty($this->_redirect))
			{
				$url = $this->_redirect;
			
				//Create the url if no full URL was passed
				if(strrpos($url, '?') === false) 
				{
					$url = 'index.php?option=com_'.$this->getIdentifier()->package.'&'.$url;
				}
			
				$result = array(
					'url' 			=> JRoute::_($url, false),
					'message' 		=> $this->_message,
					'messageType' 	=> $this->_messageType,
				);
			}
			
			return $result;
		}
	}
}
