<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;

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
        $types = Type::findAll();
        $brands = Brand::findAll();
        $categories = Category::findAll();

        $this->show('product/add' , [
            'types' => $types,
            'brands' => $brands,
            'categories' => $categories
        ]);
    }

    /**
     * Add a product into the database
     *
     * @return void
     */
    public function create()
    {
        // dump($_POST);

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);

        $errors = [];
        if (!$name) {
            $errors[] = 'Nom absent ou incorrect';
        }
        if (!$description) {
            $errors[] = 'Description absente ou incorrecte';
        }
        if (!$picture) {
            $errors[] = 'URL de l\'image absente ou incorrecte';
        }
        if (!$price) {
            $errors[] = 'Prix absent ou incorrect';
        }
        if (!$rate) {
            $errors[] = 'Note absente ou incorrecte';
        }
        if ($status === false) {
            $errors[] = 'Statut absent ou incorrect';
        }
        if ($category_id === false) {
            $errors[] = 'Catégorie absente ou incorrecte';
        }
        if ($brand_id === false) {
            $errors[] = 'Marque absente ou incorrecte';
        }
        if ($type_id === false) {
            $errors[] = 'Type absent ou incorrect';
        }

        if (empty($errors)) {


            $product = new Product();

            $product->setName($name);
            $product->setDescription($description);
            $product->setPicture($picture);
            $product->setPrice($price);
            $product->setRate($rate);
            $product->setStatus($status);
            $product->setCategoryId($category_id);
            $product->setBrandId($brand_id);
            $product->setTypeId($type_id);

            $result = $product->save();

            if ($result) {
                header('Location: /product/list');
                exit;
            } else {
                echo 'Erreur lors de l\'ajout de ce nouveau produit dans la BDD !';
            }
        } else {

            // certaines données sont manquantes ou incorrectes
            echo 'Certaines données sont manquantes ou incorrectes !';
            foreach ($errors as $value) {
                echo "<div>$value</div>";
            }
        }
    }

    /**
     * Displays form to edit a product
     *
     * @param $id product' id
     * @return void
     */
    public function update($id)
    {
        $product = Product::find($id);

        $types = Type::findAll();
        $brands = Brand::findAll();
        $categories = Category::findAll();

        $productType = Type::find($product->getTypeId());
        $productBrand = Brand::find($product->getBrandId());
        $productCategory = Category::find($product->getCategoryId());
        

        $this->show('product/update', [
            'product' => $product,
            'types' => $types,
            'brands' => $brands,
            'categories' => $categories,
            'productType' => $productType,
            'productBrand' => $productBrand,
            'productCategory' => $productCategory
        ]);
    }

    /**
     * Add a product into the database
     *
     * @param $id product' id
     * @return void
     */
    public function edit($id)
    {
        // dump($_POST);

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);

        $errors = [];
        if (!$name) {
            $errors[] = 'Nom absent ou incorrect';
        }
        if (!$description) {
            $errors[] = 'Description absente ou incorrecte';
        }
        if (!$picture) {
            $errors[] = 'URL de l\'image absente ou incorrecte';
        }
        if (!$price) {
            $errors[] = 'Prix absent ou incorrect';
        }
        if (!$rate) {
            $errors[] = 'Note absente ou incorrecte';
        }
        if ($status === false) {
            $errors[] = 'Statut absent ou incorrect';
        }
        if ($category_id === false) {
            $errors[] = 'Catégorie absente ou incorrecte';
        }
        if ($brand_id === false) {
            $errors[] = 'Marque absente ou incorrecte';
        }
        if ($type_id === false) {
            $errors[] = 'Type absent ou incorrect';
        }

        if (empty($errors)) {


            $product = Product::find($id);

            $product->setName($name);
            $product->setDescription($description);
            $product->setPicture($picture);
            $product->setPrice($price);
            $product->setRate($rate);
            $product->setStatus($status);
            $product->setCategoryId($category_id);
            $product->setBrandId($brand_id);
            $product->setTypeId($type_id);

            $result = $product->save();

            if ($result) {
                header('Location: /product/list');
                exit;
            } else {
                echo 'Erreur lors de l\'ajout de ce nouveau produit dans la BDD !';
            }
        } else {

            // certaines données sont manquantes ou incorrectes
            echo 'Certaines données sont manquantes ou incorrectes !';
            foreach ($errors as $value) {
                echo "<div>$value</div>";
            }
        }
    }
}
