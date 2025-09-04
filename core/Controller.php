<?php

namespace core\controller;

use traits\Logger\Logger;

class Controller
{
    use Logger;

    public function view_Admin($path, $data = [])
    {
        $this->logmessage($path . "view is displaying...");
        extract($data);
        if ($path=="auth/admin_Login") {
            include __DIR__ . "/../Admin/views/$path.php";
        } else {
            include __DIR__ . "/../views/layouts/header.php";
            include __DIR__ . "/../Admin/views/$path.php";
            include __DIR__ . "/../views/layouts/footer.php";
        }
    }

    public function view_Customer($path, $data = [])
    {
        $this->logmessage($path . "view is displaying...");
        extract($data);
        if ($path == "auth/login" || $path == "auth/register" ) {
            include __DIR__ . "/../Customer/views/$path.php";
        } else {
            include __DIR__ . "/../views/layouts/header.php";
            include __DIR__ . "/../Customer/views/$path.php";
            include __DIR__ . "/../views/layouts/footer.php";
        }
    }

    public function redirect($url)
    {
        $this->logmessage("Redirected to URL:" . $url);
        header("Location: $url");
        exit;
    }
}
