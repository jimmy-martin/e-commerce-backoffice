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
        $category = '';
        // Je vérifie si $_GET est vide et je l'inclue aux variables accessibles a ma vue si besoin sinon je ne les envoie pas
        if (isset($_GET) && array_key_exists('id', $_GET)) {
            $category = Category::find($_GET['id']);
        }

        $this->show('category/add', [
            'category' => $category
        ]);
    }

    /**
     * Add a category into the database
     *
     * @return void
     */
    public function create()
    {
        // dump($_POST);

        // filter_input fait déja le test pour savoir si la variables existe bien, etc
        // donc pas besoin de verifier isset etc.
        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');

        // on vérifie la validité des données reçues (gestion d'erreur)
        $errors = []; // tableau vide, pour le moment
        if (!$name) {
            $errors[] = 'Nom absent ou incorrect';
        }
        if (!$subtitle) {
            $errors[] = 'Sous-titre absent ou incorrect';
        }
        if (!$picture) {
            $errors[] = 'URL de l\'image absente ou incorrecte';
        }

        // je verifie si mon tableau est vide
        if (empty($errors)) {

            $category = new Category();

            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);

            $result = $category->insert();

            if ($result) {
                header('Location: list');
            }

        } else {
            echo 'Certaines données sont manquantes ou incorrectes !';
            foreach ($errors as $value) {
                echo "<div>$value</div>";
            }
        }
    }

    /**
     * Update a category into the database
     *
     * @param int $id category' id
     * @return void
     */
    public function update()
    {
        $id = '';
        $name = '';
        $subtitle = '';
        $picture = '';

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

        if (isset($_GET) && array_key_exists('id', $_GET)) {
            $id = (int)$_GET['id'];

            $category = Category::find($id);

            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);

            $result = $category->update();

            if ($result) {
                header('Location: list');
            }
        }
    }
}
