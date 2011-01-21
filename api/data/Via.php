<?php

class Via {
    private $arrival;
    private $depart;
    private $timeBetween;
    private $vehicle;
    private $station;

    function __construct(ViaTripNode $arrival, ViaTripNode $depart, $timeBetween, Vehicle $vehicle = NULL, Station $station = NULL)
    {
        $this->arrival = $arrival;
		  $this->depart = $depart;
        $this->timeBetween = $timeBetween;
        $this->vehicle = $vehicle;
        $this->station = $station;
    }

    public function getArrival()
    {
        return $this->arrival;
    }

    public function getDepart()
    {
        return $this->depart;
    }

    public function getStation()
    {
        return $this->station;
    }

    public function getTimeBetween()
    {
        return $this->timeBetween;
    }

    public function getVehicle()
    {
        return $this->vehicle;
    }



}
?>
