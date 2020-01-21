<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earthquake</title>
    
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css"/>
    
    <link rel="stylesheet" href="css/index.css"/>
    
    <?php 
      error_reporting(E_ALL & ~E_NOTICE); 
      ini_set("display_errors", 0);
      include('dbConnection.php');
      connectToDatabase();
      
    ?>
    
</head>

<body style="margin:0">
    <table style="background-color: #4E5574; color:white; width:100%; ">
        <tr>
            <td>
                <a href="index.php" style="text-decoration:none;">
                        <img src="images/home.png" width="45px" height="45px" style=" border-radius:100%; ">
                </a>
            </td>
            <td>
                 <h3 style="text-align:center; background-color: #4E5574; color:white; padding:5px; margin:0">USGS Earthquake display based QuakeML file from the past 30 days </h3>
            </td>
            <td style="text-align:right;">
                <a href="api.php" style="text-decoration:none; ">
                <img src="images/arrowRight.png" width="45px" height="45px" style=" border-radius:100%;  ">
        </a>
            </td>
        </tr>
    </table>
          
<!--   -------------------------------------------------------------------------------- FORM --------------------------------------------------------------------------------->
    <form method="post">
        
        <table style="width:100%">
            <tr>
                <td colspan="5">Get latest record of earthquakes for the last 30 days depending on magnitude</td>
            </tr>
            <tr>
                <td><input type="submit" name="uploadUrlMagSignificant" value="Significant magnitude " class="btnGetRecord"></td>
                <td><input type="submit" name="uploadUrlMag4" value="Mgnitude of 4.5 + " class="btnGetRecord"></td>
                <td><input type="submit" name="uploadUrlMag2" value="Magnitude of 2.5+" class="btnGetRecord"></td>
                <td> <input type="submit" name="uploadUrlMag1" value="Magnitude of 1.0+" class="btnGetRecord"></td>
                <td><input type="submit" name="uploadUrlMagAll" value="All Earthquakes " class="btnGetRecord"></td>
            </tr>
        </table>
     
    </form>
    
    <!--   ------------------------------------------------------------------------- INITIALISE DB  --------------------------------------------------------------------------------->
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
    
    <!--   -------------------------------------------------------------------------------- DRAW MAP  AND LEGEND --------------------------------------------------------------------------------->
     <div id="display">
    <div id="map" style="width: 100%; height: 500px"></div>
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
    
        <div id="legendContainer">
             <p><b>Earthquakes are colored depending on their magnitude value</b></p>
            <article>
                <img src="images/mag4to5.png" class="legendMag"><br>
                 Description: Small <br> Movement: Moderate sudden
            </article>
            <article>
                <img src="images/mag5to7.png" class="legendMag"><br>
                 Description: Moderate <br> Movement: Strong sudden
            </article>
            <article>
                <img src="images/mag7to8.png" class="legendMag"><br>
                 Description: Major <br> Movement: Severe Sudden 
            </article>
            <article>
                <img src="images/mag8to10.png" class="legendMag"><br>
                 Description: Great <br> Movement: Very Severe
            </article>
            <article>
                <img src="images/mag10.png" class="legendMag"><br>
                 Description: Super <br> Movement: Extreme
            </article>
         </div>
         
    </div>
    
<?php 
    closeConnection();
?>    
</body>
</html>
