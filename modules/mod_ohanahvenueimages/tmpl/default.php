<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? $images = @service('com://admin/ohanah.model.attachments')->set('target_type', 'venue')->set('target_id', $venue->id)->getList() ?>
 
 	<? if (count($images)) : ?>
 		<? foreach ($images as $image) : ?>
			<? if ($image->name != $venue->picture) : ?>
				<a class="ohanah_modal" href="media://com_ohanah/attachments/<?=$image->name?>"><div class="event-photos" style="background: url('media://com_ohanah/attachments_thumbs/<?=$image->name?>');"></div></a>
			<? endif ?>
		<? endforeach ?>
	<? endif ?>
</div>