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

class ComOhanahControllerAttachment extends ComOhanahControllerCommon 
{
	protected function _saveFile($file, $target_type, $target_id) {
		if (JFile::exists($file['tmp_name'])) {
			$fileSafeName = JFile::makeSafe($file['name']);

			$allowed_images_extensions = array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');

			if (in_array(JFile::getExt($fileSafeName), $allowed_images_extensions))
			{
				$randomNumber = rand();
				if (JFile::upload($file['tmp_name'], JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$randomNumber.'-'.$fileSafeName)) {
					$file_name = $randomNumber.'-'.$fileSafeName;
					$this->_createThumb($file_name);
					return $file_name;
				} else return false;
			} else return false;
		}
	}
	
	protected function _createThumb($file) {
		if (extension_loaded('gd') && function_exists('gd_info')) { //Create thumb only if GD Library is installed
			$thumbpath = JPATH_ROOT.DS.'media/com_ohanah/attachments_thumbs'.DS.$file;
			
			$image = new SimpleImage();
			$image->load(JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$file);
			
			list($width, $height, $type, $attr) = getimagesize(JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$file);
			
			if ($width > $height) {
				$image->resizeToWidth(167);
			} else {
				$image->resizeToHeight(114);
			}

			$image->save($thumbpath);
		}
	}

	protected function _actionAdd(KCommandContext $context) {
		$data = $context->data;
		unset($data->id);

		if ($data->random_id) {
			$data->target_type = 'temp_'.$data->target_type;
			$data->target_id = $data->random_id;
		}

		$returnValue = '';

		if ($data->imageType == 'picture') {
			$returnValue = $this->_saveFile($_FILES['pictureUpload'], $data->target_type, $data->target_id);
		} elseif ($data->imageType == 'photo') {
			$returnValue = $this->_saveFile($_FILES['photoUpload'], $data->target_type, $data->target_id);
		}

		if ($returnValue) {
			$data->name = $returnValue;

			$context->data = $data;
			parent::_actionAdd($context);
		}

		echo $returnValue;
		exit();
	}

	protected function _actionDeleteimage(KCommandContext $context)
	{
		$data = $context->data;
		unset($data->description);

		$images = $this->getService('com://admin/ohanah.model.attachments')->set('target_type', $data->target_type)->set('target_id', $data->target_id)->set('name', $data->name)->getList();

		foreach ($images as $image) {
	 		JFile::delete(JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$image->name);
	 		JFile::delete(JPATH_ROOT.DS.'media/com_ohanah/attachments_thumbs'.DS.$image->name);
	
	 		$image->delete();
	 	}		
	}
}
