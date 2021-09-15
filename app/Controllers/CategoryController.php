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
     * Displays form to add a category
     *
     * @return void
     */
    public function add()
    {
        $this->show('category/add');
    }

    /**
     * Add a category into the database
     *
     * @return void
     */
    public function create()
    {
        // dump($_POST);

        $name = '';
        $subtitle = '';
        $picture = '';

        // Validation des donnees
        if (
            isset($_POST) &&
            array_key_exists('name', $_POST) &&
            array_key_exists('subtitle', $_POST) &&
            array_key_exists('picture', $_POST)
        ) {
            $name = filter_input(INPUT_POST, 'name');
            $subtitle = filter_input(INPUT_POST, 'subtitle');
            $picture = filter_input(INPUT_POST, 'picture');
        }

        $category = new Category();

        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);

        $result = $category->insert();

        if ($result) {
            header('Location: list');
        }

    }
}
