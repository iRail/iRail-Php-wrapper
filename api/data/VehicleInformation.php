<?php

class VehicleInformation {

	 private $vehicle;	//Vehicle
    private $stops;	//List<Stop>   

    function __construct(Vehicle $vehicle,$stops)
    {
        $this->vehicle = $vehicle;
        $this->stops = $stops;
    }

    public function getStops()
    {
        return $this->stops;
    }

    public function getVehicle()
    {
        return $this->vehicle;
    }

}

?>