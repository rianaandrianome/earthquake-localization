<?php
      $connection = null;
	  
function connectToDatabase(){
      $serverName = "localhost";
  		$userName = "root";
  		$password = "";
  		$databaseName = "earthquakedb";
      
      //create connection and select database by given data
      $GLOBALS["connection"] = mysqli_connect($serverName, $userName, $password, $databaseName);
      if (!$GLOBALS["connection"])
      {
          die("Connection failed: " . mysqli_connect_error());
      }
	//echo "Connected successfully";
  }
  
  function closeConnection (){
		try{
      mysqli_close($GLOBALS["connection"]);
    }catch (Exception $exc){
      //echo ($exc->getMessage() . "<br>");
    }
  }


function initaliseDb(){
    $sqlDrop = "DROP TABLE earthquakes; ";
    //if insert was successful else display the error
    if (mysqli_query($GLOBALS["connection"], $sqlDrop)) {
      //echo "<p style='color:green; font-weight:bold;'>table dropped</p>";
    } else {
      //echo "Error: " . $sqlDrop . "<br>" . mysqli_error($GLOBALS["connection"]);
    }

    $sqlCreate = "CREATE TABLE earthquakes (id integer not null AUTO_INCREMENT, location varchar(255), date varchar(10), time varchar(8), longitude double, latitude double, depth integer, magnitude float, CONSTRAINT pk_earthquakes PRIMARY KEY(id))";
    //if insert was successful else display the error
    if (mysqli_query($GLOBALS["connection"], $sqlCreate)) {
      //echo "<p style='color:green; font-weight:bold;'>table created</p>";
    } else {
      //echo "Error: " . $sqlCreate . "<br>" . mysqli_error($GLOBALS["connection"]);
    }

}

function insertInDb(){
   
       $xml=simplexml_load_file("uploads/quake.xml") or die("Error: Cannot create object");     
          foreach($xml->children() as $eventParameters){
              foreach($eventParameters->children() as $event){
                  $location1 = $event->description->text;
                  $location = str_replace("'", "`", $location1); 
                  $datetime = $event->origin->time->value; 
                  $date = substr($datetime, 0, strpos($datetime, 'T')); 
                  $time = substr($datetime, 11, 8); 
                  $longitude  = (double) $event->origin->longitude->value; 
                  $latitude  = (double)$event->origin->latitude->value;
                  $depth  = (int)$event->origin->depth->value; 
                  $magnitude  = (float)$event->magnitude->mag->value; 
                  
                 //echo " <br>location: ". $location. "<br> Date: ".$date. "<br> Time: ". $time . "<br> Longitude: ".$longitude. "<br> Latitude: ".$latitude. "<br> Depth: ".$depth. "<br> Magnitude: ".$magnitude."<br>";
                  
                   $sqlInsert = "INSERT INTO earthquakes (location, date, time, longitude, latitude, depth, magnitude) VALUES ('$location', '$date', '$time', '$longitude', '$latitude', '$depth', '$magnitude')";
                  
                    //if insert was successful else display the error
                    if (mysqli_query($GLOBALS["connection"], $sqlInsert)) {
                      echo "";
                    } else {
                      echo "Error: " . $sqlInsert . "<br>" . mysqli_error($GLOBALS["connection"]);
                    }
                  
            }// end foreach
          }// end foreach
}

function selectAll(){
    $qlSelect = "SELECT * from earthquakes"; 
    $result = mysqli_query($GLOBALS["connection"], $qlSelect);
    

    if (mysqli_num_rows($result) > 0) {
        
        echo '{"earthquakes":['; 
        
        while($row = mysqli_fetch_assoc($result)) {
       
            echo  '{ "location":"'. $row["location"]. '", "date":"'. $row["date"]. '", "time":"'. $row["time"]. '", "longitude":"'. $row["longitude"]. '", "latitude":"'. $row["latitude"]. '", "depth":"'. $row["depth"]. '", "magnitude":"'. $row["magnitude"]. '"},'; 
         }
        
        echo ']}'; 
    }
    else{
        echo "Error when retreiving from db"; 
    }

}









?>