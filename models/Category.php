<?php

namespace models\Category;

use core\DataBase\Database;
use core\Session\Session;
use traits\Logger\Logger;

class Category
{

    use Logger;

    private $session;
    private $db;
    private $categories = [
    [
        "name" => "Electronics",
        "description" => "Mobile phones, laptops, cameras, and other electronic devices"
    ],
    [
        "name" => "Clothing",
        "description" => "Men, women, and kids clothing including fashion accessories"
    ],
    [
        "name" => "Home & Kitchen",
        "description" => "Appliances, furniture, utensils, and home decor items"
    ],
    [
        "name" => "Books",
        "description" => "Fiction, non-fiction, educational, and professional books"
    ],
    [
        "name" => "Beauty & Personal Care",
        "description" => "Cosmetics, skincare, haircare, and grooming products"
    ],
    [
        "name" => "Sports & Outdoors",
        "description" => "Sports equipment, fitness gear, and outdoor essentials"
    ],
    [
        "name" => "Toys & Games",
        "description" => "Kids toys, board games, puzzles, and learning activities"
    ],
    [
        "name" => "Health & Wellness",
        "description" => "Medicines, supplements, fitness, and wellness products"
    ],
    [
        "name" => "Automotive",
        "description" => "Car accessories, bike parts, and vehicle essentials"
    ],
    [
        "name" => "Groceries",
        "description" => "Everyday food items, beverages, and household essentials"
    ]
];



    function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();

        foreach ($this->categories as $category) {

                $this->create_Category($category['name'],$category['description']);
            
        }
    }


    function create_Category($name, $description)
    {

        $output = $this->db->insert_Data(["name" => $name, "description" => $description], "categories",["name" => $name, "description" => $description], 3);
        if ($output) {
            $this->logmessage("Product Category Created : " . $name);
            return $output;
        } else {
            $this->logmessage("Error creating Category : " . $name);
            return $output;
        }
    }

    function get_All_Category()
    {
        $output = $this->db->getData([], "categories", [], 1);
        if (!empty($output)) {
            $this->logmessage("All Categories fetched ...");
            return $output;
        } else {
            $this->logmessage("No Categories found !!!");
            return [];
        }
    }

    function get_Category_By_Id($id)
    {
        $output = $this->db->getData([], "categories", ["id" => $id], 2);
        if (!empty($output)) {
            $this->logmessage("Category fetch by id: " . $id);
            return $output;
        } else {
            $this->logmessage("No Category for id: $id");
            return [];
        }
    }

    function update_Category($id, $name, $description)
    {

        $output = $this->db->update_Data("categories", ["name" => $name, "descrition" => $description], ['id' => $id]);
        if ($output) {
            $this->logmessage("Category id : $id is updated to : " . $name . " and " . $description . " ...");
            return $output;
        } else {
            $this->logmessage("Error updating Category $id !!!");
            return $output;
        }
    }

    function delete_Category(int $id, string $name) {
        $output = $this->db->remove_Data(['id'=>$id,'name'=>$name],"categories",3);

        if ($output) {
            $this->logmessage("Category : $id ---> $name deleted succesfully ...");
            return $output;
        }
        else{
            $this->logmessage("Error deleting Category : $id ---> $name !!!");
            return $output;
        }
    }
}
