<?php
/**
 * @version		2.0.14
 * @package		mod_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

// Check if Koowa is active
if(!defined('KOOWA')) {
	JError::raiseWarning(0, JText::_("Koowa wasn't found. Please install the Koowa plugin and enable it."));
	return;
}

echo KService::get('mod://site/ohanahevents.html', array(
	'params'  => $params,
	'module'  => $module,
	'attribs' => $attribs
))->display();