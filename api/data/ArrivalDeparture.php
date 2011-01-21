<?php

include_once ("Station.php");
include_once ("Vehicle.php");

class ArrivalDeparture {

	 private $station;	//Station
    private $vehicle;  //Vehicle 
    private $date;		//DateTime
    private $platform;	//string 
    private $delay;	//int
    private $left;	//boolean 

    function __construct(Station $station = NULL, Vehicle $vehicle = NULL, DateTime $date, $platform, $delay, $left)
    {
        $this->station    = $station;
        $this->vehicle    = $vehicle;
        $this->date       = $date;
        $this->platform   = $platform;
        $this->delay      = $delay;
        $this->left       = $left;
    }

    public function getDate()
    {
        return $this->date;
    }

    function getPlatform()
    {
        return $this->platform;
    }

    function getStation()
    {
        return $this->station;
    }

    function getVehicle()
    {
        return $this->vehicle;
    }

    function getDelay()
    {
        return $this->delay;
    }

    function hasLeft()
    {
        return $this->left;
    }

    function shouldHaveLeftAt(DateTime $atTime)
    {
    		if($atTime->getTimeStamp() > $this->date->getTimeStamp())
    			return true;
    		else
    			return false;
    }

}

?>