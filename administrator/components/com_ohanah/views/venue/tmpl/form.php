<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<style src="media://com_ohanah/css/jquery-ui.css" />

<script src="media://lib_koowa/js/koowa.js" />
<?=@helper('behavior.mootools'); ?>
<?=@helper('behavior.validator') ?>

<?= @template('com://admin/ohanah.view.common.images', array('item' => $venue, 'name' => 'venue')); ?>

<form action="" method="post" class="form-validate -koowa-form" id="edit-form" enctype="multipart/form-data">

	<input type="hidden" name="id" value="<?=$venue->id?>" />
	<? JUtility::getToken() ?>

	<? if (!$venue->id) : ?>
		<input type="hidden" id="random_id" name="random_id" value="<?=rand()%5000?>" />
	<? endif ?>


	<div class="clr"></div>
			
	<div id="eventWrapper" class="clearfix">
		<div id="panelWrapper">
			<div id="adminLeft">
				<div class="panel">
					<div class="panelContent">
						<table>
							<tr>
								<td style="width:60%;" >
									<span class="fieldTitle"><?=@text('OHANAH_TITLE')?></span><br/><input type="text" id="title" name="title" class="text size6 required" value="<?=htmlspecialchars(@$venue->title)?>" />
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td colspan="2"><span class="fieldTitle"><?=@text('OHANAH_DESCRIPTION')?></span><br/>
									
									<textarea class="description" name="description" id="description_textarea"><?=$venue->description?></textarea>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_ADDRESS')?></span><br/>
									<input id="address" name="address" type="text" class="text size5" value="<?=htmlspecialchars(@$venue->address)?>" />
								</td>
								<td rowspan="2">
									<span class="fieldTitle"><?=@text('OHANAH_MAP')?></span>
									<br/>
									<?= @template('com://admin/ohanah.view.common.map', array('item' => $venue)); ?>
								</td>
							</tr>
						</table>

						<br />
					</div>
				</div>
			</div>
			<div id="adminRight">
				<div class="panel">
					<div class="panelContent">
						<table>
							<tr>
								<td><span class="fieldTitle"><?=@text('OHANAH_PHOTOS')?><br /><br />
									<div id="eventPhotos">
										
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div><br />
	<div id="eventWrapper2" class="clearfix">
		<div id="panelWrapper">
			<div id="adminLeft" class="bottom">
				<div class="panel">
					<div class="panelContent">
						
						<table style="width:100%">
							<tr>
								<td>
								</td>

							</tr>
						</table>

					</div>
				</div>
			</div>
			<div id="adminRight" class="bottom">
				<div class="panel">
					<div class="panelContent">

						<table style="width:20%">
							<tr>
								<td>
									<span class="fieldTitle"><?=@text('OHANAH_VENUE_STATUS')?></span><br/>
									<div class="dropdownWrapper">
										<div class="dropdown size2">
											<?=@helper('com://admin/ohanah.template.helper.listbox.published_or_draft', array('name' => 'enabled', 'selected' => $venue->enabled)) ?>
										</div>
									</div>
								</td>

							</tr>
						</table>
						<br /><br /><br /><br />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="calendarTab">&nbsp;</div>
</form>