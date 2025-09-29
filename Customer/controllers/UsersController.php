<?php

namespace controllers\UsersController;

use controllers\OrderController\OrderController_Admin;
use core\controller\Controller;
use core\Session\Session;
use models\Order\Order;
use models\User\User;

class UsersController_Customer extends Controller
{

    private $user;
    private $session;
    private $order;

    function __construct()
    {
        $this->user = new User();
        $this->session = Session::getInstance();
        $this->order = new Order();
    }

    function get_Users()
    {

        if ($this->session->has("login") && $this->session->has("isadmin")) {

            $output = $this->user->get_All_Users();
            $this->view_Admin("admin/users", ["users" => $output]);
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }

    function get_User_By_Id()
    {
        $user_id = $this->session->getSessionValue('id');

        $output = $this->user->get_User_By_Id($user_id);

        $this->view_Customer("users/profile", ["user" => $output[0]]);
    }

    function delete_User_by_id()
    {

        $user_id = $this->session->getSessionValue('id');

        $success =  $this->user->delete_User($user_id);

        if ($success) {

            $this->session->destroySession();
            $this->redirect("index.php?page=products");
        } else {
            $url = $_SERVER['HTTP_REFERER'];
            $this->redirect($url);
        }
    }

    function user_setting()
    {

        $user_id = $this->session->getSessionValue('id');

        $output = $this->user->get_User_By_Id($user_id);

        $security_output = $this->user->get_security_codes();

        $this->view_Customer("users/settings", ["user" => $output[0],"codes"=>$security_output]);
    }

    function get_security_code()
    {


        // $this->;
    }

    function cancel_modal(){
            $url = $_SERVER['REQUEST_METHOD'];
            $this->session->setSessionValue("show_account_modal", false);

            $this->redirect($url);

    }
    function update_Users()
    {
        $user_id = $this->session->getSessionValue('id');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];


            $userData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address
            ];

            $success = $this->user->update_User($userData, ["id" => $user_id]);

            if ($success) {
                $url = $_SERVER['HTTP_REFERER'];
                $this->session->setSessionValue('message', 'Profile Updated');
                $this->redirect($url);
            }
        } else {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->setSessionValue('error', 'Error updating profile !!!');
            $this->redirect($url);
        }
    }
}
