<?php

class Station {

    private $name;	//String 
    private  $id;		//String
    private $location; //Location 

    function __construct($name, $id = NULL, $location = NULL)
    {
        $this->id = $id;
        $this->name = trim($name);
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    
}
?>
