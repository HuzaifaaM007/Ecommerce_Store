<?php

namespace models\Product;

use core\DataBase\Database;
use core\Session\Session;
use models\Category\Category;
use traits\Logger\Logger;

class Product
{

    use Logger;

    private $db;
    private $session;
    private $category;
    private $products =  [
        [   
            "id"=>1,
            "name" => "Laptop",
            "description" => "15.6 inch laptop with Intel i7 processor, 16GB RAM, 512GB SSD.",
            "price" => 850.00,
            "stock" => 10,
            "category_id" => 1,
            "image" => "uploads/products/laptop.jpeg",
            "published" => 1
        ],
        [
            "id"=>2,
            "name" => "Mobile",
            "description" => "6.5 inch smartphone with 128GB storage, 8GB RAM, 5000mAh battery.",
            "price" => 499.00,
            "stock" => 25,
            "category_id" => 1,
            "image" => "uploads/products/mobile.jpeg",
            "published" => 1
        ],
        [
            "id"=>3,
            "name" => "Tripod",
            "description" => "Adjustable aluminum tripod stand with 360° rotation.",
            "price" => 45.00,
            "stock" => 15,
            "category_id" => 1,
            "image" => "uploads/products/tripod.jpeg",
            "published" => 1
        ],
        [
            "id"=>4,
            "name" => "Camera",
            "description" => "DSLR Camera with 24MP lens and 4K video recording.",
            "price" => 1200.00,
            "stock" => 8,
            "category_id" => 1,
            "image" => "uploads/products/camera.jpeg",
            "published" => 1
        ],
        [
            "id"=>5,
            "name" => "Mouse",
            "description" => "Wireless optical mouse with ergonomic design.",
            "price" => 25.00,
            "stock" => 50,
            "category_id" => 1,
            "image" => "uploads/products/mouse.jpeg",
            "published" => 1
        ],
        [
            "id"=>6,
            "name" => "Joystick",
            "description" => "USB gaming joystick with vibration feedback.",
            "price" => 40.00,
            "stock" => 20,
            "category_id" => 1,
            "image" => "uploads/products/joystick.jpeg",
            "published" => 1
        ],
        [
            "id"=>7,
            "name" => "LCD",
            "description" => "24 inch Full HD LCD monitor with HDMI and VGA support.",
            "price" => 180.00,
            "stock" => 12,
            "category_id" => 1,
            "image" => "uploads/products/lcd.jpeg",
            "published" => 1
        ]
    ];


    function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
        $this->category = new Category();

        foreach ($this->products as $product) {
            $this->create_Product_initial($product);
        }
    }

    function get_All_Products()
    {
        $output = $this->db->getData([], "products", [], 1);

        if (!empty($output)) {
            $this->logmessage("All Products fetched ...");
            return $output;
        } else {
            $this->logmessage("No products in Store !!!");
            return [];
        }
    }

    function get_Product_By_Id($id)
    {
        $output = $this->db->getData([], "products", ["id" => $id], 2);
        if (!empty($output)) {
            $this->logmessage("Product fetch by id: " . $id);
            return $output;
        } else {
            $this->logmessage("No product for id: $id");
            return [];
        }
    }

    function create_Product_initial(array $data)
    {
        $output = $this->db->insert_Data($data, "products", ["id"=>$data['id']], 2);
        if ($output) {
            $this->logmessage("Initial Product Created : " . $data['name']);
            return $output;
        } else {
            $this->logmessage("Error creating Initial Product : " . $data['name']);
            return $output;
        }
    }

    function create_Product(array $data)
    {
        $output = $this->db->insert_Data($data, "products", [], 1);
        if ($output) {
            $this->logmessage("Product Created : " . $data['name']);
            return $output;
        } else {
            $this->logmessage("Error creating Product : " . $data['name']);
            return $output;
        }
    }

    function update_Product($id = 0, string $name = 'null', array $data)
    {
        // echo "id..." . $id;
        $output = $this->db->update_Data("products", $data, ['id' => $id, 'name' => $name]);
        if ($output) {
            $this->logmessage("Product $name with id : $id is updated to : " . print_r($data, true) . " ...");
            return $output;
        } else {
            $this->logmessage("Error updating Product $id ---> $name");
            return $output;
        }
    }

    function delete_Product($id = 0, $name = 'null')
    {
        $output = $this->db->remove_Data(['id' => $id, 'name' => $name], "products", 3);

        if ($output) {
            $this->logmessage("Product : $id ---> $name deleted succesfully ...");
            return $output;
        } else {
            $this->logmessage("Error deleting Product : $id ---> $name !!!");
            return $output;
        }
    }
}
