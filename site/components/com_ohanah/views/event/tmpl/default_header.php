<? defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?
if (!$event->id && $id = $pageparameters->get('id')) {
	$event = $this->getService('com://site/ohanah.model.events')->set('id', $id)->getItem();
}
?>

<script src="media://com_ohanah/jquery-lightbox-0.5/js/jquery.lightbox-0.5.min.js" />
<style src="media://com_ohanah/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" />

<script>
	var $jq = jQuery.noConflict();  
	$jq(function() {
		$jq('a.ohanah_modal').lightBox({fixedNavigation:true});
	});
</script>

<? $params = JComponentHelper::getParams('com_ohanah') ?>
<div class="event_detail_container" itemscope itemtype="http://schema.org/Event">
	
	
	<? if ($event->picture) : ?>
		<a class="ohanah_modal" href="media://com_ohanah/attachments/<?=$event->picture?>"  itemprop="image"><div class="event-photos" style="background: url('media://com_ohanah/attachments_thumbs/<?=$event->picture?>'); background-size: 100% 100%"></div></a>
	<? endif ?>

	<div class="event_detail_title">
		<? if ($params->get('itemid')) $itemid = '&Itemid='.$params->get('itemid'); else $itemid = ''; ?>
		<? if (KRequest::get('get.view', 'string') == 'events' || isset($module)) : ?>
			<h2 itemprop="name"><a href="<?=@route('option=com_ohanah&view=event&id='.$event->id.$itemid)?>" itemprop="url"><?=$event->title?></a></h2>
		<? endif ?>
	</div>

	<? if (JFactory::getApplication()->getPageParameters('com_ohanah')->get('showTime') != '0') : ?>
		<div class="event_detail_time">
			<div class="date_icon"></div>
			<h3>
				<?
				if (JFactory::getApplication()->getPageParameters('com_ohanah')->get('timeFormat') == '1') { //12 hours
					$start_time = date("g:i a", strtotime($event->start_time));	
					$end_time = date("g:i a", strtotime($event->end_time));	
				} else {
					$start_time = date("H:i", strtotime($event->start_time));	
					$end_time = date("H:i", strtotime($event->end_time));	
				}
				?>

				<?= @helper('date.format', array('date' => $event->date, 'format' => '%d', 'gmt_offset' => '0'));?>
				<?= JText::_(@helper('date.format', array('date' => $event->date, 'format' => '%B', 'gmt_offset' => '0')));?>
				<?=@helper('date.format', array('date' => $event->date, 'format' => '%Y', 'gmt_offset' => '0'));?>

				<?=$start_time?>
				

				<? if ($event->end_time_enabled) : ?>
					- 

					<? if (substr($event->date, 0, 10) == substr($event->end_date, 0, 10)) : ?>
						<? if ($start_time != $end_time) : ?>
							<?=$end_time?>
						<? endif ?>
					<? else : ?>
						<?= @helper('date.format', array('date' => $event->end_date, 'format' => '%d', 'gmt_offset' => '0'));?>
						<?= JText::_(@helper('date.format', array('date' => $event->end_date, 'format' => '%B', 'gmt_offset' => '0')));?>
						<?=@helper('date.format', array('date' => $event->end_date, 'format' => '%Y', 'gmt_offset' => '0'));?>

						<?=$end_time?>
					<? endif ?>
				<? endif ?>

				(<a href="<?=@route('option=com_ohanah&view=event&id='.$event->id.'&format=ics')?>"><?=@text('OHANAH_SAVE_TO_CAL')?></a>)

			</h3>
			<div style="display:none"><span itemprop="startDate"><?=$event->date?></span></div>
			<div style="display:none"><span itemprop="endDate"><?=$event->end_date?></span></div>
		</div>
	<? endif; ?>

	<div class="event_detail_location">
		<? $event_place_style = $params->get('event_place_style') ?>
		<div class="location_icon"></div>

		<h3 itemprop="location">
			<? if (!$event->ohanah_venue_id && !$event->geolocated_country && !$event->geolocated_city) : ?>
				TBA
			<? else : ?>
				<? if ($event_place_style == 'venue') : ?>
					<?=@service('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?>
				<? elseif ($event_place_style == 'venue_and_city') : ?>
					<?=@service('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?><? if ($event->geolocated_city) : ?>, <?=$event->geolocated_city?><? endif ?>
				<? elseif ($event_place_style == 'address') : ?>
					<?=$event->address?>
				<? elseif ($event_place_style == 'venue_and_address') : ?>
					<?=@service('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?> @ <?=$event->address?>
				<? elseif ($event_place_style == 'city_and_country') : ?>
					<? if ($event->geolocated_city) : ?><?=$event->geolocated_city?><?endif?><? if ($event->geolocated_country && $event->geolocated_city) : ?>, <?endif?><? if ($event->geolocated_country) : ?><?=$event->geolocated_country?><? endif ?>
				<? elseif ($event_place_style == 'city_and_state') : ?>
					<? if ($event->geolocated_city) : ?><?=$event->geolocated_city?><?endif?><? if ($event->geolocated_state && $event->geolocated_city) : ?>, <?endif?><? if ($event->geolocated_state) : ?><?=$event->geolocated_state?><? endif ?>
				<? elseif ($event_place_style == 'city_state_and_country') : ?>
					<? if ($event->geolocated_city) : ?><?=$event->geolocated_city?><?endif?><? if ($event->geolocated_state && $event->geolocated_city) : ?>, <?=$event->geolocated_state?><?endif?><? if ($event->geolocated_country && ($event->geolocated_city || $event->geolocated_state)) : ?>, <?endif?><? if ($event->geolocated_country) : ?><?=$event->geolocated_country?><? endif ?>
				<? endif ?>
			<? endif ?>
		</h3>

	</div>

	<? if (KRequest::get('get.view', 'string') == 'event') : ?>

		<? if ($params->get('showButtonTwitter')) : ?>
			<div style="float: left; ">
				<a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
				<script src="http://platform.twitter.com/widgets.js" />
			</div>
		<? endif ?>
		<? if ($params->get('showButtonGoogle')) : ?>
			<div style="float: left; margin-left:10px">
				<g:plusone size="medium" annotation="none"></g:plusone>
				<script type="text/javascript">
				  (function() {
				    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				    po.src = 'https://apis.google.com/js/plusone.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
			</div>
		<? endif ?>
		<? if ($params->get('showButtonFacebook')) : ?>
			<div style="float: left; margin-left:10px">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) {return;}
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>

				<div class="fb-like" data-send="false" data-layout="button_count" data-width="40" data-show-faces="true"></div>
			</div>
		<? endif ?>	
		
		<br /><br />
		
	<? endif ?>

	

	<? if (KRequest::get('get.view', 'string') != 'event'  || isset($module)) : ?>
		<? $desc = strip_tags($event->description); ?>
		<? $desc = preg_replace("/\{[^\)]+\}/","", $desc) ?>
		<? $desc = strip_tags(substr($desc, 0, 200), '<p><ul><li><b><i><strong><br>')?> <? if (strlen($desc) > 200) echo '...'; ?>
		<div itemprop="description" class="ohanah-event-short-description">
		<?=$desc?>
		</div>
	<? else : ?>

		<?
		$description = $event->description;

		// Create temporary article
   		$item =& JTable::getInstance('content');
   		$item->parameters = new JParameter('');
   		$item->text = $description;

		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
		if ($joomlaVersion == '1.5') { 
			$results = JFactory::getApplication()->triggerEvent('onPrepareContent', array (&$item, &$params, 1));
		} else {
			$dispatcher	= JDispatcher::getInstance();
			JPluginHelper::importPlugin('content');
			$results = $dispatcher->trigger('onContentPrepare', array ('com_content.article', &$item, &$params, 1));
		}	
   		$description = $item->text;		
		?>
		<div style="display:none"><span itemprop="name"><?=$event->title?></span></div>
		<div itemprop="description" class="ohanah-event-full-description">
		<?=$description?>
		</div>
	<? endif ?>

	<br /><br />	
	<div id="event-container-">

			

		<? if (KRequest::get('get.view', 'string') != 'registration') : ?>
			<span style="float: right; padding-left:8px">
				<? if (KRequest::get('get.view', 'string') == 'event' && !isset($module)) : ?>
					<? if ($event->who_can_register == '0' || ($event->who_can_register == '1' && !JFactory::getUser()->guest)) : ?>
						<? 
						if ($event->get('payment_gateway') != 'none' && $event->ticket_cost) $text = @text('OHANAH_BUY_TICKETS');
						else $text = @text('OHANAH_REGISTER');
						?>

						<? if ($event->limit_number_of_attendees || $event->ticket_cost) : ?>&nbsp;&nbsp;<? endif ?>

						<? if ($event->registration_system == 'custom') : ?>
							<? if ($event->custom_registration_url) : ?>
								<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'link', 'text' => $text, 'link' => $event->custom_registration_url)); ?>
							<? endif ?>
						<? else : ?>
							<? if (!$event->limit_number_of_attendees or $event->countAttendees() < $event->attendees_limit) : ?>
								<? $date = new KDate(); ?>
								<? if ($event->isPast() || ($event->ticketing_end_date != '0000-00-00' && $date->format('%Y-%m-%d') > $event->ticketing_end_date)) : ?>
								<? else : ?>
									<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'link', 'text' => $text, 'link' => @route('option=com_ohanah&view=registration&ohanah_event_id='.$event->id.$itemid))); ?>
								<? endif ?>
							<? else : ?>
								&nbsp;&nbsp;|&nbsp;&nbsp;<?=@text('OHANAH_TICKETS_SOLD_OUT')?>
							<? endif; ?>
						<? endif ?>
					<? endif ?>
				<? elseif (KRequest::get('get.view', 'string') == 'events' || isset($module)) : ?>
					<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'link', 'text' => @text('OHANAH_READ_MORE'), 'link' => @route('option=com_ohanah&view=event&id='.$event->id.$itemid))); ?>
				<? endif ?>
			</span>
		<? elseif (isset($module)) : ?>
			<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'link', 'text' => @text('OHANAH_READ_MORE'), 'link' => @route('option=com_ohanah&view=event&id='.$event->id.$itemid))); ?>
		<? endif ?>

		<? if (!$event->isPast()) : ?>
			<? if ($event->limit_number_of_attendees) : ?>
				<span class="ohanah-event-places-left" style="float: right"><?=@text('OHANAH_PLACES_LEFT')?>: <? $diff = ($event->attendees_limit - $event->countAttendees()); if ($diff < 0) $diff = 0; echo $diff ?></span>
				<span class="ohanah-event-places-left" style="float: right">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>
			<? endif ?>
		
			<span class="ohanah-event-ticket-cost" style="float: right"><?=@text('OHANAH_TICKET_COST')?>: <? if ($event->ticket_cost) : ?><?=$event->ticket_cost?> <?=$event->payment_currency?><? else : ?><?=@text('OHANAH_FREE')?><? endif ?></span><div class="ticket_icon" style="float: right"></div>
		<? endif ?>

		<span class="ohanah-event-category-link" style="float: left"><a href="<?=@route('option=com_ohanah&view=events&ohanah_category_id='.$event->ohanah_category_id.'&ohanah_venue_id=&filterEvents=notpast'.$itemid)?>"><?=@service('com://site/ohanah.model.categories')->id($event->ohanah_category_id)->getItem()->title?></a></span>
		<? if ($event->ohanah_venue_id) : ?><span class="ohanah-event-venue-link"style="float: left">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;@ <a href="<?=@route('option=com_ohanah&view=events&ohanah_venue_id='.$event->ohanah_venue_id.'&ohanah_category_id=&filterEvents=notpast'.$itemid)?>"><?=@service('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?></a></span><? endif ?>
		<? if ($event->isRecurring()) : ?><span class="ohanah-event-recurrent-link">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>
			<? if ($event->recurringParent) : ?>
				<span class="ohanah-event-recurrent-link"><a href="<?=@route('option=com_ohanah&view=events&recurringParent='.$event->recurringParent.$itemid)?>"><?=@text('OHANAH_RECURRING_SET')?></a><span>
			<? else : ?>
				<span class="ohanah-event-recurrent-link"><a href="<?=@route('option=com_ohanah&view=events&recurringParent='.$event->id.$itemid)?>"><?=@text('OHANAH_RECURRING_SET')?></a><span>
			<? endif ?>
		<? endif ?>
	</div>
	<br /><br />
</div>