<?php


include_once ("/var/www/iRailParser/api/data/ArrivalDeparture.php");
include_once ("/var/www/iRailParser/api/data/Location.php");
include_once ("/var/www/iRailParser/api/data/Station.php");
include_once ("/var/www/iRailParser/api/data/TripNode.php");
include_once ("/var/www/iRailParser/api/data/Vehicle.php");
include_once ("/var/www/iRailParser/api/data/Via.php");
include_once ("/var/www/iRailParser/api/data/ViaTripNode.php");
include_once ("/var/www/iRailParser/api/data/Connection.php");
include_once ("/var/www/iRailParser/api/data/Liveboard.php");
include_once ("/var/www/iRailParser/api/data/Stop.php");
include_once ("/var/www/iRailParser/api/data/VehicleInformation.php");

class IRailParser
{

    public static function parseLiveboard($url)
    {
        
		  $xml = simplexml_load_file($url);        
        $s = NULL;		//Station
        
        $nodes = array();	//ArrayList<ArrivalDeparture>  
        $rootNode = $xml;
        $liveboardNodes = $rootNode->children();
        
        $timeStamp = $xml->attributes()->timestamp;
        
        if ($rootNode->getName() == "error")
        {
        		$child = $rootNode->children();
            throw new Exception("error:" + $child[0]);
        }
        for ($i = 0; $i < $rootNode->count(); $i++)
        {
            if ($liveboardNodes[$i]->getName() == "station")
            {
                $s = self::readStation($liveboardNodes[$i]);
            }
            else if ($liveboardNodes[$i]->getName() == "arrivals" || $liveboardNodes[$i]->getName() == "departures")
            {
                $nodes = self::readLiveboardNodes($liveboardNodes[$i]);
            }

        }
        return new Liveboard(new DateTime('@'.$timeStamp), $s, $nodes);
    }


    public static function parseVehicle($url)
    {
		  $xml = simplexml_load_file($url);        
        $s = null;		//Station
        
        $stops = array();	//ArrayList<ArrivalDeparture>  
        $rootNode = $xml;
        $connectionNodes = $rootNode->children();
     
        $v = NULL;	//Vehicle 
        
         if ($rootNode->getName() == "error")
        {
        		$child = $rootNode->children();
            throw new Exception("error:" + $child[0]);
        }
        for ($i = 0; $i < $rootNode->count(); $i++)
        {            
            if ($connectionNodes[$i]->getName() == "vehicle")
            {
                $v = self::readVehicle($connectionNodes[$i]);
            }
            else if ($connectionNodes[$i]->getName() == "stops")
            {
                $stops = self::readStoplist($connectionNodes[$i]->children());
            }

        }
        return new VehicleInformation($v, $stops);
    }



    public static function parseConnections($url)
    {
    
    	  $xml = simplexml_load_file($url);        
        $s = NULL;		//Station
        
        $cons = array(); //ArrayList<Connection> 
        $rootNode = $xml;
        $connectionNodes = $rootNode->children();        

		   if ($rootNode->getName() == "error")
        {
        		$child = $rootNode->children();
            throw new Exception("error:" + $child[0]);
        }
        for ($i = 0; $i < $rootNode->count(); $i++)
        {            
            $c = self::readConnection($connectionNodes[$i]->children());	//Connection 
            array_push($cons, $c);
        }
        return $cons;
    }


    public static function  parseStations($url)
    {        
        $xml = simplexml_load_file($url);        
        $s = null;		//Station
        
        $stations = array(); //ArrayList<Connection> 
        $rootNode = $xml;
        $stationNodes = $rootNode->children();        


         if ($rootNode->getName() == "error")
        {
        		$child = $rootNode->children();
            throw new Exception("error:" + $child[0]);
        }
        for ($i = 0; $i < $rootNode->count(); $i++)
        {    
            $s = self::readStation($stationNodes[$i]);	//Station 
            array_push($stations, $s);
        }
        return $stations;
    }
    
	
	/* --------------------------------------------------------------------------------------------- */


    private function readConnection($childNodes)
    {
        $dep = NULL;	//TripNode
        $arr = NULL;	//TripNode
        $duration = 0;
        $vias = array();
        
        for ($i = 0; $i < $childNodes->count(); $i++)
        {
            $n = $childNodes[$i];

            if ($n->getName() == "departure")
            {
                $dep = self::readTripNode($n);
            }
            else if ($n->getName() == "arrival")
            {
                $arr = self::readTripNode($n);
            }
            else if ($n->getName() == "duration")
            {
                $duration = (int) $n[0];
            }
            else if ($n->getName() == "vias")
            {
                $vias = self::readVias($n->children());
            }
        }
        
        return new Connection($arr, $dep, $duration, $vias);
    }


    private function readTripNode($node)
    {
        $st = NULL;	//Station 
        $platform = NULL;	//String
        $v = NULL;	//Vehicle 
        $t = NULL;		//int Date TODO 

        $m = $node->attributes();
        $delay = (int)$m->delay;

        $nodes = $node->children();

        for ($i = 0; $i < $node->count(); $i++)
        {
            $n = $nodes[$i];
            if ($n->getName() == "station")
            {
                $st = self::readStation($n);
            }
            else if ($n->getName() == "platform")
            {
                if ($n[0] != NULL)
                {
                    $platform = $n[0];
                }
            }
            else if ($n->getName() == "vehicle")
            {
                $v = self::readVehicle($n);
            }
            else if ($n->getName() == "time")
            {
                $t = $n[0];
            }
            else if ($n->getName() == "delay")   // does this ever occur as a node?
            {
                $delay = $n[0];
            }
        }
        $timeformat = new DateTime('@'.$t);
        return new TripNode($st, $platform, $v, $timeformat, $delay);
    }


    private function readVias($nodes)
    {
        $vias = array(); //ArrayList<Via> 
        for ($i = 0; $i < $nodes->count(); $i++)
        {
            $v = self::readVia($nodes[$i]->children());	//Via 
            array_push($vias,$v);
        }
        return $vias;
    }


    private function readStation($n)
    {
    	  
        $m = $n->attributes();
        $x = $m->locationX;
        $y = $m->locationY;
        $id = $m->id;
        $g = new Location($x, $y);
        
        return new Station($n[0], $id, $g);
    }


    private function readVehicle($n)
    {
    	  $child = $n->children();
		  
        		if (preg_match('/([A-Za-z][A-Za-z])\.([A-Za-z]+)\.([a-zA-Z]+)?([0-9]+)$/', $n, $matches))
        		{
	            $country = $matches[1];
            	$company = $matches[2];
            	$type = $matches[3];
            	$number = (int) $matches[4];
            
            	return new Vehicle($n, $country, $company, $type, $number);
        		}                
        		else
        		{
	        		throw new Exception("parse error ".$child[0]);
   	     }
   	  
    }


    private function readVia($nodes)
    {
        $arr = NULL;	//ViaTripNode
        $dep = NULL;	//ViaTripNode 
        $v = NULL;	//Vehicle
        $timeBetween = 0;
        $s = NULL;	//Station  
        
        for ($i = 0; $i < $nodes->count(); $i++)
        {
        		
        		
            $n = $nodes[$i];
            if ($n->getName() == "station")
            {
                $s = self::readStation($n);
                
            }
            else if ($n->getName() == "arrival")
            {
                $arr = self::readViaTripNode($n->children());
                echo $arr->getPlatform();
                
            }
            else if ($n->getName() == "departure")
            {
                $dep = self::readViaTripNode($n->children());
            }
            else if ($n->getName() == "vehicle")
            {
                $v = self::readVehicle($n);
            }
            else if ($n->getName() == "timeBetween")
            {
                $timeBetween = (int) $n[0];
            }
        }
        return new Via($arr, $dep, $timeBetween, $v, $s);
    }


    private function  readViaTripNode($nodes)
    {
        $platform = NULL;
        $t = NULL;  	//DateTime
        for ($i = 0; $i < $nodes->count(); $i++)
        {
            $n = $nodes[$i];
            if ($n->getName() == "platform")
            {
                $platform = $n[0];
            }
            else if ($n->getName() ==  "time")
            {
                $t = $n[0];
            }
        } 
        return new ViaTripNode($platform, $t);
    }


    private function  readLiveboardNodes($node)
    {
        
        $a = array(); //ArrayList<ArrivalDeparture> 
        

        $nodes = $node->children();
        echo $node->count();
        echo $nodes->count();
        for ($i = 0; $i < $node->count(); $i++)
        {
            $n = $nodes[$i]->children();
            $m = $nodes[$i]->attributes();
            $s = NULL;	//Station 
            $v = NULL;	//Vehicle 
            $d = NULL; //DateTime 
            $p = NULL;
            $delay = (int) $m->delay;
            $left = (int) ($m->left ==1);
            
            for ($j = 0; $j < $n->count(); $j++)
            {
                if ($n[$j]->getName() == "vehicle")
                {
                    $v = self::readVehicle($n[$j]);
                }
                else if ($n[$j]->getName() == "time")
                {
                	   $d = new DateTime('@'.$n[$j]);
                }
                else if ($n[$j]->getName() ==  "station")
                {
                    $s = self::readStation($n[$j]);
                }
                else if ($n[$j]->getName() == "platform")
                {
                    $p = $n[$j];
                }
            }
            //TODO parameters boolean 
            $ad = new ArrivalDeparture($s, $v, $d, $p, $delay, $left); //ArrivalDeparture
            array_push($a, $ad);

        }
        return $a;
    }


    private function readStoplist($nodes)
    {
        $a = array(); 	//ArrayList<Stop>  
        for ($i = 0; $i < $nodes->count(); $i++)
        {
            $stoplist = $nodes[$i]->children();
            $s = NULL;	//Station
            $delay = (int) $nodes[$i]->attributes()->delay;
            $time = NULL; //DateTime
            for ($j = 0; $j < $stoplist->count(); $j++)
            {
                if ($stoplist[$j]->getName() == "station")
                {
                    $s = self::readStation($stoplist[$j]);
                }
                else if ($stoplist[$j]->getName() == "time")
                {
                	//TODO
                    $time = new DateTime('@'.$stoplist[$j]);
                }
            }
            array_push($a, new Stop($s, $time, $delay));
        }
        return $a;

    }
}
?>