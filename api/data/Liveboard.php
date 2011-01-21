<?php

class Liveboard
{
    private $timeStamp;	//DateTime 
    private $station;	//Station
    private $arrivalsAndDepartures;	//ArrivalDeparture array 

    function __construct(DateTime $timeStamp, Station $station, $arrivalsAndDepartures)
    {
        $this->timeStamp = $timeStamp;
        $this->station = $station;
        $this->arrivalsAndDepartures = $arrivalsAndDepartures;
    }

    public function getArrivalsAndDepartures()
    {
        return $this->arrivalsAndDepartures;
    }

    public function getStation()
    {
        return $this->station;
    }

    public function getTimeStamp()
    {
        return $this->timeStamp;
    }
}
?>