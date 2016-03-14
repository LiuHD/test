function getmap(){
	
(!navigator.Geolocation) throw "Geolacation not supported!";

var image=document.createElement('img');
navigator.geolocation.getCurrentPosition(setMapUrl);
return image;
}

function setMapUrl(pos){
	var latitude =pos.coords.latitude;
	var longitude =pos.coords.longitude;
	var accuracy=ps.coords.accuracy;
	
	var url ="http://maps.google.com/maps/api/staticmap"+
	"?center="+latitude+","+longitude+"&size=640x640&sensor=true";
	
	var zoomlevel=20;
	if(accuracy>80)
	{
		zoomlevel-=Math.round(log(accuracy/50)/Math.LN2);
	}
	url+="&zoom="+zoomlevel;
	
	image.src=url;
}
