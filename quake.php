<?php 
    error_reporting(E_ALL & ~E_NOTICE); 
    ini_set("display_errors", 0);
    include('dbConnection.php');
    connectToDatabase();
    
?>

<h3>Past 30 days Earthquakes based on QuakeML</h3>
        
<!--  -------------------------- FORM ---------------------------->
<form method="post" class="btn-wrapper">
        <input type="submit" name="uploadUrlMagAll" value="All Earthquakes " class="btn btn-info">
        <input type="submit" name="uploadUrlMagSignificant" value="Significant magnitude " class="btn btn-info">
        <input type="submit" name="uploadUrlMag4" value="Magnitude of 4.5 + " class="btn btn-info">
        <input type="submit" name="uploadUrlMag2" value="Magnitude of 2.5+" class="btn btn-info">
        <input type="submit" name="uploadUrlMag1" value="Magnitude of 1.0+" class="btn btn-info">
</form>
    
<!--   -------------------- INITIALISE DB  --------------------------- -->
<?php
     if( isset($_POST['uploadUrlMagSignificant'])){
      $url = 'https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/significant_month.quakeml'; 
      $path = 'uploads/quake.xml';
      $con = file_get_contents($url);
      file_put_contents($path, $con); 
   
      initaliseDb(); 
      insertInDb(); 
      echo ""; 
     } // end isset 
     if( isset($_POST['uploadUrlMag4'])){
      $url = 'https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/4.5_month.quakeml'; 
      $path = 'uploads/quake.xml';
      $con = file_get_contents($url);
      file_put_contents($path, $con); 
   
      initaliseDb(); 
      insertInDb(); 
      echo ""; 
     } // end isset 
     if( isset($_POST['uploadUrlMag2'])){
      $url = 'https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_month.quakeml'; 
      $path = 'uploads/quake.xml';
      $con = file_get_contents($url);
      file_put_contents($path, $con); 
   
      initaliseDb(); 
      insertInDb(); 
      echo ""; 
     } // end isset 
     if( isset($_POST['uploadUrlMag1'])){
      $url = 'https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/1.0_month.quakeml'; 
      $path = 'uploads/quake.xml';
      $con = file_get_contents($url);
      file_put_contents($path, $con); 
   
      initaliseDb(); 
      insertInDb(); 
      echo ""; 
     } // end isset 
     if( isset($_POST['uploadUrlMagAll'])){
      $url = 'https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_month.quakeml'; 
      $path = 'uploads/quake.xml';
      $con = file_get_contents($url);
      file_put_contents($path, $con); 
      initaliseDb(); 
      insertInDb(); 
      echo ""; 
     } // end isset 
    initaliseDb(); 
    insertInDb();   
            
?>
    
<!---------- DRAW MAP  AND LEGEND ----------->
<div id="display" class="row">
    <div id="map" class="col-lg-8 map"></div>
    <script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
        <script>
            
            var allEarthquakes = <?php selectAll()?>; 
            
            var i, j, k, count=0;
        
            var planes = new Array(); 
            
            for(i in allEarthquakes.earthquakes){
                //x += allEarthquakes.earthquakes[i].location;
                planes[i] = new Array(allEarthquakes.earthquakes[i].location, allEarthquakes.earthquakes[i].date, allEarthquakes.earthquakes[i].time, allEarthquakes.earthquakes[i].longitude, allEarthquakes.earthquakes[i].latitude, allEarthquakes.earthquakes[i].depth, allEarthquakes.earthquakes[i].magnitude); 
                
                count++; 
            }
        
            var map = L.map('map').setView([0, 0], 2);
            mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '&copy; ' + mapLink + ' Contributors', maxZoom: 18,}).addTo(map);
            
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
            
           
            for (var i = 0; i < planes.length; i++) {
                if(planes[i][3] < 5){
                    marker = new L.marker([planes[i][3],planes[i][4]], {icon: greenIcon}).bindPopup("<b>Location: </b>"+planes[i][0]+"<br><b>Date:</b> "+planes[i][1]+"<br><b>Time: </b>"+planes[i][2]+"<br><b>Longitude: </b>"+planes[i][3]+ "<br><b>Latitude: </b>"+planes[i][4]+ "<br><b>Depth: </b>"+planes[i][5]+"<br><b>Magnitude: </b>"+planes[i][6]).addTo(map);  
                }
                else if(planes[i][3] >= 5 && planes[i][3] < 7){
                    marker = new L.marker([planes[i][3],planes[i][4]], {icon: blueIcon}).bindPopup("<b>Location: </b>"+planes[i][0]+"<br><b>Date:</b> "+planes[i][1]+"<br><b>Time: </b>"+planes[i][2]+"<br><b>Longitude: </b>"+planes[i][3]+ "<br><b>Latitude: </b>"+planes[i][4]+ "<br><b>Depth: </b>"+planes[i][5]+"<br><b>Magnitude: </b>"+planes[i][6]).addTo(map);  
                }
                else  if(planes[i][3] >= 7 && planes[i][3] < 8){
                    marker = new L.marker([planes[i][3],planes[i][4]], {icon: yellowIcon}).bindPopup("<b>Location: </b>"+planes[i][0]+"<br><b>Date:</b> "+planes[i][1]+"<br><b>Time: </b>"+planes[i][2]+"<br><b>Longitude: </b>"+planes[i][3]+ "<br><b>Latitude: </b>"+planes[i][4]+ "<br><b>Depth: </b>"+planes[i][5]+"<br><b>Magnitude: </b>"+planes[i][6]).addTo(map);  
                }
                else  if(planes[i][3] >= 8 && planes[i][3] < 10){
                    marker = new L.marker([planes[i][3],planes[i][4]], {icon: orangeIcon}).bindPopup("<b>Location: </b>"+planes[i][0]+"<br><b>Date:</b> "+planes[i][1]+"<br><b>Time: </b>"+planes[i][2]+"<br><b>Longitude: </b>"+planes[i][3]+ "<br><b>Latitude: </b>"+planes[i][4]+ "<br><b>Depth: </b>"+planes[i][5]+"<br><b>Magnitude: </b>"+planes[i][6]).addTo(map);  
                }
                else  if(planes[i][3] >= 10){
                    marker = new L.marker([planes[i][3],planes[i][4]], {icon: redIcon}).bindPopup("<b>Location: </b>"+planes[i][0]+"<br><b>Date:</b> "+planes[i][1]+"<br><b>Time: </b>"+planes[i][2]+"<br><b>Longitude: </b>"+planes[i][3]+ "<br><b>Latitude: </b>"+planes[i][4]+ "<br><b>Depth: </b>"+planes[i][5]+"<br><b>Magnitude: </b>"+planes[i][6]).addTo(map);  
                }
            }
        
            
        </script>

    <div id="legendContainer" class="col-lg-4 legend-container">
        
        <article>
            <img src="images/mag4to5.png" class="legendMag">
            <div class="legend-text">
                <p>Small magnitude </p> 
                <p>Movement: Moderate sudden</p>
            </div>
        </article>
        <article>
            <img src="images/mag5to7.png" class="legendMag">
            <div class="legend-text">
                <p>Moderate magnitude </p> 
                <p>Movement: Strong sudden</p>
            </div>
        </article>
        <article>
            <img src="images/mag7to8.png" class="legendMag">
            <div class="legend-text">
                <p>Major magnitude </p> 
                <p>Movement: Severe Sudden</p>
            </div>
        </article>
        <article>
            <img src="images/mag8to10.png" class="legendMag">
                <div class="legend-text">
                <p>Great magnitude </p> 
                <p>Movement: Very Severe</p>
            </div>
        </article>
        <article>
            <img src="images/mag10.png" class="legendMag">
            <div class="legend-text">
                <p>Super magnitude </p> 
                <p>Movement: Extreme</p>
            </div>
        </article>
    </div>
    <!-- end legend container -->
</div>
<!-- end display quake -->
<?php 
    closeConnection();
?>    
