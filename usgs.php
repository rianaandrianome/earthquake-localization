<?php include 'header.php'; ?>
        
<div class="container-fluid content">
    <h3>Earthquakes based on USGS Rest API</h3>

    
    <fieldset class="row btn-wrapper">
        <legend>Search</legend>
        <div>
            <button onclick="showLocation()" class="btn btn-info">Near your Location</button>
        </div>  
        <div class="wrap form-group">
            <input type="range" name="points" id="magSlider" value="0" min="0" max="10" oninput="sliderChange(this.value)" class="form-control">
            <span id="magValue">0</span>
            <button onclick="showMag()" class="btn btn-info">By magnitude</button>
        </div>  
        
        <div class="wrap form-group">
            <label for="startDate">From</label>
            <input type="date" id="startDate" class="form-control">
            <label for="endDate">To</label>
            <input type="date" id="endDate" class="form-control">
            <button onclick="showDate()" class="btn btn-info">By date range</button>
        </div>

        <div class="wrap form-group">
            <input type="number" id="minlatitude" placeholder="-90" class="form-control">
            <input type="number" id="minlongitude" placeholder="-180" class="form-control">
            <input type="number" id="maxlatitude" placeholder="90" class="form-control">
            <input type="number" id="maxlongitude" placeholder="180" class="form-control">
            <button onclick="showRectangle()" class="btn btn-info">Within a zone</button>
        </div>

</fieldset>
    <div id="wrapper" class="row">
        
        <div id="map" class="col-lg-8 map"></div>
        <script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
        <script>
            var map = L.map('map').setView([0, 0], 2);
            mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '&copy; ' + mapLink + ' Contributors',maxZoom: 10,}).addTo(map);

        </script>
        
        <div id="legendContainer" class="col-lg-4 legend-container">
            <article>
                <img src="images/mag4to5.png" class="legendMag">
                <div class="legend-text">
                    <p>Magnitude: 0 to 5</p> 
                    <p>Description: Small</p>
                    <p>Movement: Moderate sudden</p>
                </div>
            </article>    

            <article>
                <img src="images/mag5to7.png" class="legendMag">
                <div class="legend-text">
                    <p>Magnitude: 5 to 7</p> 
                    <p>Description: Moderate</p>
                    <p>Movement: Strong sudden</p>
                </div>
            </article>    

            <article>
                <img src="images/mag7to8.png" class="legendMag">
                <div class="legend-text">
                    <p>Magnitude: 7 to 8</p> 
                    <p>Description: Major</p>
                    <p>Movement: Severe Sudden</p>
                </div>
            </article>   

            <article>
                <img src="images/mag8to10.png" class="legendMag">
                <div class="legend-text">
                    <p>Magnitude: 8 to 10</p> 
                    <p>Description: Great</p>
                    <p>Movement: Very Severe</p>
                </div>
            </article>  

            <article>
                <img src="images/mag10.png"" class="legendMag">
                <div class="legend-text">
                    <p>Magnitude: 10+</p> 
                    <p>Description: Super</p>
                    <p>Movement: Extreme</p>
                </div>
            </article> 
            
            <article>
                <img src="images/date.png" class="legendMag">
                <div class="legend-text">
                    <p>From choosen period</p> 
                </div>
            </article> 

            <article>
                <img src="images/rectangle.png" class="legendMag">
                <div class="legend-text">
                    <p>From specific rectangle area</p> 
                </div>
            </article> 

        </div>
        
    </div>
        
          
            
        
            
        
         
</div>

<?php include 'footer.php'; ?>