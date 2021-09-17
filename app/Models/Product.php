<?php

namespace App\Models;

use App\Utils\Database;
use PDO;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Product extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     * 
     * @param int $productId ID du produit
     * @return Product
     */
    static public function find($productId)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        $sql = '
            SELECT *
            FROM product
            WHERE id = ' . $productId;

        // query ? exec ?
        // On fait de la LECTURE = une récupration => query()
        // si on avait fait une modification, suppression, ou un ajout => exec
        $pdoStatement = $pdo->query($sql);

        // fetchObject() pour récupérer un seul résultat
        // si j'en avais eu plusieurs => fetchAll
        $result = $pdoStatement->fetchObject('App\Models\Product');

        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     * 
     * @return Product[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');

        return $results;
    }

    /**
     * Récupérer les 5 produits mises en avant sur la home
     * 
     * @return Product[]
     */
    static public function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT * 
            FROM `product` 
            ORDER BY created_at DESC 
            LIMIT 5
        ';
        $pdoStatement = $pdo->query($sql);
        $products = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');

        return $products;
    }

    /**
     * Insert a product in database
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = "
            INSERT INTO `product` (
                name, 
                description, 
                picture, 
                price, 
                rate, 
                status, 
                category_id, 
                brand_id, 
                type_id)
            VALUES (
                :name, 
                :description, 
                :picture, 
                :price, 
                :rate, 
                :status, 
                :category_id, 
                :brand_id, 
                :type_id)
        ";

        $preparation = $pdo->prepare($sql);

        // On va ici procéder différemment de ce qu'on a fait dans le model category

        // Autre façon (cf Models/Category.php) de passer des données à nos paramètres nommés
        // on peut aussi passer par la méthode bindValue AVANT de faire appel à execute()
        // https://www.php.net/manual/fr/pdostatement.bindvalue
        $preparation->bindValue(':name', $this->name, PDO::PARAM_STR);
        $preparation->bindValue(':description', $this->description, PDO::PARAM_STR);
        $preparation->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $preparation->bindValue(':price', $this->price, PDO::PARAM_INT);
        $preparation->bindValue(':rate', $this->rate, PDO::PARAM_INT);
        $preparation->bindValue(':status', $this->status, PDO::PARAM_INT);
        $preparation->bindValue(':brand_id', $this->brand_id, PDO::PARAM_INT);
        $preparation->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
        $preparation->bindValue(':type_id', $this->type_id, PDO::PARAM_INT);
        // l'avantage de bindValue
        // c'est que l'on peut préciser le type de données attendu
        // PDO::PARAM_INT Représente le type de données INTEGER SQL
        // PDO::PARAM_STR Représente les types de données CHAR, VARCHAR ou les autres types de données sous forme de chaîne de caractères SQL
        // https://www.php.net/manual/fr/pdo.constants.php

        $preparation->execute();

        $insertedRows = $preparation->rowCount();

        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Update a product in database
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $sql = "
            UPDATE `product`
            SET `name` = :name,
                `description` = :description,
                `picture` = :picture,
                `price` = :price,
                `rate` = :rate,
                `status` = :status,
                `brand_id` = :brand_id,
                `category_id` = :category_id,
                `type_id` = :type_id,
                `updated_at` = NOW()
            WHERE `id` = :id
        ";

        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':name', $this->name, PDO::PARAM_STR);
        $preparation->bindValue(':description', $this->description, PDO::PARAM_STR);
        $preparation->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $preparation->bindValue(':price', $this->price, PDO::PARAM_INT);
        $preparation->bindValue(':rate', $this->rate, PDO::PARAM_INT);
        $preparation->bindValue(':status', $this->status, PDO::PARAM_INT);
        $preparation->bindValue(':brand_id', $this->brand_id, PDO::PARAM_INT);
        $preparation->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
        $preparation->bindValue(':type_id', $this->type_id, PDO::PARAM_INT);
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);

        $preparation->execute();

        $updatedRows = $preparation->rowCount();
      
        return ($updatedRows > 0);
    }

    /**
     * Delete a product in database
     * 
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = "DELETE FROM `product` WHERE `id` = :id";
        $preparation = $pdo->prepare($sql);
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);
        $preparation->execute();
        $deletedRows = $preparation->rowCount();
        return ($deletedRows > 0);
    }

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }
}
