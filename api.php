<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Earthquake</title>
        
        <script type="text/javascript" src="lib/jquery-1.12.2.js"></script>

        <script type="text/javascript" src="js/index.js"></script>
        <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css"/>
          

    </head>
    <body style="margin:0">
        
        <table style="background-color: #4E5574; color:white; width:100%">
            <tr>
                <td>
                    <a href="quake.php" style="text-decoration:none;">
                        <img src="images/arrowLeft.png" width="45px" height="45px" style=" border-radius:100%; ">
                    </a>
                </td>
                <td>
                     <h3 style="text-align:center; background-color: #4E5574; color:white; padding:5px; margin:0">Earthquake display based on USGS API</h3>
                </td>
                <td style="text-align:right;">
                    <a href="index.php" style="text-decoration:none;">
                        <img src="images/home.png" width="45px" height="45px" style=" border-radius:100%;">
                    </a>
                </td>
            </tr>
        </table>
                
        
   <br><br><br>
        <div id="wrapper" style="display: flex; 
    flex-direction: row;
    flex-wrap: nowrap;">
        
        <div id="map" style="width: 75%; height: 400px" ></div>
        <script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
        
        <script>
            var map = L.map('map').setView([0, 0], 2);
            mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '&copy; ' + mapLink + ' Contributors',maxZoom: 18,}).addTo(map);

        </script>
        
        <div id="rigthSide" style=" width: 25%; text-align: center; display: flex; flex-direction: column; flex-wrap: nowrap; overflow-y: scroll; height: 400px; padding:2px; margin:0">
        
            <div>
                <p style="background-color: grey; color: white;">Earthquakes by magnitude range</p>

                <input type="range" name="points" id="magSlider" value="0" min="0" max="10" oninput="sliderChange(this.value)">
                <span id="magValue">0</span>
                <br>
                <button onclick="showMag()">Show</button>

            </div>    
        
            <div>
                <p style="background-color: grey; color: white;">Earthquakes near your location</p>
                <button onclick="showLocation()">Show</button>
            
            </div>    
            
            <div>
                <p style="background-color: grey; color: white;">Earthquakes from a chosen period</p>
                <table style="width:100%">
                    <tr>
                        <td>From</td>
                        <td><input type="date" id="startDate"></td>
                    </tr>
                    <tr>
                        <td>To</td>
                        <td><input type="date" id="endDate"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button onclick="showDate()" style="width:100%">Show</button></td>
                    </tr>
                </table>
               </div>
            
            <div>
                <p style="background-color: grey; color: white;">View earthquakes in a specific rectangle bound</p>
                <table>
                    <tr>
                        <td>Min Latitude</td>
                        <td><input type="number" id="minlatitude" placeholder="-90"></td>
                    </tr>
                    <tr>
                        <td>Min Longitude</td>
                        <td><input type="number" id="minlongitude" placeholder="-180"></td>
                    </tr>
                    <tr>
                        <td>Max Latitude</td>
                        <td><input type="number" id="maxlatitude" placeholder="90"></td>
                    </tr>
                    <tr>
                        <td>Max Longitude</td>
                        <td><input type="number" id="maxlongitude" placeholder="180"></td>
                    </tr>
                </table>
                <button onclick=showRectangle()>Show Rectangle</button>
            </div>
            </div>
        
        </div>
        
        <div id="legendContainer2" style="width: 100%; text-align: center; display: flex; flex-direction: row; flex-wrap: nowrap;">
             <article style="text-align: center; font-size: 12px; margin:10px;">
                <img src="images/mag4to5.png" class="legendMag2" style="width: 40px; height: 40px; margin: 10px;"><br>
                 Magnitude: 0 to 5 <br>Description: Small <br> Movement: Moderate sudden
            </article>
            <article style="text-align: center; font-size: 12px; margin:10px;">
                <img src="images/mag5to7.png" class="legendMag2" style="width: 40px; height: 40px; margin: 10px;"><br>
                 Magnitude: 5 to 7 <br>Description: Moderate <br> Movement: Strong sudden
            </article>
            <article style="text-align: center; font-size: 12px; margin:10px;">
                <img src="images/mag7to8.png" class="legendMag2" style="width: 40px; height: 40px; margin: 10px;"><br>
                 Magnitude: 7 to 8 <br>Description: Major <br> Movement: Severe Sudden 
            </article>
            <article style="text-align: center; font-size: 12px; margin:10px;">
                <img src="images/mag8to10.png" class="legendMag2" style="width: 40px; height: 40px; margin: 10px;"><br>
                 Magnitude: 8 to 10 <br>Description: Great <br> Movement: Very Severe
            </article>
            <article style="text-align: center; font-size: 12px; margin:10px;">
                <img src="images/mag10.png" class="legendMag2" style="width: 40px; height: 40px; margin: 10px;"><br>
                Magnitude: 10+ <br> Description: Super <br> Movement: Extreme
            </article>
             <article style="text-align: center; font-size: 12px; margin:10px;">
                <img src="images/date.png" class="legendMag2" style="width: 40px; height: 40px; margin: 10px;"><br>
                From choosen period
            </article>
            <article style="text-align: center; font-size: 12px; margin:10px;">
                <img src="images/rectangle.png" class="legendMag2" style="width: 40px; height: 40px; margin: 10px;"><br>
                From specific rectangle area
            </article>
         </div>
        
    </body>
    
    
    
    
    
    
    
    
    
    
    