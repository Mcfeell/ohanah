<div class="panelContent">


	<div>
		<div class="thirty"><span class="fieldTitle"><?=@text('OHANAH_PAYPAL_EMAIL')?></span><br/><input type="text" name="paypal_email" class="text" value="<?=$params->paypal_email?>"></div>

		<div class="thirty"><span class="fieldTitle"><?=@text('OHANAH_DEFAULT_PAYMENT_CURRENCY'); ?></span><br/>
			<div class="dropdownWrapper left">
				<div class="dropdown size1">
					<?
					$options = array();
					$option = new KObject(); $option->text = "USD"; $option->value="USD"; $options[] = $option;
					$option = new KObject(); $option->text = "EUR"; $option->value="EUR"; $options[] = $option;
					$option = new KObject(); $option->text = "GBP"; $option->value="GBP"; $options[] = $option;
					$option = new KObject(); $option->text = "CHF"; $option->value="CHF"; $options[] = $option;
					$option = new KObject(); $option->text = "CAD"; $option->value="CAD"; $options[] = $option;
					$option = new KObject(); $option->text = "JPY"; $option->value="JPY"; $options[] = $option;
					$option = new KObject(); $option->text = "AUD"; $option->value="AUD"; $options[] = $option;
					$option = new KObject(); $option->text = "BRL"; $option->value="BRL"; $options[] = $option;
					$option = new KObject(); $option->text = "CZK"; $option->value="CZK"; $options[] = $option;
					$option = new KObject(); $option->text = "DKK"; $option->value="DKK"; $options[] = $option;
					$option = new KObject(); $option->text = "HKD"; $option->value="HKD"; $options[] = $option;
					$option = new KObject(); $option->text = "HUF"; $option->value="HUF"; $options[] = $option;
					$option = new KObject(); $option->text = "ILS"; $option->value="ILS"; $options[] = $option;
					$option = new KObject(); $option->text = "JPY"; $option->value="JPY"; $options[] = $option;
					$option = new KObject(); $option->text = "MYR"; $option->value="MYR"; $options[] = $option;
					$option = new KObject(); $option->text = "MXN"; $option->value="MXN"; $options[] = $option;
					$option = new KObject(); $option->text = "NOK"; $option->value="NOK"; $options[] = $option;
					$option = new KObject(); $option->text = "NZD"; $option->value="NZD"; $options[] = $option;
					$option = new KObject(); $option->text = "PHP"; $option->value="PHP"; $options[] = $option;
					$option = new KObject(); $option->text = "PLN"; $option->value="PLN"; $options[] = $option;
					$option = new KObject(); $option->text = "SGD"; $option->value="SGD"; $options[] = $option;
					$option = new KObject(); $option->text = "SEK"; $option->value="SEK"; $options[] = $option;
					$option = new KObject(); $option->text = "TWD"; $option->value="TWD"; $options[] = $option;
					$option = new KObject(); $option->text = "THB"; $option->value="THB"; $options[] = $option;
					$option = new KObject(); $option->text = "TRY"; $option->value="TRY"; $options[] = $option;
					?>
					<? if ($params->payment_currency) $default = $params->payment_currency; else $default = "USD"; ?>
					<?= @helper('select.optionlist', array('name' => 'payment_currency',  'options' => $options, 'selected' => $default)); ?>
					<br />
				</div>
			</div>
		</div>
	</div>
	<br /> <br /> 
	<div class="break"></div>

	<div class="">
		<span class="fieldTitle"><?=@text('OHANAH_DEFAULT_REGISTRATION_SYSTEM_FOR_NEW_EVENTS')?></span><br/>
		<table>
			<tr>
				<div class="dropdownWrapper left"><div class="dropdown size1">
					<?
					$options = array();
					$option = new KObject(); $option->text = 'Ohanah'; $option->value = 'ohanah'; $options[0] = $option;
					$option = new KObject(); $option->text = @text('OHANAH_CUSTOM'); $option->value= 'custom'; $options[1] = $option;
					?>
					<? if ($params->registration_system) $default = $params->registration_system; else $default = 'ohanah'; ?>
					<?= @helper('select.optionlist', array('name' => 'registration_system',  'options' => $options, 'selected' => $default)); ?><br />
				</div></div>
			</tr>
		</table>
	</div>				
	<script>
		$jq(function() {
			$jq('select[name="registration_system"]').change(function(){
				if ($jq(this).attr('value')=='ohanah') { $jq('#ohanah-registration-enabled-div').show(); } 
				else { $jq('#ohanah-registration-enabled-div').hide(); }
			});

			<? if ($default == 'custom') : ?>
				$jq('#ohanah-registration-enabled-div').hide();
			<? endif ?>
		});
	</script>

	<br />

	<div id="ohanah-registration-enabled-div">		

		<div class="">
			<span class="fieldTitle"><?=@text('OHANAH_DEFAULT_PAYMENT_GATEWAY_FOR_NEW_EVENTS')?></span><br/>
			<table>
				<tr>
					<div class="dropdownWrapper left"><div class="dropdown size1">
						<?
						$options = array();
						$option = new KObject(); $option->text = "PayPal"; $option->value="paypal"; $options[0] = $option;
						$option = new KObject(); $option->text = @text('OHANAH_NONE'); $option->value="none"; $options[1] = $option;
						$option = new KObject(); $option->text = @text('OHANAH_CUSTOM_2'); $option->value="custom"; $options[2] = $option;
						?>
						<? if ($params->payment_gateway) $default = $params->payment_gateway; else $default = 'paypal'; ?>
						<?= @helper('select.optionlist', array('name' => 'payment_gateway',  'options' => $options, 'selected' => $default)); ?><br />
					</div></div>
				</tr>
			</table>
		</div>
		<div class="break"></div>

		<div class=""><span class="fieldTitle"><?=@text('OHANAH_DEFAULT_REGISTRATION_FORM_FIELDS_FOR_NEW_EVENTS')?></span><br/>
			<table>
				<tr>
					<? for ($i = 1; $i <= 10; $i++) : ?>
						<? $paramName = "custom_field_label_$i"; ?>
						<? $paramNameMandatory = "custom_field_label_$i"."_mandatory"; ?>
						<? if (isset($params->$paramName)) : ?>
							<? if ($params->$paramName) : ?>
								<div class="customfield">
									<img src="media://com_ohanah/v2/ohanah_images/icon-x.png" class="remove_custom_field" /> &nbsp;
									<input type="text" id="custom_field_label_<?=$i?>" name="custom_field_label_<?=$i?>" class="text size5" value="<?=$params->$paramName?>" />
									&nbsp;&nbsp;&nbsp;
									<input type="hidden" name="custom_field_label_<?=$i?>_checked" checked />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="custom_field_label_<?=$i?>_mandatory" <? if (isset($params->$paramNameMandatory)) if ($params->$paramNameMandatory) echo 'checked'; ?> /> <?=@text('OHANAH_MANDATORY')?>
									<br /><br />
								</div>
							<? endif; ?>
						<? endif; ?>
					<? endfor ?>
												
					<script>
						$jq(function() {
							$jq('.remove_custom_field').live('click', function(){
								$jq(this).next('input.text').val('');
								$jq(this).closest('div').remove();

								if ($jq('.customfield').length < 10) {
									$jq('#onemorecustomfield').show();
								}										
							});	
						});
					</script>
																			
					<span id="onemorecustomfieldcontent"></span>
					<br />
						
					<script>
						$jq(function() {
							if ($jq('.customfield').length >= 10) {
								$jq('#onemorecustomfield').hide();
							}
						});
					</script>	

					<div id="onemorecustomfield" style="margin-left:243px; cursor: pointer; width:80px">
						<div class="button size2" style="width:80px">
							<div style="padding-top:15px; text-align:center"><?=@text('OHANAH_ADD_NEW')?></div>
						</div>
					</div>

					<script>
						var $jq = jQuery.noConflict();  
						$jq(function() {
						    $jq('#onemorecustomfield').click(function() {
						    	var i = 1; 

						    	for (i = 1; i <= 10; i++) { 

						    		if ($jq('#custom_field_label_'+i).length == 0) {
										$jq('#onemorecustomfieldcontent').append('<div class="customfield"><img src="media://com_ohanah/v2/ohanah_images/icon-x.png" class="remove_custom_field" /> &nbsp;												<input type="text" id="custom_field_label_'+i+'" name="custom_field_label_'+i+'" class="text size5" value="" />	&nbsp;&nbsp;&nbsp; 												<input type="hidden" name="custom_field_label_'+i+'_checked" checked />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="custom_field_label_'+i+'_mandatory" /> <?=@text("OHANAH_MANDATORY")?> <br /><br /></div>');
										break;
						    		}
						    	}

						    	if ($jq('.customfield').length >= 10) {
									$jq('#onemorecustomfield').hide();
								}
							});
						});
					</script>
				</tr>
			</table>
		</div>
	</div>
	<br /><br /><br />
</div>