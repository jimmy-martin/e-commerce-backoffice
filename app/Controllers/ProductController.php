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
}
