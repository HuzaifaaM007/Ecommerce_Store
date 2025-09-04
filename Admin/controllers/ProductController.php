<?php

namespace controllers\ProductController;

use core\controller\Controller;
use core\Session\Session;
use models\Category\Category;
use models\Product\Product;

class ProductController_Admin extends Controller
{
    private $Product;
    private $category;
    private $session;

    function __construct()
    {
        $this->session = Session::getInstance();
        $this->Product = new Product();
        $this->category = new Category();
    }

    function show_All_Products()
    {

        if ($this->session->has("login") && $this->session->has("isadmin")) {

            $output = $this->Product->get_All_Products();


            $this->view_Admin("products/products", ["products" => $output]);
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }

    function show_products_Admin()
    {
        if ($this->session->has("login") && $this->session->has("isadmin")) {

            $output = $this->Product->get_All_Products();


            $this->view_Admin("products/products", ["products" => $output]);
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }


    function show_Product_By_Id($id)
    {

        if ($this->session->has("login") && $this->session->has("isadmin")) {
            $output = $this->Product->get_Product_By_Id($id);
            if (!empty($output)) {
                $this->view_Admin("products/detail", ["products" => $output]);
                // print_r($output);    
            }
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }

    function create_New_Product()
    {

        if ($this->session->has("login") && $this->session->has("isadmin")) {
            $data = [];

            //     category_id INT NOT NULL,
            // name VARCHAR(200) NOT NULL,
            // description TEXT,
            // price DECIMAL(10,2) NOT NULL,
            // stock INT DEFAULT 0,
            // image VARCHAR(255),
            // published TINYINT(1) DEFAULT 1, -- 1 = published, 0 = unpublished
            $categoryOutput = $this->category->get_All_Category();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data['category_id'] = $_POST['category_id'];
                $data['name'] = $_POST['name'];
                $data['description'] = $_POST['description'];
                $data['price'] = $_POST['price'];
                $data['stock'] = $_POST['stock'];
                $data['published'] = isset($_POST['published']) ? 1 : 0;



                $imagePath = null;
                if (!empty($_FILES['image']['name'])) {
                    $uploadDir = __DIR__ . '/../public/uploads/products/';

                    // Make sure folder exists
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileName = time() . "_" . basename($_FILES['image']['name']);
                    $targetFile = $uploadDir . $fileName;
                    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    // Validate image type
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
                    if (!in_array($fileType, $allowedTypes)) {
                        $this->view_Admin("admin/createproduct", ["error" => "Error allowed image types : " . $allowedTypes . " !!!"]);
                    } else {
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {

                            $imagePath = "uploads/products/" . $fileName;

                            echo "....\n" . $imagePath . "....\n";
                        }
                    }
                }
                $data['image'] = $imagePath;
                // echo "\n\n$uploadDir\n\n";
                // print_r($data);
                $success = $this->Product->create_Product($data);

                if ($success) {
                    $this->view_Admin("products/createproduct", ["success" => "New product: " . $data['name'] . " added  ...", "categories" => $categoryOutput]);
                } else {
                    $this->view_Admin("products/createproduct", ["error" => "Error creating new Product : " . $data['name'] . " !!!", "categories" => $categoryOutput]);
                }
            } else {
                $this->view_Admin("products/createproduct", ["categories" => $categoryOutput]);
            }
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }

    function edit_product($id, $name)
    {
        if ($this->session->has("login") && $this->session->has("isadmin")) {
            $data = [];

            //     category_id INT NOT NULL,
            // name VARCHAR(200) NOT NULL,
            // description TEXT,
            // price DECIMAL(10,2) NOT NULL,
            // stock INT DEFAULT 0,
            // image VARCHAR(255),
            // published TINYINT(1) DEFAULT 1, -- 1 = published, 0 = unpublished
            $categoryOutput = $this->category->get_All_Category();
            $ProductOutput = $this->Product->get_Product_By_Id($id);
            // $ProductOutput['id']=$id;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data['id'] = $_POST['id'];
                $data['category_id'] = $_POST['category_id'];
                $data['name'] = $_POST['name'];
                $data['description'] = $_POST['description'];
                $data['price'] = $_POST['price'];
                $data['stock'] = $_POST['stock'];
                $data['published'] = isset($_POST['published']) ? 1 : 0;

                $page = $_SERVER['PHP_SELF'];
                $query_String = $_SERVER['QUERY_STRING'];

                $imagePath =  null;

                if (!empty($_FILES['image']['name'])) {
                    $uploadDir = __DIR__ . '/../public/uploads/products/';

                    // Make sure folder exists
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileName = "_" . basename($_FILES['image']['name']);
                    $targetFile = $uploadDir . $fileName;
                    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    // Validate image type
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
                    if (!in_array($fileType, $allowedTypes)) {
                        $this->view_Admin("products/createproduct", ["error" => "Error allowed image types : " . $allowedTypes . " !!!"]);
                    } else {
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {

                            $imagePath = "uploads/products/" . $fileName;

                            echo "....\n" . $imagePath . "....\n";
                        }
                    }
                } else {
                    $imagePath = $_POST['old_image'];
                }
                $data['image'] = $imagePath;
                // echo "\n\n$uploadDir\n\n";
                // print_r($data);
                // $pid = $ProductOutput[0]['id'];
                $success = $this->Product->update_Product($data['id'], $data['name'], $data);

                if ($success) {
                    $productsAll = $this->Product->get_All_Products();

                    $this->view_Admin("products/products", ["success" => " $id Product: " . $data['name'] . print_r($ProductOutput) . " updated ...", "categories" => $categoryOutput, "products" => $productsAll]);
                } else {
                    $this->view_Admin("products/edit_product", ["error" => "Error updating Product : " . $data['name'] . " !!!", "categories" => $categoryOutput,]);
                }
            } else {
                $this->view_Admin("products/edit_product", ["categories" => $categoryOutput, "products" => $ProductOutput]);
            }
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }

    function delete_product($id, $name)
    {
        $success =  $this->Product->delete_Product($id, $name);
        $output = $this->Product->get_All_Products();
        if ($success) {
            $this->view_Admin("products/products", ["success" => "$name deleted succesfully...", "products" => $output]);
        } else {
            $this->view_Admin("products/products", ["error" => "Error deleting  $name ...", "products" => $output]);
        }
    }

    function publish_product($id, $product_name, $published)
    {
        $data = [];

        $data['published'] = $published;

        $this->Product->update_Product($id, $product_name, $data);

        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $this->redirect($referer);
    }



    function show_products_By_Category() {}
}
