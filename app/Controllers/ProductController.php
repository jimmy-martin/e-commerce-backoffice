<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends CoreController
{

    /**
     * List all products
     *
     * @return void
     */
    public function list()
    {
        $products = Product::findAll();

        $this->show('product/list', [
            'products' => $products
        ]);
    }

    /**
     * Add a product
     *
     * @return void
     */
    public function add()
    {
        $this->show('product/add');
    }

    /**
     * Add a product into the database
     *
     * @return void
     */
    public function create()
    {
        dump($_POST);

        $name = '';
        $description = '';
        $picture = '';
        $price = '';
        $rate = '';
        $status = '';
        $category = '';
        $brand = '';
        $type = '';

        $optionsIntValidate = ['options' => ['min_range' => 0]];

        // Validation des donnees
        if (
            isset($_POST) &&
            array_key_exists('name', $_POST) &&
            array_key_exists('description', $_POST) &&
            array_key_exists('picture', $_POST) &&
            array_key_exists('price', $_POST) &&
            array_key_exists('rate', $_POST) &&
            array_key_exists('status', $_POST) &&
            array_key_exists('category', $_POST) &&
            array_key_exists('brand', $_POST) &&
            array_key_exists('type', $_POST)
        ) {
            $name = filter_input(INPUT_POST, 'name');
            $description = filter_input(INPUT_POST, 'description');
            $picture = filter_input(INPUT_POST, 'picture');
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT, $optionsIntValidate);
            $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT, $optionsIntValidate);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT, $optionsIntValidate);
            $category = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT, $optionsIntValidate);
            $brand = filter_input(INPUT_POST, 'brand', FILTER_VALIDATE_INT, $optionsIntValidate);
            $type = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT, $optionsIntValidate);
        }

        $product = new Product();

        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setCategoryId($category);
        $product->setBrandId($brand);
        $product->setTypeId($type);

        $product->insert();
    }
}
