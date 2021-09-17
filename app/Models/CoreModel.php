<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models
abstract class CoreModel {
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */ 
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */ 
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }

    /**
     * On déclare les méthodes abstraites : 
     * Il sera obligatoire de les créer dans les classes enfant
     */
    abstract static public function find(int $id);
    abstract static public function findAll();
    abstract public function insert();
    abstract public function update();
    abstract public function delete();

    /**
     * Allows to save the current model in the database
     * - update if already exists
     * - create if not already exists
     *
     * @return void
     */
    public function save()
    {
        // si l'instance a une propriété 'id
        if ($this->getId() > 0){
            // alors on le met a jour
            return $this->update();
        } else {
            // sinon on l'ajoute
            return $this->insert();
        }
    }
}
