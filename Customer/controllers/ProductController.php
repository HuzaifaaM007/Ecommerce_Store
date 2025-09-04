<?php

namespace controllers\ProductController;

use core\controller\Controller;
use models\Category\Category;
use models\Product\Product;

class ProductController_Customer extends Controller
{
    private $Product;
    private $category;

    function __construct()
    {
        $this->Product = new Product();
        $this->category = new Category();
    }

    function show_All_Products()
    {
        $output = $this->Product->get_All_Products();


        $this->view_Customer("products/list", ["products" => $output]);
    }

    function show_Product_By_Id($id)
    {
        $output = $this->Product->get_Product_By_Id($id);
        if (!empty($output)) {
            $this->view_Customer("products/detail", ["products" => $output]);
            // print_r($output);    
        }
    }


}
