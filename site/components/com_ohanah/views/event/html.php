<?php
/**
 * @version		2.0.14
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ComOhanahViewEventHtml extends ComOhanahViewHtml
{
	public function display()
	{
		$event = $this->getModel()->getItem();
		$pageparameters =& JFactory::getApplication()->getPageParameters();
		$params = JComponentHelper::getParams('com_ohanah');

		if (!$event->id && $id = $pageparameters->get('id')) {
			$event = $this->getService('com://site/ohanah.model.events')->set('id', $id)->getItem();
		}

		if ($event->id) {
			JFactory::getDocument()->setTitle($event->title);
			JFactory::getDocument()->setDescription($event->description ? strip_tags($event->description) : $event->title);
		} else {

			if ($pageparameters->get('page_title')) {
				JFactory::getDocument()->setTitle($pageparameters->get('page_title'));
			} else {
				JFactory::getDocument()->setTitle(JText::_('OHANAH_ADD_EVENT'));
			}
		}

		if ($event->id || KRequest::get('get.layout', 'string') == 'form') {
			if ($event->enabled) {
				$this->assign('params', $params);
				$this->assign('pageparameters', $pageparameters);

				$pathway = JFactory::getApplication()->getPathway();
				$pathway->addItem($event->title, '');

				$output = parent::display();

				if ($event->id) $title = $event->title;
				else if (KRequest::get('get.layout', 'string') == 'form') $title = JText::_('OHANAH_ADD_NEW_EVENT');

				$this->getService('com://site/ohanah.template.filter.chrome', array(
					'title' => $title, 
					'class' => array($params->get('moduleclass_sfx')), 
					'styles' => array($params->get('module_chrome'))))
					->write($output);

				return $output;
			} else {
				JError::raiseWarning(0, JText::_('THE_EVENT_YOU_ARE_LOOKING_FOR_IS_NOT_PUBLIC'));
			}
		} else {
			JError::raiseWarning(0, JText::_('THE_EVENT_YOU_ARE_SEARCHING_DOES_NOT_EXIST'));
		}
	}
}