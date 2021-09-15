<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends CoreController
{

    /**
     * Liste des produits
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
}
