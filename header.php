<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earthquake</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="./index.php">Earthquakes Localizer</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navEarthquakes" aria-controls="navEarthquakes" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navEarthquakes">
            <div class="navbar-nav">
            <a class="nav-item nav-link" href="index.php">Using QuakeML</a>
            <a class="nav-item nav-link" href="usgs.php">Using USGS Rest API</a>
            </div>
        </div>
    </nav>