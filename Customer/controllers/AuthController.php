<?php


namespace controllers\AuthController;

use controllers\CartController\CartController;
use controllers\ProductController\ProductController;
use controllers\ProductController\ProductController_Customer;
use core\Auth\Auth;
use core\controller\Controller;
use core\Session\Session;

require __DIR__ . "/../../core/Controller.php";

class AuthController_Customer extends Controller
{
    private $auth;
    private $product;
    private $session;
    private $cart;
    function __construct()
    {
        $this->auth = new Auth();
        $this->session = Session::getInstance();
        $this->product = new ProductController_Customer();
        $this->cart = new CartController();
    }
    function show_Login_Form()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_Email = $_POST['email'];
            $password = $_POST['password'];



            $success = $this->auth->login($user_Email, $password, "users");
            if ($success) {
                // return $success;
                $this->redirect("index.php?page=products");
            } else {
                $this->view_Customer("auth/login", ["error" => "Invalid credentials"]);
            }
        } else {
            $this->view_Customer("auth/login");
        }
    }

    function logIn_Checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_Email = $_POST['email'];
            $password = $_POST['password'];



            $success = $this->auth->login($user_Email, $password, "users");

            if ($success) {

                $cart_Products = $this->session->getSessionValue("Cart_Items");
                $user_Id = $this->session->getSessionValue("id");

                $products_Quantity = $this->session->getSessionValue("quatity_of_products");


                foreach ($cart_Products as $item) {
                    $quantity = $products_Quantity[$item];
                    // echo " quantity => $quantity ";

                    $this->cart->add_Cart_items_Without($item, $user_Id, $quantity);
                }

                $url = strtok($_SERVER['HTTP_REFERER'], '&');

                $this->redirect($url);
            } else {

                $this->session->setSessionValue("error", "Invalid credentials");

                $this->session->setSessionValue("show_Login", true);

                // $url = strtok($_SERVER['HTTP_REFERER'], '&');
                $url = $_SERVER['HTTP_REFERER'];
                $this->redirect($url);
            }
        } else {
            $url = strtok($_SERVER['HTTP_REFERER'], '&');

            $this->redirect($url);
        }
    }

    function show_Registration_Form()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];

            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'address' => $address
            ];

            $success = $this->auth->registerUser($userData, "users");
            if ($success) {
                $this->redirect("index.php?page=login");
            } else {
                $this->view_Customer("auth/register", ["error" => "User already registered for $email !!!"]);
            }
        } else {
            $this->view_Customer("auth/register");
        }
    }


    function show_Registration_Form_CheckOut()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];

            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'address' => $address
            ];

            $success = $this->auth->registerUser($userData, "users");

            if ($success) {

                $url = strtok($_SERVER['HTTP_REFERER'], '&');
                // $this->session->setSessionValue("error", "User already exists !!!");
                $this->session->setSessionValue("show_Register", false);

                $this->session->setSessionValue("show_Login", true);


                $this->redirect($url);
            } else {
                $url = strtok($_SERVER['HTTP_REFERER'], '&');
                $this->session->setSessionValue("error", "User already exists !!!");
                $this->session->setSessionValue("show_Register", true);

                $this->redirect($url);
            }
        } else {
            $this->view_Customer("auth/register");
        }
    }


    function reset_Password()
    {
        $url = $_SERVER['HTTP_REFERER'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $current_Password = $_POST['current_password'];
            $new_Password = $_POST['new_password'];
            $confirm_Password = $_POST['confirm_password'];

            if ($new_Password === $confirm_Password) {
                $success = $this->auth->resetPassword($current_Password, $new_Password, "users");
                if ($success) {
                    $this->session->setSessionValue('message', 'Password updated');

                    $this->redirect($url);
                } else {
                    $this->session->setSessionValue('error', 'error updating password !!!');
                    $this->redirect($url);
                }
            } else {
                $this->redirect($url);
            }
        }
    }

    function reset_Password_()
    {
        $url = $_SERVER['HTTP_REFERER'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $current_Password = $_POST['current_password'];
            $new_Password = $_POST['new_password'];
            $confirm_Password = $_POST['confirm_password'];

            if ($new_Password === $confirm_Password) {
                $success = $this->auth->resetPassword($current_Password, $new_Password, "users");
                if ($success) {
                    $this->session->setSessionValue('message', 'Password updated');

                    $this->redirect($url);
                } else {
                    $this->session->setSessionValue('error', 'error updating password !!!');
                    $this->redirect($url);
                }
            } else {
                $this->redirect($url);
            }
        }
    }

    function update_security_codes()
    {
        $success = $this->auth->update_security_codes();
        echo " $success ..........";
        $url = $_SERVER['HTTP_REFERER'];
        // if ($success==4) {
        $this->session->setSessionValue('message', 'Security codes Updated');

        $this->redirect($url);
        // }
        //  else {
        //     $this->session->setSessionValue('error', 'error updating codes !!!');
        //     $this->redirect($url);
        // }
    }

    function forgot_Password_code_check()
    {
        $url = $_SERVER['HTTP_REFERER'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'];
            $code = $_POST['code'];
           
            $success = $this->auth->forgot_Password($code,$email);

            if ($success) {
                $this->session->setSessionValue('message','update the password');
                $this->redirect("index.php?page=products");
            }
           } else {
                $this->redirect($url);
            }
        
    }

    function log_Out()
    {
        $this->auth->logOut();
        $this->redirect("index.php?page=products");
    }
}
