# Earthquake-localization web application
This app is built using PHP. The data are pulled from a free API found at: https://earthquake.usgs.gov/earthquakes/

The Json API Response are then treated and coordinates are sent to the Free Open Street Map Service found at: https://www.openstreetmap.org/

The Map markers are displayed and styled using the: https://leafletjs.com Javascript library. 

## Prerequisites 
Before installation, make sure that you have the following installed on your mahcine: 
* Apache
* Php
* Mysql 

An easy way to get around is to install a software such as: 
* WAMP for windows users
* LAMP for linux users 
* MAMP for mac users  

## Installation 
TO install the program, follow the steps below: 
* clone the repo into the root directory of your apache (e.g. www/)
* create a virtual host for the project in your apache host configs (.host file)
* start your apache server 
* open your virtual host on your browser 

## Collaborators

This project was built as a collaboration between 
[Zohary Andrianome](https://zoharyandrianome-portfolio.netlify.com/)
and
[Riana Andrianome](https://rianaandrianomeportfolio.netlify.com/)
