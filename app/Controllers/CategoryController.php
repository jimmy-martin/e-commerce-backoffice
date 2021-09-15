<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController
{
    /**
     * List all categories
     *
     * @return void
     */
    public function list()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->findAll();

        // dump($categories);

        $this->show('category/list', [
            'categories' => $categories
        ]);
    }
}