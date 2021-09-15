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
        $categories = Category::findAll();

        // dump($categories);

        $this->show('category/list', [
            'categories' => $categories
        ]);
    }

    /**
     * Add a category
     *
     * @return void
     */
    public function add()
    {
        $this->show('category/add');
    }
}