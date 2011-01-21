<?php

include_once ("../api/IRail.php");
include_once ("../api/data/Connection.php");
include_once ("../api/data/TripNode.php");


class IRailExample
{
    const TEST_URL = "http://api.irail.be/";

	public function main(){
	
	    $iRail = new IRail(self::TEST_URL, "nl");
		 $iRail->setAgent("my cool agent");
		 
		 $connections = $iRail->getConnections("LIEDEKERKE","BRUSSEL CENTRAAL");
	    foreach($connections as $connection)
	    {
	            // skip connections that have transfers, to keep this example simple
	            if($connection->hasVias())        
	                continue;
	
	           $departure = $connection->getDeparture();	//TripNode 
	           $arrival  = $connection->getArrival();
	           
	          
	         echo "<br/>".$departure->getStation()->getId()."        ".$departure->getTime()->format('Y-m-d H:i:sP');
	         echo "<br/><span style='margin-left:30px;'>".$arrival->getStation()->getId()."        ".$arrival->getTime()->format('Y-m-d H:i:sP')."</span>";
	    }
	    
	    /*$liveboard = $iRail->getLiveBoard($departure->getStation());
	    
	    		foreach($liveboard->getArrivalsAndDepartures() as $node){
	    			echo "<br/>".$node->getStation()->getId();
	    			echo $node->getPlatform();
	    			echo $node->getDate()->format('Y-m-d H:i:s');
	    			
	    			
	    		}*/
	    		
	    /*$vehicleInfo = $iRail->getVehicleInformation($departure->getVehicle());
	    				foreach($vehicleInfo->getStops() as $stop){
	    		
		    				echo "<br/>".$stop->getStation()->getId();
	    					echo "<br/>".$stop->getTime()->format('Y-m-d H:i:s');
	    					echo "<br/>".$stop->getDelay();
	    				}*/
	    
	    /*$stations = $iRail->getStations();
	    foreach($stations as $station){
	    	echo $station->getId()."<br/>";
	    }*/
	    
	    
	}
}

$irailExample = new IRailExample();
$irailExample->main(); 
?>
