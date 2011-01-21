<?php


class Connection {

    private $departure; //TripNode 	
    private $arrival;	//TripNode
    private $vias = array();	//Via
    private $duration;			//int 
    
    function __construct(TripNode $arrival, TripNode $departure, $duration,  $vias)
    {
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->vias = $vias;
        $this->duration = $duration;
    }

    public function getDeparture() {
        return $this->departure;
    }

    public function getArrival() {
        return $this->arrival;
    }

    public function getVias() {
        return $this->vias;
    }

	 public function hasVias() {
	 	if(count($this->vias) > 0)
	 		return true;
	 	else
	 		return false;
	 }
    public function getDuration() {
        return $this->duration;
    }
}
?>
