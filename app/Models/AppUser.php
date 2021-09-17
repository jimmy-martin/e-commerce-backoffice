<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{
    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $role;
    private $status;

    /**
     * Find an user
     *
     * @param int $id user' id
     * @return AppUser
     */
    static public function find(int $userId)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT *
                FROM brand
                WHERE id = ' . $userId
        ;
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchObject(self::class);
    }

    /**
     * Return all app users
     * 
     * @return AppUser[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `brand`';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Add an user in database
     *
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = "
            INSERT INTO `app_user` (
                `email`, 
                `password`, 
                `firstname`, 
                `lastname`, 
                `role`, 
                `status`)
            VALUES (
                :email,
                :password,
                :firstname,
                :lastname,
                :role,
                :status
            )
        ";

        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':email', $this->email, PDO::PARAM_STR);
        $preparation->bindValue(':password', $this->password, PDO::PARAM_STR);
        $preparation->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $preparation->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $preparation->bindValue(':role', $this->role, PDO::PARAM_STR);
        $preparation->bindValue(':status', $this->status, PDO::PARAM_INT);

        $preparation->execute();

        $insertedRows = $preparation->rowCount();

        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Update an user in database
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $sql = "
            UPDATE `app_user`
            SET `email` = :email, 
                `password` = :password, 
                `firstname` = :firstname, 
                `lastname` = :lastname, 
                `role` = :role, 
                `status` = :status,
                `updated_at` = NOW()
            WHERE `id` = :id
        ";

        $preparation = $pdo->prepare($sql);

        $preparation->bindValue(':email', $this->email, PDO::PARAM_STR);
        $preparation->bindValue(':password', $this->password, PDO::PARAM_STR);
        $preparation->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $preparation->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $preparation->bindValue(':role', $this->role, PDO::PARAM_STR);
        $preparation->bindValue(':status', $this->status, PDO::PARAM_INT);

        $preparation->execute();

        $updatedRows = $preparation->rowCount();

        return ($updatedRows > 0);
    }

    /**
     * Delete an user in database
     * 
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = "DELETE FROM `app_user` WHERE `id` = :id";
        $preparation = $pdo->prepare($sql);
        $preparation->bindValue(':id', $this->id, PDO::PARAM_INT);
        $preparation->execute();
        $deletedRows = $preparation->rowCount();
        return ($deletedRows > 0);
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
