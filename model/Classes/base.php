<?php
class base
{
    public $base_id;
    public $lat;
    public $long;


    public function __construct($base_id, $lat, $long)
    {
        $this->base_id = $base_id;
        $this->lat = $lat;
        $this->long = $long;
    }
}
?>
