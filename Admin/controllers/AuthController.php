<?php


namespace controllers\AuthController;

use controllers\ProductController\ProductController;
use core\Auth\Auth;
use core\controller\Controller;

require __DIR__ . "/../../core/Controller.php";

class AuthController_Admin extends Controller
{
    private $auth;
    function __construct()
    {
        $this->auth = new Auth();
    }

    function show_Admin_Login_Form()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_Email = $_POST['email'];
            $password = $_POST['password'];



            $success = $this->auth->login($user_Email, $password, "admins");
            
            if ($success) {
                // return $success;
                $this->redirect("index.php?page=admindashboard");
            } else {
                $this->view_Admin("auth/admin_Login", ["error" => "Invalid credentials"]);
            }
        } else {
            $this->view_Admin("auth/admin_Login");
        }
    }


    function log_Out()
    {
        $this->auth->logOut();
        $this->show_Admin_Login_Form();
    }
}
