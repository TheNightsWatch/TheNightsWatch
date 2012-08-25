$(document).ready(function(){
	$.getJSON('/map/places',function(data){
		console.log('Got Places');
		var cts = overviewer.mapView.options.currentTileSet;
		for(var i in data)
		{
			var place = data[i];
			console.log('Got Place',place);
			
			var img = new google.maps.MarkerImage('/map/icons/town.png');
			new google.maps.Marker({
				position: overviewer.util.fromWorldToLatLng(place.x,50,place.z,cts),
				map: overviewer.map,
				title: place.name,
				visible: true,
				zIndex: 999,
				icon: img,
			});
		}
	});
});