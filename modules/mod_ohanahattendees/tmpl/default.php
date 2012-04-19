<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if (JComponentHelper::getParams('com_ohanah')->get('showAttendees') != '0') : ?>
		<div class="who_container">
			<div class="who_avatars">
				<? $attendees = $event->getAttendees() ?>
				<? if (count($attendees)) : ?>
					<? foreach ($attendees as $registration) : ?>
						<? if (!$event->ticket_cost || ($must_pay_to_be_listed_as_attendee_in_paid_events == '0' || ($registration->paid))) : ?>
							<? if ($listStyle == 'both' || $listStyle == 'avatars') : ?>
								<?= $registration->getGravatar() ?>		
							<? endif; ?>
							<? if ($listStyle == 'both' || $listStyle == 'names') : ?>
								<span><?=$registration->name?></span>
							<? endif; ?>
							<hr />
						<? endif ?>
					<? endforeach; ?>
				<? else : ?>
					<?=@text('OHANAH_NO_CONFIRMED_ATTENDEES_YET')?> <br /> <a href="<?=@route('option=com_ohanah&view=registration&ohanah_event_id='.$event->id)?>"><?=@text('OHANAH_BE_THE_FIRST_TO_JOIN')?></a>
				<? endif; ?>
			</div>
		</div>
	<? endif; ?>
</div>