<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 * 
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Type extends CoreModel {
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table
    
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $footer_order;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Type en fonction d'un id donné
     * 
     * @param int $typeId ID du type
     * @return Type
     */
    static public function find($typeId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `type` WHERE `id` =' . $typeId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $type = $pdoStatement->fetchObject('App\Models\Type');

        // retourner le résultat
        return $type;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table type
     * 
     * @return Type[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `type`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Type');
        
        return $results;
    }

    /**
     * Récupérer les 5 types mis en avant dans le footer
     * 
     * @return Type[]
     */
    static public function findAllFooter()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM type
            WHERE footer_order > 0
            ORDER BY footer_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $types = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Type');
        
        return $types;
    }

    /**
     * Insert a type in database
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "
            INSERT INTO `type` (name, footer_order)
            VALUES (:name, :footer_order)
        ";

        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':name', $this->name, PDO::PARAM_STR);
        $preparation->bindValue(':footer_order', $this->footer_order, PDO::PARAM_INT);

        $preparation->execute();

        $insertedRows = $preparation->rowCount();

        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Insert a type in database
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        
        $sql = "
            UPDATE `type`
            SET `name` = :name,
                `footer_order` = :footer_order,
                `updated_at` = NOW()
            WHERE `id` = :id
        ";

        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':name', $this->name, PDO::PARAM_STR);
        $preparation->bindValue(':footer_order', $this->footer_order, PDO::PARAM_INT);
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);

        $preparation->execute();

        $updatedRows = $preparation->rowCount();

        return ($updatedRows > 0);
    }

    /**
     * Delete a type in database
     * 
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = "DELETE FROM `type` WHERE `id` = :id";
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
     * Get the value of footer_order
     *
     * @return  int
     */ 
    public function getFooterOrder()
    {
        return $this->footer_order;
    }

    /**
     * Set the value of footer_order
     *
     * @param  int  $footer_order
     */ 
    public function setFooterOrder(int $footer_order)
    {
        $this->footer_order = $footer_order;
    }
}
