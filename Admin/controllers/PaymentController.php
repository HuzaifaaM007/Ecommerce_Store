<?php

namespace controllers\PaymentController;

use core\controller\Controller;
use models\Payments\Payment;

class PaymentController extends Controller{

    private $payments;

    function __construct()
    {
        $this->payments= new Payment();
    }

    function select_Payment_method(){

    }

    function process_Payment(){}

    function payment_Status(){

    }

    
}