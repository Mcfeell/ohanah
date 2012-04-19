<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @version		2.0.1
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarEvents extends ComOhanahControllerToolbarDefault
{
    public function getCommands()
    {
        $this->addSeparator()
            ->addCopy()
            ->addSeparator()
            ->addPublish()
        	->addUnpublish()
			->setTitle('OHANAH_EVENTS_LIST', 'dashboard')
			->setIcon('ohanah');

        if (KRequest::get('get.filterEvents', 'string') == 'notpast' || KRequest::get('get.filterEvents', 'string') == '') $title = JText::_('OHANAH_UPCOMING_EVENTS').' ';;
        if (KRequest::get('get.filterEvents', 'string') == 'past') $title = JText::_('OHANAH_PAST_EVENTS').' ';
        if (KRequest::get('get.published', 'string') == 'true') $title = JText::_('OHANAH_PUBLISHED_EVENTS').' ';
        if (KRequest::get('get.published', 'string') == 'false') $title = JText::_('OHANAH_UNPUBLISHED_EVENTS').' ';
        if (KRequest::get('get.published', 'string') == 'false' && KRequest::get('get.frontend_submitted', 'int') == 1) $title = JText::_('OHANAH_FRONTEND_SUBMITTED_EVENTS').' ';

        if ($recurringParent = KRequest::get('get.recurringParent', 'int')) {
            $title = JText::sprintf('OHANAH_RECURRING_EVENT', $this->getService('com://admin/ohanah.model.events')->id($recurringParent)->getItem()->title);
        }

        if ($ohanah_venue_id = KRequest::get('get.ohanah_venue_id', 'int')) {
            $title .= JText::sprintf('OHANAH_IN_VENUE', $this->getService('com://admin/ohanah.model.venues')->id($ohanah_venue_id)->getItem()->title);
        }
        
        if ($ohanah_category_id = KRequest::get('get.ohanah_category_id', 'int')) {
            $title .= JText::sprintf('OHANAH_IN_CATEGORY', $this->getService('com://admin/ohanah.model.categories')->id($ohanah_category_id)->getItem()->title);
        }

        $this->setTitle($title, 'dashboard');

        return parent::getCommands();
    }
}