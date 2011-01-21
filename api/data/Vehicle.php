<?php


class Vehicle {
    
    private $id;
    private $number;
    private $company;
    private $country;
    private $type;

    function __construct($id, $country="", $company="", $type="", $number="")
    {
        $this->id         = $id;
        $this->number     = $number;
        $this->company    = $company;
        $this->country    = $country;
        $this->type       = $type;
    }


    public function getCompany()
    {
        return $this->company;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getType()
    {
        return $this->type;
    }
}
?>
