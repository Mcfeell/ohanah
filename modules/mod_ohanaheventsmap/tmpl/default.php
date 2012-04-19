<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if (count($events)) : ?>		
		<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = ''; ?>

		<? if ((JComponentHelper::getParams('com_ohanah')->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
			<script src="media://com_ohanah/js/jquery.min.js" />
			<? JFactory::getApplication()->set('jquery', true); ?>
		<? endif; ?>
		
		<style>
			#map-container {
				padding: 6px;
				border-width: 1px;
				border-style: solid;
				border-color: #ccc #ccc #999 #ccc;
				-webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
				-moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
				box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
			}
		</style>

		<script src="http://maps.google.com/maps/api/js?sensor=false" /> 
		<script src="media://com_ohanah/js/markerclustererV3.js" />
		<? $componentParams = JComponentHelper::getParams('com_ohanah') ?>
		<? if ($componentParams->get('itemid')) $itemid = '&Itemid='.$componentParams->get('itemid'); else $itemid = ''; ?>

	    <script>
			jQuery(document).ready(function(){
		        var center = new google.maps.LatLng(37.4419, -122.1419);

		        var map = new google.maps.Map(document.getElementById('map'), {
		    	    zoom: 3,
			        center: center,
			      	scrollwheel: false,
	        		mapTypeId: google.maps.MapTypeId.ROADMAP
		        });

				<? $count = 0 ?>


		        var markers = [];
				
				var latlngbounds = new google.maps.LatLngBounds();
				var infowindow = new google.maps.InfoWindow();

				<? $i = 0 ?>
				<? foreach ($events as $event) : ?>
					<? if ($event->latitude) : ?>
			          	var latLng<?=$event->id?> = new google.maps.LatLng(<?=$event->latitude?>, <?=$event->longitude?>);

			          	var marker<?=$event->id?> = new google.maps.Marker({icon: 'http://<?=$_SERVER['HTTP_HOST'].KRequest::base()?>/media/com_ohanah/images/ohapp_mapmarker.png', position: latLng<?=$event->id?>, value: <?=$event->id?>, title:"<?=addslashes($event->title)?>", url:"<?=@route('option=com_ohanah&view=event&id='.$event->id.$itemid)?>", date: "<?= @helper('date.format', array('date' => $event->date, 'format' => '%d', 'gmt_offset' => '0'));?>
				<?= JText::_(@helper('date.format', array('date' => $event->date, 'format' => '%B', 'gmt_offset' => '0')));?>
				<?=@helper('date.format', array('date' => $event->date, 'format' => '%Y', 'gmt_offset' => '0'));?>"});

						latlngbounds.extend(latLng<?=$event->id?>);

			          	markers.push(marker<?=$event->id?>);

			          	latlngbounds.extend(latLng<?=$event->id?>);

						var contentString<?=$event->id?> = '<div id="content"><a href="'+marker<?=$event->id?>.url+'">'+marker<?=$event->id?>.title+' ('+marker<?=$event->id?>.date+')</a></div>';

						google.maps.event.addListener(marker<?=$event->id?>, 'click', function() {
							//console.log(marker<?=$event->id?>);
					   		infowindow.close();
					   		infowindow.content = contentString<?=$event->id?>;
						  	infowindow.open(map, marker<?=$event->id?>);
						});
					<? endif ?>
				<? endforeach ?>



		        var markerCluster = new MarkerClusterer(map, markers);
				
				// Listen for a cluster to be clicked
				google.maps.event.addListener(markerCluster, 'clusterclick', function(cluster) {

			   		var content = '';

			   		// Convert lat/long from cluster object to a usable MVCObject
			   		var info = new google.maps.MVCObject;
			   		info.set('position', cluster.center_);


			   		var markers = cluster.getMarkers();
			   		var content = '<div id="content">';
			   		for (var i = 0; i < markers.length; i++) {
			   			//console.log(markers[i]);
						content += '<a href="'+markers[i].url+'">'+markers[i].title+' ('+markers[i].date+')</a><br />';
			   		}
			   		content += '</div>';


			   		infowindow.close();
			   		infowindow.setContent(content);
			 		infowindow.open(map, info);
				});

				map.setCenter(latlngbounds.getCenter());
				<? if ($params->get('zoom') && $params->get('zoom') != '0') : ?>
					map.setZoom(<?=$params->get('zoom')?>);
				<? else : ?>
					<? if (count($events) == 1 && $params->get('max_zoom')) : ?>
						map.setZoom(<?=$params->get('max_zoom')?>);
					<? else : ?>
						map.fitBounds(latlngbounds);
					<? endif ?>		
				<? endif ?>

			});
	    </script>

		<? $width = $params->get('mapWidth'); if (!$width) $width = 500; ?>
		<? $height = $params->get('mapHeight'); if (!$height) $height = 260; ?>
	
		<div id="container" style="width: <?=$width?>px; height: <?=$height?>px">
			<div id="map" style="width: <?=$width?>px; height: <?=$height?>px"></div>
		</div> 

	<? endif; ?>
</div>