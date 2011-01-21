<?php

class Location {

	 private $longitude;
	 private $latitude; 
	 
    function __construct($longitude, $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

	 function getLongitude()
    {
        return $this->longitude;
    }

    function getLatitude()
    {
        return $this->latitude;
    }

}

?>