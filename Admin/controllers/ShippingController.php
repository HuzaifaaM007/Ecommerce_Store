<?php

namespace controllers\ShippingController;

use models\Shipping\Shipping;

class ShippingController{

    private $shipping;

    function __construct()
    {
        $this->shipping= new Shipping();
    }

    function select_Method(){

    }

    function Calculate(){
        
    }
}