<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @version		2.0.1
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerConfig extends ComDefaultControllerResource
{
	public function _actionSendtestmail(KCommandContext $context) {
		$subject = KRequest::get('post.subject', 'string');
		$message = KRequest::get('post.message', 'raw');

		$subject = str_replace('{NAME}', 'John Appleseed', $subject);
		$subject = str_replace('{EMAIL}', 'john@appleseed.com', $subject);
		$subject = str_replace('{EVENT_TITLE}', 'My Test Event', $subject);
		$subject = str_replace('{EVENT_LINK}', '', $subject);
		$subject = str_replace('{TICKETS}', '2', $subject);
		$subject = str_replace('{NOTES}', 'Sample additional notes', $subject);

		$message = str_replace('{NAME}', 'John Appleseed', $message);
		$message = str_replace('{EMAIL}', 'john@appleseed.com', $message);
		$message = str_replace('{EVENT_TITLE}', 'My Test Event', $message);
		$message = str_replace('{EVENT_LINK}', 'http://link-to-my-site.com/my-event', $message);
		$message = str_replace('{TICKETS}', '2', $message);
		$message = str_replace('{NOTES}', 'Sample additional notes', $message);

		$emailAddress = JFactory::getConfig()->getValue('mailfrom');
		if (JComponentHelper::getParams('com_ohanah')->get('destination_email')) {
			$emailAddress = JComponentHelper::getParams('com_ohanah')->get('destination_email');
		}

		JUtility::sendMail(JFactory::getConfig()->getValue('mailfrom'), JFactory::getConfig()->getValue('fromname'), $emailAddress, $subject, $message, true);
	}

	private function _save() {
		
		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
		if ($joomlaVersion == '1.5') { 
			$table =& JTable::getInstance('component');
			$table->loadByOption('com_ohanah');
		} else {
			$table =& JTable::getInstance('extension');
			$db =& JFactory::getDBO();
			$db->setQuery('SELECT extension_id FROM #__extensions WHERE type="component" AND element="com_ohanah"');
			$extension_id = $db->loadResult();
			$table->load($extension_id);
		}

		$post['option'] = 'com_ohanah';
		$post['params']['itemid']= KRequest::get('post.itemid', 'int');
		$post['params']['enableEmail']= KRequest::get('post.enableEmail', 'int');
		$post['params']['paypal_email']= KRequest::get('post.paypal_email', 'string');
		$post['params']['payment_currency']= KRequest::get('post.payment_currency', 'string');
		$post['params']['payment_gateway']= KRequest::get('post.payment_gateway', 'string');
		$post['params']['loadJQuery']= KRequest::get('post.loadJQuery', 'int');
		$post['params']['dst']= KRequest::get('post.dst', 'int');
		$post['params']['timeFormat']= KRequest::get('post.timeFormat', 'string');
		$post['params']['customCSS']= KRequest::get('post.customCSS', 'string');
		$post['params']['showLinkBack']= KRequest::get('post.showLinkBack', 'int');
		$post['params']['usePagination']= KRequest::get('post.usePagination', 'int');
		$post['params']['eventsPerPage']= KRequest::get('post.eventsPerPage', 'int');

		$post['params']['subject_mail_new_event']= KRequest::get('post.subject_mail_new_event', 'string');
		$post['params']['text_mail_new_event']= KRequest::get('post.text_mail_new_event', 'raw');
		$post['params']['subject_mail_new_registration_organizer']= KRequest::get('post.subject_mail_new_registration_organizer', 'string');
		$post['params']['text_mail_new_registration_organizer']= KRequest::get('post.text_mail_new_registration_organizer', 'raw');
		$post['params']['subject_mail_new_registration_registrant']= KRequest::get('post.subject_mail_new_registration_registrant', 'string');
		$post['params']['text_mail_new_registration_registrant']= KRequest::get('post.text_mail_new_registration_registrant', 'raw');

		$post['params']['singleEventModulePosition1']= KRequest::get('post.singleEventModulePosition1', 'string');
		$post['params']['singleEventModulePosition2']= KRequest::get('post.singleEventModulePosition2', 'string');
		$post['params']['singleEventModulePosition3']= KRequest::get('post.singleEventModulePosition3', 'string');
		$post['params']['listEventsModulePosition1']= KRequest::get('post.listEventsModulePosition1', 'string');
		$post['params']['listEventsModulePosition2']= KRequest::get('post.listEventsModulePosition2', 'string');
		$post['params']['listEventsModulePosition3']= KRequest::get('post.listEventsModulePosition3', 'string');
		$post['params']['eventRegistrationModulePosition1']= KRequest::get('post.eventRegistrationModulePosition1', 'string');
		$post['params']['eventRegistrationModulePosition2']= KRequest::get('post.eventRegistrationModulePosition2', 'string');
		$post['params']['eventRegistrationModulePosition3']= KRequest::get('post.eventRegistrationModulePosition3', 'string');
		$post['params']['singleVenueModulePosition1']= KRequest::get('post.singleVenueModulePosition1', 'string');
		$post['params']['singleVenueModulePosition2']= KRequest::get('post.singleVenueModulePosition2', 'string');
		$post['params']['singleVenueModulePosition3']= KRequest::get('post.singleVenueModulePosition3', 'string');
		$post['params']['singleCategoryModulePosition1']= KRequest::get('post.singleCategoryModulePosition1', 'string');
		$post['params']['singleCategoryModulePosition2']= KRequest::get('post.singleCategoryModulePosition2', 'string');
		$post['params']['singleCategoryModulePosition3']= KRequest::get('post.singleCategoryModulePosition3', 'string');
		
		$post['params']['registration_system']= KRequest::get('post.registration_system', 'string');

		$post['params']['enableMailchimp']= KRequest::get('post.enableMailchimp', 'int');
		$post['params']['mailchimpApiKey']= KRequest::get('post.mailchimpApiKey', 'raw');

		$post['params']['commentsCode'] = htmlentities(KRequest::get('post.commentsCode', 'raw'));

		$post['params']['custom_field_label_1']= KRequest::get('post.custom_field_label_1', 'raw');
		$post['params']['custom_field_label_2']= KRequest::get('post.custom_field_label_2', 'raw');
		$post['params']['custom_field_label_3']= KRequest::get('post.custom_field_label_3', 'raw');
		$post['params']['custom_field_label_4']= KRequest::get('post.custom_field_label_4', 'raw');
		$post['params']['custom_field_label_5']= KRequest::get('post.custom_field_label_5', 'raw');
		$post['params']['custom_field_label_6']= KRequest::get('post.custom_field_label_6', 'raw');
		$post['params']['custom_field_label_7']= KRequest::get('post.custom_field_label_7', 'raw');
		$post['params']['custom_field_label_8']= KRequest::get('post.custom_field_label_8', 'raw');
		$post['params']['custom_field_label_9']= KRequest::get('post.custom_field_label_9', 'raw');
		$post['params']['custom_field_label_10']= KRequest::get('post.custom_field_label_10', 'raw');

		$post['params']['custom_field_label_1_checked']= KRequest::get('post.custom_field_label_1_checked', 'raw');
		$post['params']['custom_field_label_2_checked']= KRequest::get('post.custom_field_label_2_checked', 'raw');
		$post['params']['custom_field_label_3_checked']= KRequest::get('post.custom_field_label_3_checked', 'raw');
		$post['params']['custom_field_label_4_checked']= KRequest::get('post.custom_field_label_4_checked', 'raw');
		$post['params']['custom_field_label_5_checked']= KRequest::get('post.custom_field_label_5_checked', 'raw');
		$post['params']['custom_field_label_6_checked']= KRequest::get('post.custom_field_label_6_checked', 'raw');
		$post['params']['custom_field_label_7_checked']= KRequest::get('post.custom_field_label_7_checked', 'raw');
		$post['params']['custom_field_label_8_checked']= KRequest::get('post.custom_field_label_8_checked', 'raw');
		$post['params']['custom_field_label_9_checked']= KRequest::get('post.custom_field_label_9_checked', 'raw');
		$post['params']['custom_field_label_10_checked']= KRequest::get('post.custom_field_label_10_checked', 'raw');

		$post['params']['custom_field_label_1_mandatory']= KRequest::get('post.custom_field_label_1_mandatory', 'raw');
		$post['params']['custom_field_label_2_mandatory']= KRequest::get('post.custom_field_label_2_mandatory', 'raw');
		$post['params']['custom_field_label_3_mandatory']= KRequest::get('post.custom_field_label_3_mandatory', 'raw');
		$post['params']['custom_field_label_4_mandatory']= KRequest::get('post.custom_field_label_4_mandatory', 'raw');
		$post['params']['custom_field_label_5_mandatory']= KRequest::get('post.custom_field_label_5_mandatory', 'raw');
		$post['params']['custom_field_label_6_mandatory']= KRequest::get('post.custom_field_label_6_mandatory', 'raw');
		$post['params']['custom_field_label_7_mandatory']= KRequest::get('post.custom_field_label_7_mandatory', 'raw');
		$post['params']['custom_field_label_8_mandatory']= KRequest::get('post.custom_field_label_8_mandatory', 'raw');
		$post['params']['custom_field_label_9_mandatory']= KRequest::get('post.custom_field_label_9_mandatory', 'raw');
		$post['params']['custom_field_label_10_mandatory']= KRequest::get('post.custom_field_label_10_mandatory', 'raw');

		$post['params']['module_chrome']= KRequest::get('post.module_chrome', 'raw');
		$post['params']['moduleclass_sfx']= KRequest::get('post.moduleclass_sfx', 'raw');
		$post['params']['event_place_style']= KRequest::get('post.event_place_style', 'raw');

		$post['params']['destination_email']= KRequest::get('post.destination_email', 'raw');
		$post['params']['buttons_style']= KRequest::get('post.buttons_style', 'raw');

		// Checkboxes


		if (KRequest::get('post.disableModuleInjector', 'string') != null) $disableModuleInjector = 1; else $disableModuleInjector = 0;
		$post['params']['disableModuleInjector'] = $disableModuleInjector;

		if (KRequest::get('post.enableComments', 'string') != null) $enableComments = 1; else $enableComments = 0;
		$post['params']['enableComments'] = $enableComments;

		if (KRequest::get('post.moderation', 'string') != null) $moderation = 1; else $moderation = 0;
		$post['params']['moderation'] = $moderation;

		if (KRequest::get('post.enable_frontend', 'string') != null) $enable_frontend = 1; else $enable_frontend = 0;
		$post['params']['enable_frontend'] = $enable_frontend;

		if (KRequest::get('post.dst', 'string') != null) $dst = 1; else $dst = 0;
		$post['params']['dst'] = $dst;

		if (KRequest::get('post.enableEmailNewEventFrontend', 'string') != null) $enableEmailNewEventFrontend = 1; else $enableEmailNewEventFrontend = 0;
		$post['params']['enableEmailNewEventFrontend'] = $enableEmailNewEventFrontend;

		if (KRequest::get('post.enableEmailNewRegistration', 'string') != null) $enableEmailNewRegistration = 1; else $enableEmailNewRegistration = 0;
		$post['params']['enableEmailNewRegistration'] = $enableEmailNewRegistration;

		if (KRequest::get('post.enableEmailRegistrationConfirmation', 'string') != null) $enableEmailRegistrationConfirmation = 1; else $enableEmailRegistrationConfirmation = 0;
		$post['params']['enableEmailRegistrationConfirmation'] = $enableEmailRegistrationConfirmation;

		if (KRequest::get('post.showButtonFacebook', 'string') != null) $showButtonFacebook = 1; else $showButtonFacebook = 0;
		$post['params']['showButtonFacebook'] = $showButtonFacebook;
		if (KRequest::get('post.showButtonGoogle', 'string') != null) $showButtonGoogle = 1; else $showButtonGoogle = 0;
		$post['params']['showButtonGoogle'] = $showButtonGoogle;
		if (KRequest::get('post.showButtonTwitter', 'string') != null) $showButtonTwitter = 1; else $showButtonTwitter = 0;
		$post['params']['showButtonTwitter'] = $showButtonTwitter;
		
		if (KRequest::get('post.useStandardJoomlaEditor', 'string') != null) $useStandardJoomlaEditor = 1; else $useStandardJoomlaEditor = 0;
		$post['params']['useStandardJoomlaEditor'] = $useStandardJoomlaEditor;

		// End checkboxes

		$table->bind($post);
		$table->store();
	}

	protected function _actionSave(KCommandContext $context) 
	{
		$this->_save();
		$this->_message = JText::_('OHANAH_CHANGES_APPLIED');
	}
	protected function _actionApply(KCommandContext $context) 
	{
		$this->_save();
		$this->_message = JText::_('OHANAH_CHANGES_APPLIED');
	}
		
	public function getRedirect()
	{
		$action = KRequest::get('post.action', 'string');
		if ($action == "save") 
		{
			$url = 'index.php?option=com_ohanah&view=events';
			
			return $result = array(
				'url' 			=> JRoute::_($url, false),
				'message' 		=> $this->_message,
				'messageType' 	=> $this->_messageType
			);
		} elseif ($action == "apply") 
		{
			$url = 'index.php?option=com_ohanah&view=config';
			
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