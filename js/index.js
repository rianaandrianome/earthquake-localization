$(document).ready(function(){
    initialMarkers();
    
});

function initialMarkers(){
  var xhttp = new XMLHttpRequest();
  var url ="https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&starttime=2014-01-01&endtime=2014-01-02";
  xhttp.open("GET", url, false);

  xhttp.send();

  if(xhttp.status >= 200 && xhttp.status < 400){
    var response = xhttp.responseText; 
    var obj = JSON.parse(response);
    var i; 

    var planes = new Array(); 
    for(i in obj.features){

        planes[i] = new Array(
            obj.features[i].properties.place, // location i= 0  
            obj.features[i].geometry.coordinates[0], // lat 
            obj.features[i].geometry.coordinates[1], // long
            obj.features[i].geometry.coordinates[2], // depth
            obj.features[i].properties.mag, // magnitude 
            obj.features[i].properties.title, // title or name
        ); 
    }// enf for planes 
        
    for (var i = 0; i < planes.length; i++) {
      marker = new L.marker([planes[i][2],planes[i][1]])
			.bindPopup("<b>Name: </b>"+planes[i][5]+"<br><b>Location:</b><br> "+planes[i][0]+"<br><b>Magnitude:</b> "+planes[i][4]+"<br><b>Depth: </b>"+planes[i][3] +"<br><b>Longitude: </b>"+planes[i][2] +"<br><b>Latitude: </b>"+planes[i][1])
			.addTo(map);
    }// end for map 
  }else{
     console.log("<p>ERROR!" +xhttp.status+"</p>");
  }
}// end function 

function sliderChange(val){
    
    document.getElementById('magSlider').value = val;
    document.getElementById('magValue').innerHTML = val; 
}

function showMag(){
    var xhttp = new XMLHttpRequest();
    var url ="https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&starttime=2014-01-01&endtime=2014-01-02";
        xhttp.open("GET", url, false);

        xhttp.send();

        if(xhttp.status >= 200 && xhttp.status < 400){
           var response = xhttp.responseText; 
            var obj = JSON.parse(response);

            var i; 

            var planes = new Array(); 
            for(i in obj.features){

                planes[i] = new Array(
                    obj.features[i].properties.place, // location i= 0  
                    obj.features[i].geometry.coordinates[0], // lat 
                    obj.features[i].geometry.coordinates[1], // long
                    obj.features[i].geometry.coordinates[2], // depth
                    obj.features[i].properties.mag, // magnitude 
                     obj.features[i].properties.title, // title or name
                ); 
            }// enf for planes 
                
             var LeafIcon = L.Icon.extend({
            options: {
                iconSize:     [45, 45],
                iconAnchor:   [22, 94],
                popupAnchor:  [-3, -76]
            }
        });
        
         /* --------------------------------------------------- Magnitude icons --------------------------------------------------------*/
        var greenIcon = new LeafIcon({iconUrl: 'images/mag4to5.png'}); 
        var blueIcon = new LeafIcon({iconUrl: 'images/mag5to7.png'}); 
        var yellowIcon = new LeafIcon({iconUrl: 'images/mag7to8.png'}); 
        var orangeIcon = new LeafIcon({iconUrl: 'images/mag8to10.png'});
        var redIcon = new LeafIcon({iconUrl: 'images/mag10.png'}); 
        
        var mag = document.getElementById('magSlider').value; 
            
          for (var i = 0; i < planes.length; i++) {
              if(mag < 5){
                marker = new L.marker([planes[i][2],planes[i][1]], {icon: greenIcon}).bindPopup("<b>Name: </b>"+planes[i][5]+"<br><b>Location:</b><br> "+planes[i][0]+"<br><b>Magnitude:</b> "+planes[i][4]+"<br><b>Depth: </b>"+planes[i][3] +"<br><b>Longitude: </b>"+planes[i][2] +"<br><b>Latitude: </b>"+planes[i][1])
				.addTo(map);
              }
              else if(mag >= 5 && mag < 7){
                marker = new L.marker([planes[i][2],planes[i][1]], {icon: blueIcon}).bindPopup("<b>Name: </b>"+planes[i][5]+"<br><b>Location:</b><br> "+planes[i][0]+"<br><b>Magnitude:</b> "+planes[i][4]+"<br><b>Depth: </b>"+planes[i][3] +"<br><b>Longitude: </b>"+planes[i][2] +"<br><b>Latitude: </b>"+planes[i][1])
				.addTo(map);
              }
              else  if(mag >= 7 && mag < 8){
                marker = new L.marker([planes[i][2],planes[i][1]], {icon: yellowIcon}).bindPopup("<b>Name: </b>"+planes[i][5]+"<br><b>Location:</b><br> "+planes[i][0]+"<br><b>Magnitude:</b> "+planes[i][4]+"<br><b>Depth: </b>"+planes[i][3] +"<br><b>Longitude: </b>"+planes[i][2] +"<br><b>Latitude: </b>"+planes[i][1])
				.addTo(map);
              }
              else  if(mag >= 8 && mag < 10){
                marker = new L.marker([planes[i][2],planes[i][1]], {icon: orangeIcon}).bindPopup("<b>Name: </b>"+planes[i][5]+"<br><b>Location:</b><br> "+planes[i][0]+"<br><b>Magnitude:</b> "+planes[i][4]+"<br><b>Depth: </b>"+planes[i][3] +"<br><b>Longitude: </b>"+planes[i][2] +"<br><b>Latitude: </b>"+planes[i][1])
				.addTo(map);
              }
              else  if(mag >= 10){
                marker = new L.marker([planes[i][2],planes[i][1]], {icon: redIcon}).bindPopup("<b>Name: </b>"+planes[i][5]+"<br><b>Location:</b><br> "+planes[i][0]+"<br><b>Magnitude:</b> "+planes[i][4]+"<br><b>Depth: </b>"+planes[i][3] +"<br><b>Longitude: </b>"+planes[i][2] +"<br><b>Latitude: </b>"+planes[i][1])
				.addTo(map);
              }
		  }
            
            
        }else{
              console.log("<p>ERROR!" +xhttp.status+"</p>");
        }
}

function onLocationFound(e) {
   var radius = e.accuracy /15;
   var location = e.latlng
   L.marker(location).addTo(map)
   L.circle(location, radius).addTo(map);
}

function onLocationError(e){
  alert(e.message);
}

function showLocation() {
 map.on('locationfound', onLocationFound);
 map.on('locationerror', onLocationError);

 map.locate({setView: true, maxZoom: 8});
}

function showDate(){
    var startDate = document.getElementById('startDate').value; 
    var endDate = document.getElementById('endDate').value; 
    
     var xhttp = new XMLHttpRequest();
    
    var url ="https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&starttime="+startDate+"&endtime="+endDate;
    
        xhttp.open("GET", url, false);

        xhttp.send();

        if(xhttp.status >= 200 && xhttp.status < 400){
           var response = xhttp.responseText; 
            var obj = JSON.parse(response);

            var i; 

            var planes = new Array(); 
            for(i in obj.features){

                planes[i] = new Array(
                    obj.features[i].properties.place, // location i= 0  
                    obj.features[i].geometry.coordinates[0], // lat 
                    obj.features[i].geometry.coordinates[1], // long
                    obj.features[i].geometry.coordinates[2], // depth
                    obj.features[i].properties.mag, // magnitude 
                     obj.features[i].properties.title, // title or name
                ); 
            }// enf for planes 
                
             var LeafIcon = L.Icon.extend({
            options: {
                iconSize:     [45, 45],
                iconAnchor:   [22, 94],
                popupAnchor:  [-3, -76]
            }
        });
       
        var dateIcon = new LeafIcon({iconUrl: 'images/date.png'}); 
            
                for (var i = 0; i < planes.length; i++) {
			     marker = new L.marker([planes[i][2],planes[i][1]], {icon: dateIcon})
				.bindPopup("<b>Name: </b>"+planes[i][5]+"<br><b>Location:</b><br> "+planes[i][0]+"<br><b>Magnitude:</b> "+planes[i][4]+"<br><b>Depth: </b>"+planes[i][3] +"<br><b>Longitude: </b>"+planes[i][2] +"<br><b>Latitude: </b>"+planes[i][1])
				.addTo(map);
		      }// end for map 
            
            
        }else{
              console.log("<p>ERROR!" +xhttp.status+"</p>");
        }
   }

function showRectangle(){
    var minlatitude = document.getElementById('minlatitude').value; 
    var minlongitude = document.getElementById('minlongitude').value; 
    var maxlatitude = document.getElementById('maxlatitude').value;
    var maxlongitude = document.getElementById('maxlongitude').value; 
    
      var xhttp = new XMLHttpRequest();
    var url ="https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&minlatitude="+minlatitude+"&minlongitude="+minlongitude+"&maxlatitude="+maxlatitude+"&maxlongitude="+maxlongitude;
        xhttp.open("GET", url, false);

        xhttp.send();

        if(xhttp.status >= 200 && xhttp.status < 400){
           var response = xhttp.responseText; 
            var obj = JSON.parse(response);

            var i; 

            var planes = new Array(); 
            for(i in obj.features){

                planes[i] = new Array(
                    obj.features[i].properties.place, // location i= 0  
                    obj.features[i].geometry.coordinates[0], // lat 
                    obj.features[i].geometry.coordinates[1], // long
                    obj.features[i].geometry.coordinates[2], // depth
                    obj.features[i].properties.mag, // magnitude 
                    obj.features[i].properties.title, // title or name
                ); 
            }// enf for planes 
                
            
               var LeafIcon = L.Icon.extend({
            options: {
                iconSize:     [45, 45],
                iconAnchor:   [22, 94],
                popupAnchor:  [-3, -76]
            }
        });
       
        var rectangleIcon = new LeafIcon({iconUrl: 'images/rectangle.png'}); 
            
                for (var i = 0; i < planes.length; i++) {
			     marker = new L.marker([planes[i][2],planes[i][1]], {icon: rectangleIcon})
				.bindPopup("<b>Name: </b>"+planes[i][5]+"<br><b>Location:</b><br> "+planes[i][0]+"<br><b>Magnitude:</b> "+planes[i][4]+"<br><b>Depth: </b>"+planes[i][3] +"<br><b>Longitude: </b>"+planes[i][2] +"<br><b>Latitude: </b>"+planes[i][1])
				.addTo(map);
		      }// end for map 
            
            
        }else{
              console.log("<p>ERROR!" +xhttp.status+"</p>");
        }
    
}












