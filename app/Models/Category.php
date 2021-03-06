<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

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
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     * 
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    static public function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     * 
     * @return Category[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     * 
     * @return Category[]
     */
    static public function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $categories;
    }

    /**
     * Insert a category in database
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        // on ecrit notre requete en utilisant des parametres nommés
        $sql = "
            INSERT INTO `category` (name, subtitle, picture)
            VALUES (:name, :subtitle, :picture)
        ";

        // ensuite on prepare la requete
        $preparation = $pdo->prepare($sql);

        // on doit utiliser maintenant la methode execute() de PDO
        $preparation->execute([
            ':name' => $this->name,
            ':subtitle' => $this->subtitle,
            ':picture' => $this->picture
        ]);

        // contrairement a exec(), execute() ne retourne pas le nombre de lignes modifiees, on doit donc passer par la methode rowCount()
        $insertedRows = $preparation->rowCount();

        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Update a category in database
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $sql = "
            UPDATE `category`
            SET `name` = :name,
                `subtitle` = :subtitle,
                `picture` = :picture,
                `updated_at` = NOW()
            WHERE `id` = :id
        ";

        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':name', $this->name, PDO::PARAM_STR);
        $preparation->bindValue(':subtitle', $this->subtitle, PDO::PARAM_STR);
        $preparation->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);

        $preparation->execute();

        $updatedRows = $preparation->rowCount();

        return ($updatedRows > 0);
    }

    /**
     * Update a category in database
     * 
     * @return bool
     */
    public function updateHomeOrder()
    {
        $pdo = Database::getPDO();
        $sql = "
            UPDATE `category`
            SET `home_order` = 0,
                `updated_at` = NOW()
            WHERE `home_order` = :home_order;

            UPDATE `category`
            SET `home_order` = :home_order,
                `updated_at` = NOW()
            WHERE `id` = :id
        ";

        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':home_order', $this->home_order, PDO::PARAM_INT);
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);

        $preparation->execute();

        $updatedRows = $preparation->rowCount();

        return ($updatedRows > 0);
    }

    /**
     * Méthode permettant de mettre 5 catégories à la une
     *
     * @param array $idList
     * @return bool
     */
    static public function defineHomepage(array $emplacements)
    {

        // Connexion à la BDD
        $pdo = Database::getPDO();


        // Notre variable $sql contient 6 requêtes de type UPDATE
        // oui c'est possible, on peut faire plusieurs requêtes en une seule fois en les séparant par des point-virgules «;»
        // Et - contrairement à toutes les requêtes codées jusqu'à maintenant en S06 - nous n'utiliserons pas de paramètres nommés
        // mais une autre possibilité de faire des requêtes préparées : des marqueurs (identifiés par des points d'interrogation `?`)
        // https://www.php.net/manual/fr/pdo.prepare.php
        $sql = '
            UPDATE `category` set home_order = 0;
            UPDATE `category` set home_order = 1 WHERE `id` = ?;
            UPDATE `category` set home_order = 2 WHERE `id` = ?;
            UPDATE `category` set home_order = 3 WHERE `id` = ?;
            UPDATE `category` set home_order = 4 WHERE `id` = ?;
            UPDATE `category` set home_order = 5 WHERE `id` = ?;
        ';

        // La première requête met les champs home_order de chaque catégorie à 0
        // Puis, chaque catégorie concernée recevra son positionnement home_order

        $pdoStatement = $pdo->prepare($sql);

        return $pdoStatement->execute($emplacements);

    }

    /**
     * Delete a category in database
     * 
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = "DELETE FROM `category` WHERE `id` = :id";

        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);

        $preparation->execute();

        $deletedRows = $preparation->rowCount();

        return ($deletedRows > 0);
    }
}
