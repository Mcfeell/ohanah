<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @version	2.0.1
 * @package	com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license	GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarMenubar extends ComDefaultControllerToolbarMenubar
{
    public function getCommands()
    { 
        $name = $this->getController()->getIdentifier()->name;
        
        $parameters = ''; 
        if (KRequest::get('get.recurringParent', 'int')) $parameters = '&recurringParent=0';
        if (KRequest::get('get.published', 'string')) $parameters = '&published=';
        if (KRequest::get('get.ohanah_category_id', 'int')) $parameters = '&ohanah_category_id=0';
        if (KRequest::get('get.search', 'string')) $parameters = '&search=';
        if (KRequest::get('get.ohanah_venue_id', 'string')) $parameters = '&ohanah_venue_id=';
        if (KRequest::get('get.frontend_submitted', 'string')) $parameters = '&frontend_submitted=';
        if (KRequest::get('get.ohanah_venue_id', 'int')) $parameters = '&ohanah_venue_id=';
        
        $this->addCommand('OHANAH_DASHBOARD', array(
            'href'   => JRoute::_('index.php?option=com_ohanah&view=dashboard'),
            'active' => ($name == 'dashboard')
        ));
                
        $this->addCommand('EVENTS', array(
            'href'   => JRoute::_('index.php?option=com_ohanah&view=events'.$parameters),
            'active' => ($name == 'event')
        ));
              
        $this->addCommand('VENUES', array(
            'href'   => JRoute::_('index.php?option=com_ohanah&view=venues'),
            'active' => ($name == 'venue')
        ));

        $this->addCommand('CATEGORIES', array(
            'href' => JRoute::_('index.php?option=com_ohanah&view=categories'),
            'active' => ($name == 'category')
        ));
             
        $this->addCommand('SETTINGS', array(
            'href'   => JRoute::_('index.php?option=com_ohanah&view=config'),
            'active' => ($name == 'config')
        ));
                         
        $this->addCommand('HELP', array(
            'href'   => JRoute::_('index.php?option=com_ohanah&view=help'),
            'active' => ($name == 'help')
        ));

        return $this->_commands;   
    }
}