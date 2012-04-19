<?php 
/**
 * @version		2.0.1
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahDispatcher extends ComDefaultDispatcher
{ 
	/* Used to set persistable to false, needed in Alpha3 https://groups.google.com/forum/#!topic/nooku-framework/U8J0Icyx8hw */
	// public function getController()
	// {
	// 	if(!($this->_controller instanceof KControllerAbstract))
	// 	{  
	// 	    //Make sure we have a controller identifier
	// 	    if(!($this->_controller instanceof KIdentifier)) {
	// 	        $this->setController($this->_controller);
	// 		}
	// 		
	//             $persistable = false;
	// 	    
	// 	    $config = array(
	//         		'request' 	   => $this->_request,
	//         		'persistable'  => $persistable,
	// 		    'dispatched'   => true	
	//         	);
	//         	
	// 		$this->_controller = $this->getService($this->_controller, $config);
	// 	}
	// 
	// 	return $this->_controller;
	// }
}