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
        $this->checkAuthorization(['admin', 'catalog-manager', 'superadmin']);

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
        $this->checkAuthorization(['admin', 'catalog-manager', 'superadmin']);
        $this->show('category/add');
    }

    /**
     * Add a category into the database
     *
     * @return void
     */
    public function create()
    {
        $this->checkAuthorization(['admin', 'catalog-manager', 'superadmin']);
        // dump($_POST);

        // filter_input fait déja le test pour savoir si la variables existe bien, etc
        // donc pas besoin de verifier isset etc.
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING);

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

            $result = $category->save();

            if ($result) {
                header('Location: /category/list');
                exit;
            } else {
                echo 'Erreur lors de l\'ajout de cette nouvelle catégorie dans la base de données!';
            }
        } else {
            echo 'Certaines données sont manquantes ou incorrectes !';
            foreach ($errors as $value) {
                echo "<div>$value</div>";
            }
        }
    }

    /**
     * Displays form to edit a category
     *
     * @param $id category' id
     * @return void
     */
    public function update($id)
    {
        $this->checkAuthorization(['admin', 'catalog-manager', 'superadmin']);
        $category = Category::find($id);

        $this->show('category/update', [
            'category' => $category
        ]);
    }

    /**
     * Update a category into the database
     *
     * @param $id category' id
     * @return void
     */
    public function edit($id)
    {
        $this->checkAuthorization(['admin', 'catalog-manager', 'superadmin']);
        // dump($id);

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING);

        $errors = [];
        if (!$name) {
            $errors[] = 'Nom absent ou incorrect';
        }
        if (!$subtitle) {
            $errors[] = 'Sous-titre absent ou incorrect';
        }
        if (!$picture) {
            $errors[] = 'URL de l\'image absente ou incorrecte';
        }

        if (empty($errors)) {

            $category = Category::find($id);

            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);

            $result = $category->save();

            if ($result) {
                header('Location: /category/list');
                exit;
            } else {
                echo 'Erreur lors de la modification de la catégorie dans la base de données !';
            }
        } else {
            echo 'Certaines données sont manquantes ou incorrectes !';
            foreach ($errors as $value) {
                echo "<div>$value</div>";
            }
        }
    }

    /**
     * Delete a category into the database
     *
     * @param $id category' id
     * @return void
     */
    public function delete($id)
    {
        $this->checkAuthorization(['admin', 'catalog-manager', 'superadmin']);
        $category = Category::find($id);

        if($category){

            $result = $category->delete();
    
            if ($result) {
                header('Location: /category/list');
                exit;
            } else {
                echo 'Une erreur s\'est produite !';
            }
        } else {
            $this->show('error/err404');
        }
    }
}
