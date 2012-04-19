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

class ComOhanahControllerCommon extends ComDefaultControllerDefault
{
	public function setMessage(KCommandContext $context)
	{}

	protected function _createThumb($file)
	{
		if (extension_loaded('gd') && function_exists('gd_info')) { //Create thumb only if GD Library is installed
			$thumbpath = JPATH_ROOT.DS.'media/com_ohanah/attachments_thumbs'.DS.$file;
			
			$image = new SimpleImage();
			$image->load(JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$file);
			
			list($width, $height, $type, $attr) = getimagesize(JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$file);
			
			if($width > $height) {
				$image->resizeToWidth(167);
			} else {
				$image->resizeToHeight(114);
			}

			$image->save($thumbpath);
		}
	}
	
	protected function _processImages($target_type, $temp_id, $real_id)
	{
		$images = KService::get('com://admin/ohanah.model.attachments')->set('target_type', $target_type)->set('target_id', $temp_id)->getList();

		foreach ($images as $image) {
			$image->target_type = str_replace('temp_', '', $image->target_type);
			$image->target_id = $real_id;
			$image->save();
		}
	}	
	
	public function reverseGeocode($data)
	{ 
		$latlng = KRequest::get('post.latlng', 'string');
		if (!$latlng && KRequest::get('post.latitude', 'string') && KRequest::get('post.longitude', 'string')) $latlng = KRequest::get('post.latitude', 'string').','.KRequest::get('post.longitude', 'string');

		if ($latlng) 
		{
			$config =& JFactory::getConfig();
			$language = $config->getValue('config.language');
			
			$languagesSupportedByGoogleMaps = array('ar', 'bg', 'bn', 'ca', 'cs', 'da', 'de', 'el', 'en', 'en-AU', 'en-GB', 'es', 'eu', 'fa', 'fi', 'fi', 'fr', 'gl', 'gu', 'hi', 'hr', 'hu', 'id', 'it', 'iw', 'ja', 'kn', 'ko', 'lt', 'lv', 'ml', 'mr', 'nl', 'nn', 'no', 'or', 'pl', 'pt', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'sr', 'sv', 'tl', 'ta', 'te', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-TW');
			
			if (!in_array($language, $languagesSupportedByGoogleMaps)) {
				$language = substr($language, 0, 2);
			}
			
			if (!in_array($language, $languagesSupportedByGoogleMaps)) {
				$language = 'en';
			}
			
			//Geocode city and country
			$param = 'latlng='.$latlng.'&sensor=false&language='.$language;
			
			//get the url
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json' . '?' . $param);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			curl_close($ch);
			
			$json = @json_decode($response,true);
			
			$results = ($json['results'][0]['address_components']);
			
			if ($results) foreach ($results as $result)
			{
				if ($result['types'][0] == 'locality')
				{
					$data['geolocated_city'] = $result['long_name'];
				}
				if ($result['types'][0] == 'country')
				{
					$data['geolocated_country'] = $result['long_name'];
				}
				if ($result['types'][0] == 'administrative_area_level_1') 
				{ 
					$data['geolocated_state'] = $result['long_name'];
				}
			}
		}

		return $data;
	}
	
	protected function _processVenue($data)
	{
		$data['venue'] = trim($data['venue']);
		if ($data['venue'])
		{	
			if (!$this->getService('com://admin/ohanah.model.venues')->set('title', $data['venue'])->getTotal()) {

				$this->getService('com://admin/ohanah.model.venues')
					->getItem()
					->set('title', $data['venue'])
					->set('address', $data['address'])
					->set('latitude', $data['latitude'])
					->set('longitude', $data['longitude'])
					->set('timezone', $data['timezone'])
					->set('geolocated_city', $data['geolocated_city'])
					->set('geolocated_country', $data['geolocated_country'])
					->save();
			}

			$venue = reset($this->getService('com://admin/ohanah.model.venues')->set('title', $data['venue'])->getList()->getData());
			$data['ohanah_venue_id'] = $venue['id'];
		}

		return $data;
	}
	
	protected function _actionDeleteheader(KCommandContext $context) 
	{
		$data = $context->data;
		$data['header'] = '0';
		$context->data = $data;
		$row = parent::_actionEdit($context);
	}
		
	protected function _saveFile($file, $target_type, $target_id)
	{
		if (JFile::exists($file['tmp_name']))
		{
			$fileSafeName = JFile::makeSafe($file['name']);
			$randomNumber = rand();
			if (JFile::upload($file['tmp_name'], JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$randomNumber.'-'.$fileSafeName)) {
				$fileName = $randomNumber.'-'.$fileSafeName;
				$this->_createThumb($fileName);
				
				$attachment = $this->getService('com://admin/ohanah.model.attachments')->getItem();
				$attachment->name = $randomNumber.'-'.$fileSafeName;
				$attachment->target_type = $target_type;
				$attachment->target_id = $target_id;
				$attachment->setStatus(NULL);
				$attachment->save();
			}
			else
				JError::raiseWarning(0, 'Could not upload file');			
		}
	}
}

/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/
 
class SimpleImage {
   
	var $image;
   	var $image_type;
 
   	function load($filename) {
      	$image_info = getimagesize($filename);
      	$this->image_type = $image_info[2];
      	if( $this->image_type == IMAGETYPE_JPEG ) {
         	$this->image = imagecreatefromjpeg($filename);
      	} elseif( $this->image_type == IMAGETYPE_GIF ) {
         	$this->image = imagecreatefromgif($filename);
      	} elseif( $this->image_type == IMAGETYPE_PNG ) {
         	$this->image = imagecreatefrompng($filename);
      	}
   	}
   
	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      	if( $image_type == IMAGETYPE_JPEG ) {
         	imagejpeg($this->image,$filename,$compression);
      	} elseif( $image_type == IMAGETYPE_GIF ) {
         	imagegif($this->image,$filename);         
      	} elseif( $image_type == IMAGETYPE_PNG ) {
         	imagepng($this->image,$filename);
      	}   
      	if( $permissions != null) {
         	chmod($filename,$permissions);
      	}
   	}
   
	function output($image_type=IMAGETYPE_JPEG) {
      	if( $image_type == IMAGETYPE_JPEG ) {
         	imagejpeg($this->image);
      	} elseif( $image_type == IMAGETYPE_GIF ) {
         	imagegif($this->image);         
      	} elseif( $image_type == IMAGETYPE_PNG ) {
         	imagepng($this->image);
      	}   
   	}

   	function getWidth() {
      	return imagesx($this->image);
   	}

   	function getHeight() {
      	return imagesy($this->image);
   	}

   	function resizeToHeight($height) {
      	$ratio = $height / $this->getHeight();
      	$width = $this->getWidth() * $ratio;
      	$this->resize($width,$height);
   	}

   	function resizeToWidth($width) {
      	$ratio = $width / $this->getWidth();
      	$height = $this->getheight() * $ratio;
      	$this->resize($width,$height);
   	}

   	function scale($scale) {
      	$width = $this->getWidth() * $scale/100;
      	$height = $this->getheight() * $scale/100; 
      	$this->resize($width,$height);
   	}
   	
	function resize($width,$height) {
      	$new_image = imagecreatetruecolor($width, $height);
      	imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      	$this->image = $new_image;   
   	}
}