<div class="panelContent">
	<table>
		<tr>
			<span class="fieldTitle"><input type="checkbox" name="enable_frontend" value="0" <? if ($params->enable_frontend == '1') echo 'checked' ?> /><?=@text('OHANAH_ALLOW_FRONTEND_SUBMISSION_OF_EVENTS'); ?></span><br/>
		</tr>
		<tr>
			<span class="fieldTitle"><input type="checkbox" name="moderation" value="0" <? if ($params->moderation == '1') echo 'checked' ?> /><?=@text('OHANAH_AUTO_PUBLISH_FRONTEND_EVENTS'); ?></span><br/>
		</tr>
		<tr>
			<span class="fieldTitle">URL to redirect users after they add an event</span><br/><input type="text" id="redirect_after_add_event" name="redirect_after_add_event" class="text" value="<?=$params->redirect_after_add_event?>" />
		</tr>
	</table>
</div>