<?php

class ViaTripNode {

	 private $platform;
    private $time;

    function __construct($platform, $time)
    {
        $this->platform = $platform;
        $this->time = $time;
    }

    public function getPlatform()
    {
        return $this->platform;
    }

    public function getTime()
    {
        return $this->time;
    }

}

?>