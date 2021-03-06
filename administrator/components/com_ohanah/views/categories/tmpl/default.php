<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<?=@helper('behavior.mootools'); ?>
<?=@helper('behavior.tooltip'); ?>

<script src="media://lib_koowa/js/koowa.js" />

<form action="" method="get" class="-koowa-grid">
	<div id="filterHeader">
		<div class="filter"><?=@text('OHANAH_FILTER')?>: <?=@helper('grid.search');?></div>
		<div id="selectors">
			<ul class="selector">
				<li <? if (!KRequest::get('get.published', 'string')) echo 'class="active"'; ?>><a href="<?=@route('&published=')?>"><?=@text('OHANAH_ALL');?></a></li>
				<li <? if (KRequest::get('get.published', 'string') == 'true') echo 'class="active"'; ?>><a href="<?=@route('&published=true')?>"><?=@text('OHANAH_PUBLISHED')?></a></li>
				<li <? if (KRequest::get('get.published', 'string') == 'false') echo 'class="active"'; ?>><a href="<?=@route('&published=false')?>"><?=@text('OHANAH_UNPUBLISHED')?></a></li>
			</ul>
		</div>
	</div>
	<div id="tableWrapper">
		<table>	
			<? if (count($categories)) : ?>
				<?= @template('default_categories', array('categories' => $categories)); ?>
			<? endif ?>
		</table>
	</div>
	<?= @helper('paginator.pagination', array('total' => $total)) ?>
</form>