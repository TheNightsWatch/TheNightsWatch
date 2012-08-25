$(document).ready(function(){
	$.getJSON('/map/places',function(data){
		console.log('Got Places');
		var cts = overviewer.mapView.options.currentTileSet;
		for(var i in data)
		{
			var place = data[i];
			console.log('Got Place',place);
			var iconDIR = '/map/icons/';
			var icon = iconDIR + 'town.png';
			
			place.loot = parseInt(place.loot);
			
			if(place.type == 'DUNGEON') icon = iconDIR + 'dungeon.png';
			if(place.type == 'MAJOR' && (place.loot & 1) == 1) icon = iconDIR + 'major_civ.png';
			if(place.type == 'MAJOR' && (place.loot & 2) == 2) icon = iconDIR + 'major_food.png';
			if(place.type == 'MAJOR' && (place.loot & 4) == 4) icon = iconDIR + 'major_mil.png';
			if(place.type == 'MAJOR' && (place.loot & 6) == 6) icon = iconDIR + 'major_both.png';
			if(place.type == 'MINOR') icon = iconDIR + 'minor.png';
			if(place.type == 'TOWN' && (place.loot & 2) == 2) icon = iconDIR + 'town_food.png';
			if(place.type == 'TOWN' && (place.loot & 4) == 4) icon = iconDIR + 'town_mil.png';
			if(place.type == 'TOWN' && (place.loot & 6) == 6) icon = iconDIR + 'town_both.png';
			
			var img = new google.maps.MarkerImage(icon);
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