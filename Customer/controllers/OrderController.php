<?php

namespace controllers\OrderController;

use core\controller\Controller;
use core\Session\Session;
use models\Cart\Cart;
use models\Order\Order;
use models\Payments\Payment;
use models\Product\Product;
use models\Shipping\Shipping;
use models\User\User;

class OrderController_Customer extends Controller
{


    private $user;
    private $product;
    private $order;
    private $shipping;
    private $cart;
    private $payment;
    private $session;


    function __construct()
    {
        $this->order = new Order();
        $this->shipping = new Shipping();
        $this->cart = new Cart();
        $this->payment = new Payment();
        $this->product = new Product();
        $this->user = new User();
        $this->session = Session::getInstance();
    }


    function check_Out()
    {
        $shipOutput = $this->shipping->get_Method_By_Id('1');
        $cartOutput = $this->cart->get_Cart_items();
        $paymentOutput = $this->payment->get_Method_By_Id('1');

        $this->view_Customer("users/checkout", ["cart" => $cartOutput, "shipping_methods" => $shipOutput, "payment_methods" => $paymentOutput]);
    }


    function check_Out_Without()
    {
        $shipOutput = $this->shipping->get_Method_By_Id('1');
        $paymentOutput = $this->payment->get_Method_By_Id('1');

        
    }

    function place_order()
    {
        $order_Data = [];
        
        $user_id = $this->session->getSessionValue('id');

        $user_Output = $this->user->get_User_By_Id($user_id);



        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            foreach ($user_Output as $user_Data) {
                $description = "delivering {$_POST['products_Quantity']} products to {$user_Data['address']} for {$user_Data['name']} ....";
            }
            if ($_POST['shipping_method'] == 'POST') {
                $shippingData = [

                    "name" => "POST",
                    "description" => $description,
                    "estimated_days" => 5,
                    "cost" => 20*$_POST['products_Quantity']
                ];

                $Ship_output =  $this->shipping->create_shipping($shippingData);

                if ($Ship_output) {
                    $shipping_Output_User = $this->shipping->get_Method_By_shipping_data($shippingData);
                }
            }

            if ($_POST['payment_method'] == 'cod') {
                $paymentData = [

                    "method" => "cod",
                    "amount" => $_POST['total_payment']
                ];

                $pay_Output = $this->payment->process_Payment($paymentData);

                if ($pay_Output) {
                    $payment_Output_User = $this->payment->get_Method_By_Payment_data($paymentData);
                }
            }

            $order_Data['user_id'] = $user_id;
            $order_Data['shipping_id'] = $shipping_Output_User[0]['id'];
            $order_Data['payment_id'] = $payment_Output_User[0]['id'];
            // echo $payment_Output_User[0]['id'];
            // echo "................{$_POST['total_payment']}...........................";
            $order_Data['total_amount'] = $_POST['total_payment'];

            $order_created = $this->order->create_Order($order_Data);

            $order_items = [];
            $products = [];

            if (isset($_POST['products'])) {
                foreach ($_POST['products'] as $product) {
                    $productId   = $product['id'];
                    $name        = $product['name'];
                    $quantity    = $product['quantity'];
                    $price       = $product['price'];

                    $order_items[] = [
                        'product_id'       => $productId,
                        'quantity' => $quantity,
                        'price'    => $price


                    ];
                    $products[] = [
                        'product_id' => $productId,
                        'product_name' => $name,
                        'product_quantity' => $quantity
                    ];
                }
            }

            if ($order_created) {



                $orders_Output = $this->order->get_order_by_user_and_shipping_id($shipping_Output_User[0]['id']);

                $order_id =  $orders_Output[0]['order_id'];

                foreach ($products as $product_) {
                    $pid = $product_['product_id'];
                    $pname = $product_['product_name'];
                    $product_Output = $this->product->get_Product_By_Id($pid);

                    $product_Stock = $product_Output[0]['stock'];


                    $product_Stock -= $product_['product_quantity'];

                    $product_data = ['stock' => $product_Stock];

                    $this->product->update_Product($pid, $pname, $product_data);
                }

                foreach ($order_items as $p) {
                    $p['order_id'] = $order_id;

                    $this->order->create_Order_item($p);
                }

                $cartClear = $this->cart->clear_Cart();

                if ($cartClear) {


                    $user_order_id_output = $this->order->get_order_by_user_and_order_id($order_id);





                    $order_Items_Ouput = $this->order->get_Order_Item_by_OrderId($order_id);


                    $this->view_Customer("orders/placeorders", ["order" => $user_order_id_output, "order_items" => $order_Items_Ouput]);
                }
            } else {
                $this->orders_History($user_id);
            }
        }
    }

    function orders_History()
    {
        $user_id = $this->session->getSessionValue('id');
        if ($this->session->has('login')) {

            $Orders_Output = $this->order->get_user_orders($user_id);



            if (!empty($Orders_Output)) {
                $order_items_data = [];
                foreach ($Orders_Output as $orders) {


                    $order_items_data[$orders['order_id']] = $this->order->get_Order_Item_by_OrderId($orders['order_id']);
                }


            } else {
                $order_items_data = [];
            }



            $this->view_Customer("users/orders", ["orders" => $Orders_Output, "orderitems" => $order_items_data]);
        } else {
            $this->view_Customer("auth/login");
        }
    }
}
