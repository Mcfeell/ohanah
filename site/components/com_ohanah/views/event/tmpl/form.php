<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<? if (JComponentHelper::getParams('com_ohanah')->get('enable_frontend')) : ?>

	<?
	// Load language file
	$lang = &JFactory::getLanguage();
	$lang->load('com_ohanah');
	$lang->load('com_ohanah', JPATH_ADMINISTRATOR);
	?>

	<style src="media://com_ohanah/v2/frontend-event-form.css" />
	<div class="panelContent">

		<? if (($params->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
			<script src="media://com_ohanah/js/jquery.min.js" />
			<? JFactory::getApplication()->set('jquery', true); ?>
		<? endif; ?>

		<?=@helper('behavior.mootools'); ?>
		<?=@helper('behavior.validator') ?>
		<script src="media://lib_koowa/js/koowa.js" />
		<script src="media://com_ohanah/js/jquery.cleditor.min.js" />
		<script src="media://com_ohanah/js/jquery.maskedinput-1.3.min.js" />
		<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
		<script src="media://com_ohanah/js/jquery.form.js" />
		<script src="media://com_ohanah/js/si.files.js" />

		<style src="media://com_ohanah/v2/ohanah_css/custom-theme/jquery-ui-1.8.14.custom.css" />
		<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
		<style src="media://com_ohanah/v2/ohanah_css/jquery.cleditor.css" />

		<?= @template('com://admin/ohanah.view.common.images', array('item' => $event, 'name' => 'event')); ?>

		<script>
			var $jq = jQuery.noConflict();  
		</script>

		<script>
			function check_times() {
				if ($jq('#end_date').val() == $jq('#ohdate').val()) { 					
					if ($jq('select[name="end_time"]').val() < $jq('select[name="start_time"]').val()) {
						$jq('select[name="end_time"]').val($jq('select[name="start_time"]').val());	
					}
				}
			}
			
			$jq(function() {
			   	$jq("#description_textarea").cleditor({ width: 612, height: 113, controls: "bold italic underline bullets link unlink source"});

				//SHORT URL FUNCTIONS
				$jq( "#slugEdit" ).click(function() {
					$jq( "#slug" ).css('left', '0px');
					$jq( "#slugContainer" ).css('opacity', '0');
				});

				$jq( "#slug" ).bind('keypress', function(e) {
					var code = (e.keyCode ? e.keyCode : e.which);
					if(code == 13) { //ENTER KEY PRESSED
						$jq( ".slug" ).html($jq( "#slug" ).val());
						$jq( "#slug" ).css('left', '-9999px');
						$jq( "#slugContainer" ).css('opacity', '100');
					}
				});
				
				//DATE ELEMENTS
				$jq( ".cal1" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
				$jq( ".cal2" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
				$jq( ".cal3" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
				$jq( ".cal4" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
				$jq( ".cal5" ).datepicker({ dateFormat: 'yy-mm-dd', showAnim: '' });
				
				$jq( ".cal1" ).focus(function() {
					$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
					$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
					$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
					$jq( "#calendarTab" ).css('display', 'block');
				});
				$jq( ".cal2" ).focus(function() {
					$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
					$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
					$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
					$jq( "#calendarTab" ).css('display', 'block');
				});
				$jq( ".cal3" ).focus(function() {
					$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
					$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
					$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
					$jq( "#calendarTab" ).css('display', 'block');
				});
				$jq( ".cal4" ).focus(function() {
					$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
					$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
					$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
					$jq( "#calendarTab" ).css('display', 'block');
				});
				$jq( ".cal5" ).focus(function() {
					$jq( "#calendarTab" ).css('top', $jq( "#ui-datepicker-div" ).css('top'));
					$jq( "#calendarTab" ).css('left', $jq( "#ui-datepicker-div" ).css('left'));
					$jq( "#calendarTab" ).css('width', $jq( "#ui-datepicker-div" ).css('width'));
					$jq( "#calendarTab" ).css('display', 'block');
				});
				
				$jq( ".cal1" ).blur(function() {
					$jq( "#calendarTab" ).css('display', 'none');
					$jq( ".cal1" ).css('color', '#000');
				});
				$jq( ".cal2" ).blur(function() {
					$jq( "#calendarTab" ).css('display', 'none');
					$jq( ".cal2" ).css('color', '#000');
				});
				$jq( ".cal3" ).blur(function() {
					$jq( "#calendarTab" ).css('display', 'none');
					$jq( ".cal3" ).css('color', '#000');
				});
				$jq( ".cal4" ).blur(function() {
					$jq( "#calendarTab" ).css('display', 'none');
					$jq( ".cal4" ).css('color', '#000');
				});
				$jq( ".cal5" ).blur(function() {
					$jq( "#calendarTab" ).css('display', 'none');
					$jq( ".cal5" ).css('color', '#000');
				});
				
				//TIME ELEMENTS
				$jq('.time1').focus(function() { $jq(".time1").mask("99:99"); });
				$jq('.time2').focus(function() { $jq(".time2").mask("99:99"); });
				$jq('.time3').focus(function() { $jq(".time3").mask("99:99"); });
				$jq('.time4').focus(function() { $jq(".time4").mask("99:99"); });
				$jq('.time5').focus(function() { $jq(".time5").mask("9"); });
				
				$jq('.time1').blur(function() { $jq( ".time1" ).css('color', '#000'); });
				$jq('.time2').blur(function() { $jq( ".time2" ).css('color', '#000'); });
				$jq('.time3').blur(function() { $jq( ".time3" ).css('color', '#000'); });
				$jq('.time4').blur(function() { $jq( ".time4" ).css('color', '#000'); });
				$jq('.time5').blur(function() { $jq( ".time5" ).css('color', '#000'); });
				
				//DISABLE DATEPICKER VARIABLE POSITION
				$jq.extend($jq.datepicker,{_checkOffset:function(inst,offset,isFixed){return offset}});
				
				//TURN OFF DATEPICKER ON WINDOW RESIZE
				$jq(window).resize(function() {
					var field = $jq(document.activeElement);
					if (field.is('.cal1')) { field.datepicker('hide').datepicker('show'); }
					if (field.is('#cal2')) { field.datepicker('hide').datepicker('show'); }
					if (field.is('#cal3')) { field.datepicker('hide').datepicker('show'); }
					if (field.is('#cal4')) { field.datepicker('hide').datepicker('show'); }
					if (field.is('#cal5')) { field.datepicker('hide').datepicker('show'); }
				});
				
				//INTERACTIVE FIELDS
				$jq('select[name="limit_number_of_attendees"]').change(function(){
					if ($jq(this).attr('value')=="1") { $jq('#attendees_limit').css('display', 'inline'); } 
					else { $jq('#attendees_limit').css('display', 'none'); }
				});
				
				<? if (!$event->limit_number_of_attendees) : ?>
					$jq('#attendees_limit').css('display', 'none');
				<? endif ?>

				$jq('select[name="isRecurring"]').change(function(){
					if($jq(this).attr('value')=="1") {
						$jq('#recurrCount').css('display', 'inline');
						$jq('#recurrPeriod').css('display', 'inline');
						$jq('#recurrEnd').css('display', 'inline');
					} else {
						$jq('#recurrCount').css('display', 'none');
						$jq('#recurrPeriod').css('display', 'none');
						$jq('#recurrEnd').css('display', 'none');
					}
				});
				
				<? if (!$event->end_time_enabled) : ?>
					$jq('#end_timer').css('display', 'none');
					$jq('#end_date').css('display', 'none');
				<? endif ?>

				$jq('input[name="end_time_enabled"]').change(function(){
					if($jq(this).is(":checked")) {
						$jq('#end_date').css('display', 'inline');
						$jq('#end_timer').css('display', 'inline');
						var currentStartIndex = $jq('#start_timer select').prop('selectedIndex');
						var newEndIndex = (currentStartIndex + 6);
						if (newEndIndex > 47) {
							newEndIndex = newEndIndex - 48;


						  	var date2 = $jq('#ohdate').datepicker('getDate', '+1d'); 
						  	date2.setDate(date2.getDate()+1); 
						  	$jq('#end_date').datepicker('setDate', date2);
						} else {
						  	var date2 = $jq('#ohdate').datepicker('getDate'); 
						  	$jq('#end_date').datepicker('setDate', date2);

						}

						$jq('#end_timer select').prop('selectedIndex', newEndIndex);
					} else {
						$jq('#end_timer').css('display', 'none');
						$jq('#end_date').css('display', 'none');
					}
				});

				$jq('#end_date').change(function() {
					if ($jq('#end_date').val() < $jq('#ohdate').val()) { 
						alert('End date must be after start date');
						$jq('#end_date').val($jq('#ohdate').val());
					}
					check_times();
				});

				$jq('#ohdate').change(function() {
					if ($jq('#end_date').val() < $jq('#ohdate').val()) { 
						$jq('#end_date').val($jq('#ohdate').val());
					}
					check_times();
				});

				$jq('select[name="start_time"]').change(function() {
					check_times();
				});
				$jq('select[name="end_time"]').change(function() {
					check_times();
				});
			});
		</script>

		<form action="" method="post" class="form-validate -koowa-form" id="edit-form" enctype="multipart/form-data">

			<input type="hidden" name="id" value="<?=$event->id?>" />
			<? JUtility::getToken() ?>

			<? if (!$event->id) : ?>
				<input type="hidden" id="random_id" name="random_id" value="<?=rand()%5000?>" />
			<? endif ?>

			<input type="hidden" id="latlng" name="latlng" />
			<input type="hidden" name="registration_system" value="custom" />

			<div class="clr"></div>
					
			<div id="eventWrapper" class="clearfix">
				<div id="panelWrapper">
					<div id="adminLeft">
						<div class="panel">
							<div class="panelContent">
								<table>
									<tr <? if (!JFactory::getUser()->guest) : ?>style="display:none"<?endif?>>
										<td>
											<? $default = ''; if ($event->created_by_name) { $default = $event->created_by_name; } elseif (!JFactory::getUser()->guest) { $default = JFactory::getUser()->name; } ?>
											<span class="fieldTitle"><?=@text('OHANAH_YOUR_NAME')?></span><br/><input type="text" id="created_by_name" name="created_by_name" class="text required" value="<?=htmlspecialchars(@$default)?>" />
										</td>
										<td>
											<? $default = ''; if ($event->created_by_email) { $default = $event->created_by_email; } elseif (!JFactory::getUser()->guest) { $default = JFactory::getUser()->email; } ?>
											<span class="fieldTitle"><?=@text('OHANAH_YOUR_EMAIL')?></span><br/><input style="width:230px;" type="text" id="created_by_email" name="created_by_email" class="text required validate-email" value="<?=htmlspecialchars(@$default)?>" />
										</td>
									</tr>
									<tr>
										<td style="width:60%;" >
											<span class="fieldTitle"><?=@text('OHANAH_TITLE')?></span><br/><input type="text" id="title" name="title" class="text required" value="<?=htmlspecialchars(@$event->title)?>" />
										</td>

										<td>
											<span class="fieldTitle">&nbsp;</span><br/>
											<div class="dropdownWrapper">
												<div class="dropdown size1">
													<?=@helper('com://admin/ohanah.template.helper.listbox.categories', array('selected' => $event->ohanah_category_id)) ?>
												</div>
											</div>
										</td>
									</tr>
									<? if ($event->id) : ?>
									<tr>
										<td colspan="2">
											<div class="small" id="slugContainer">http://<?=$_SERVER['HTTP_HOST'].KRequest::base()?>/<span class="slug"><?=htmlspecialchars(@$event->slug)?></span> <a href="javascript:" id="slugEdit"><?=@text('OHANAH_EDIT')?></a></div><input type="text" id="slug" name="slug" value="<?=htmlspecialchars(@$event->slug)?>" class="text" style="width:384px">
										</td>
									</tr>
									<? endif ?>
								</table>
								<table>
									<tr>
										<td colspan="2"><span class="fieldTitle"><?=@text('OHANAH_DESCRIPTION')?></span><br/>
											<? if (JComponentHelper::getParams('com_ohanah')->get('useStandardJoomlaEditor')) : ?>			
												<?= @editor( array('height' => '291', 'cols' => '100', 'rows' => '20')); ?>
											<? else : ?>
												<textarea class="description" name="description" id="description_textarea" style="border: 1px lightgray solid;"><?=$event->description?></textarea>
											<? endif ?>
										</td>
									</tr>
									<tr>
										<td><span class="fieldTitle"><?=@text('OHANAH_NAME_OF_VENUE')?></span><br/><input type="text" name="venue" id="venue" class="text size5" value="<?=$this->getService('com://admin/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?>" /></td>
										<td rowspan="2">
											<span class="fieldTitle"><?=@text('OHANAH_MAP')?></span>
											<br/>
											<?= @template('com://admin/ohanah.view.common.map', array('item' => $event, 'name' => 'event')); ?>
										</td>
									</tr>
									<tr>
										<td>
											<span class="fieldTitle"><?=@text('OHANAH_ADDRESS')?></span><br/>
											<input id="address" name="address" type="text" class="text size5" value="<?=htmlspecialchars(@$event->address)?>" />
										</td>
									</tr>
									<tr>
										<td class="start">
											<span class="fieldTitle"><?=@text('OHANAH_START')?></span><br/>
											<? if ($event->date) $day = new KDate(new KConfig(array('date' => $event->date))); else $day = new KDate()?>
											<input name='date' type='text' value='<?=$day->getDate('%Y-%m-%d')?>' class='text formDate calendar cal1 required' id="ohdate" style="float:left" />
											<div class="dropdownWrapper" id="start_timer">
												<div class="dropdown size2" style="float:left">
													<?=@helper('com://admin/ohanah.template.helper.listbox.time', array('name' => 'start_time', 'selected' => substr($event->start_time, 0, 5))) ?>
												</div>	
											</div>
										</td>
										<td style="width:340px">
											<span class="fieldTitle"><input type="checkbox" name="end_time_enabled" value="0" <? if ($event->end_time_enabled == '1') echo 'checked' ?> /> <?=@text('OHANAH_ADD_END_TIME')?></span><br/>
											<? if ($event->end_date) $day = new KDate(new KConfig(array('date' => $event->end_date))); else $day = new KDate()?>								
											<input name='end_date' type='text' value='<?=$day->getDate('%Y-%m-%d')?>' class='text formDate calendar cal2' id="end_date" />
											<div class="dropdownWrapper" id="end_timer">
												<div class="dropdown size2" style="float:right">
													<?=@helper('com://admin/ohanah.template.helper.listbox.time', array('name' => 'end_time', 'selected' => substr($event->end_time, 0, 5))) ?>
												</div>	
											</div>
										</td>
									</tr>
								</table>
								<br />
							</div>
						</div>
					</div>
					<div id="adminRight">
						
					</div>
				</div>
			</div><br />
			<div id="" class="clearfix">
				<div id="panelWrapper">
					<div id="adminLeft" class="bottom">
						<div class="panel">
							<div class="panelContent">
								<table>
									<tr>
										<td>
											<span class="fieldTitle"><?=@text('OHANAH_COST_PER_TICKET')?></span><br/>
											<input type="text" class="text seventy" name="ticket_cost" value="<?=$event->ticket_cost?>" />

											<div class="dropdownWrapper">
												<div class="dropdown size3">
													<? $opts = array();
													$opt = new KObject(); $opt->text = "USD"; $opt->value="USD"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "EUR"; $opt->value="EUR"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "GBP"; $opt->value="GBP"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "CHF"; $opt->value="CHF"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "CAD"; $opt->value="CAD"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "JPY"; $opt->value="JPY"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "AUD"; $opt->value="AUD"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "BRL"; $opt->value="BRL"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "CZK"; $opt->value="CZK"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "DKK"; $opt->value="DKK"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "HKD"; $opt->value="HKD"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "HUF"; $opt->value="HUF"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "ILS"; $opt->value="ILS"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "JPY"; $opt->value="JPY"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "MYR"; $opt->value="MYR"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "MXN"; $opt->value="MXN"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "NOK"; $opt->value="NOK"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "NZD"; $opt->value="NZD"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "PHP"; $opt->value="PHP"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "PLN"; $opt->value="PLN"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "SGD"; $opt->value="SGD"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "SEK"; $opt->value="SEK"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "TWD"; $opt->value="TWD"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "THB"; $opt->value="THB"; $opts[] = $opt;
													$opt = new KObject(); $opt->text = "TRY"; $opt->value="TRY"; $opts[] = $opt;
													?>
													<? if ($event->payment_currency) $default = $event->payment_currency; else $default = JComponentHelper::getParams('com_ohanah')->get('payment_currency'); ?>
													<?= @helper('select.optionlist', array('name' => 'payment_currency',  'options' => $opts, 'selected' => $default)); ?><br />
												</div>
											</div>
										</td>
										<td>
											<span class="fieldTitle"><?=@text('OHANAH_LIMITED_AVAILABILITY_OF_TICKETS')?></span><br/>
											<div class="dropdownWrapper left">
												<div class="dropdown size4">
													<?=@helper('com://admin/ohanah.template.helper.listbox.yes_or_no', array('name' => 'limit_number_of_attendees', 'selected' => $event->limit_number_of_attendees)) ?>
												</div>
											</div>
											<input type="text" class="text" style="width:154px;" id="attendees_limit" name="attendees_limit" value="<?=$event->attendees_limit?>" />
										</td>
									</tr>
								</table>

								<div class="block">
									<table style="margin-bottom:14px;">
										<tr>
											<td><span class="fieldTitle"><?=@text('OHANAH_EVENT_PICTURE')?></span><br />
												<div id="eventPicture">
													
												</div>
											</td>
											<input type="hidden" name="picture" id="picture" value="<?=$event->picture?>" />
										</tr>
									</table>
									<table>
										<tr>
											<td><span class="fieldTitle"><?=@text('OHANAH_PHOTOS')?><br />
												<div id="eventPhotos">
													
												</div>
											</td>
										</tr>
									</table>
								</div> 
								<br />
							</div>
						</div>
					</div>
					<div id="adminRight" class="bottom">
						<div class="panel">
							<div class="panelContent">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="calendarTab">&nbsp;</div>

		</form>

		<?= @helper('button.button', array('type' => 'input', 'text' => @text('OHANAH_ADD_EVENT'))); ?>

		<script>
			$jq(function() {
				$jq('.button[name="Submit"], input[name="Submit"]').click(function() {
					if ($('edit-form').validate()) {
						$jq('.button[name="Submit"], input[name="Submit"]').attr("disabled", true); 
						$jq('.button[name="Submit"], input[name="Submit"]').text('<?=@text('OHANAH_ADDING_EVENT')?>');

						$jq.ajax({
						    type: 'post', 
							url: 'index.php?option=com_ohanah&view=event',
							data: $jq('#edit-form').serialize(),
						    success: function (data, text) {
								alert('<?=@text('OHANAH_EVENT_ADDED')?>');
								location.reload();
						    }
						});
					}
				});
			});
		</script>
	</div>
<? endif ?>