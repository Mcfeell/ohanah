<? defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?=@helper('behavior.mootools'); ?>
<script src="media://lib_koowa/js/koowa.js" />

<div class="ohanah event-<?=$event->id?>" >
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-event-1', 'position' => $params->get('singleEventModulePosition1'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-event-2', 'position' => $params->get('singleEventModulePosition2'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-event-3', 'position' => $params->get('singleEventModulePosition3'))) ?>

	<? if (($params->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
		<script src="media://com_ohanah/js/jquery.min.js" />
		<? JFactory::getApplication()->set('jquery', true); ?>
	<? endif; ?>

	<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
	<style src="media://com_ohanah/css/jquery-ui.css" />
	<style src="media://com_ohanah/css/screen.css" />

	<?= @template('default_header', array('event' => $event)); ?>
	
	<? if ($params->get('enableComments')) : ?>
		<?= html_entity_decode($params->get('commentsCode')); ?>
	<? endif ?>
</div>