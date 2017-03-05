 /* <3 */


var le = {};

le.init = function() {
  le.setupMap();
};

le.setupMap = function() {
  // Styles
  var mapStyles = [
		{ featureType: "poi", elementType: "geometry", 
		  stylers: [
		    { visibility: "on" },
		    { color: "#96dcf7" }
		  ] 
		},
		{ featureType: "all", elementType: "labels",   stylers: [{ visibility: "off" }] },
		{ featureType: "road", elementType: "all",      
		  stylers: [
		    { visibility: "on" },
		    { color: "#86d8f8" }, /*#24c6f4*/
        { visibility: "simplified" }
		  ] 
		},
		{ featureType: "administrative", elementType: "all", stylers: [{ visibility: "on" }] },
		{ featureType: "transit", elementType: "all",      
		  stylers: [
		    { color: "#61bfe4" },
		    { visibility: "simplified" }
		  ] 
		},
		{ featureType: "landscape.man_made",
			stylers: [
				{ color: "#a8e1f7" },
				{ visibility: "simplified" }
			]
		},
		{ featureType: "water", elementType: "all",
			stylers: [
				{ color: "#edf9fe" },
				{ visibility: "simplified" }
			]
		}
	];
	
	// Default Location
	var loc = new google.maps.LatLng(41.88610, -87.65228);
	
	// Static Locations
	var locations = [
	  new google.maps.LatLng(41.884228,-87.663345),
	  new google.maps.LatLng(41.884164,-87.650042),
	  new google.maps.LatLng(41.884355,-87.641201),
	  new google.maps.LatLng(41.888796,-87.64133),
	  new google.maps.LatLng(41.888892,-87.658968),
	  new google.maps.LatLng(41.88295,-87.658796),
	  new google.maps.LatLng(41.889755,-87.647552)
	];
	
	// Options
  var mapOptions = {
		scrollwheel: false,
		navigationControl: false,
		draggable: true,
		scaleControl: false,
		streetViewControl: false,
		printControl: false,
		zoom: 16,
		zoomControl: false,
		maxZoom: 16,
		minZoom: 16,
		disableDoubleClickZoom: true,
		disableDefaultUI: true,
		center: loc,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(document.getElementById("map"),mapOptions);
	
	var styledMap = new google.maps.StyledMapType(mapStyles);
	
	map.mapTypes.set('mymap', styledMap);
	map.setMapTypeId('mymap');
	
	var markers = [];
  var iterator = 0;
  
	var markerImage = 'images/marker-green.png';
  //var defaultMarker = new google.maps.Marker({
  //  position: loc,
  //  map: map,
  //  animation: google.maps.Animation.DROP,
  //  icon: markerImage
  //});
  
  for (var i = 0; i < locations.length; i++) {
    setTimeout(function() {
      markers.push(new google.maps.Marker({
        position: locations[iterator],
        map: map,
        draggable: false,
        animation: google.maps.Animation.DROP,
        icon: markerImage
      }));
      iterator++;
    }, i * 350);
  }
  
  //google.maps.event.addListener(defaultMarker, 'click', function(){
  //  if (defaultMarker.getAnimation() != null) {
  //    defaultMarker.setAnimation(null);
  //  } else {
  //    defaultMarker.setAnimation(google.maps.Animation.BOUNCE);
  //  }
  //});
}

$(function() { le.init(); });
