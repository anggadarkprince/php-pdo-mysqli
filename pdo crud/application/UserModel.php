<?php

require_once 'Database.php';
require_once 'User.php';

/**
 * Created by PhpStorm.
 * User: angga
 * Date: 03/11/16
 * Time: 10:28
 */
class UserModel
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * Insert a user into database.
     * @param User $user
     * @return bool
     */
    public function insert(User $user)
    {
        $db = $this->database->connect();
        $statement = $db->prepare("
            INSERT 
            INTO users(first_name, last_name, username, password)
            VALUES(:first_name, :last_name, :username, :password)
        ");
        $statement->bindParam(':first_name', $user->getFirstName());
        $statement->bindParam(':last_name', $user->getLastName());
        $statement->bindParam(':username', $user->getUsername());
        $statement->bindValue(':password', md5($user->getPassword()));
        $statement->execute();
        if ($statement->rowCount()) {
            return true;
        }
        return false;
    }

    /**
     * Select user data by 10 data and filtered by query string.
     * @param int $page
     * @param string $order
     * @param string $method
     * @param string $search_query
     * @return array
     */
    public function selectAll($page = 1, $order = 'id', $method = 'desc', $search_query = '')
    {
        $db = $this->database->connect();
        $statement = $db->prepare("
            SELECT * 
            FROM users 
            WHERE first_name LIKE :query
              OR last_name LIKE  :query
              OR username LIKE  :query
            ORDER BY $order $method
            LIMIT :page, 10");

        $statement->bindValue(':query', '%' . $search_query . '%', PDO::PARAM_STR);
        $statement->bindValue(':page', ($page - 1) * 10, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Return total data value
     * @param int $page
     * @param string $order
     * @param string $method
     * @param string $search_query
     * @return int
     */
    public function countData($page = 1, $order = 'id', $method = 'desc', $search_query = '')
    {
        $db = $this->database->connect();
        $statement = $db->prepare("
            SELECT * 
            FROM users 
            WHERE first_name LIKE :query
              OR last_name LIKE  :query
              OR username LIKE  :query
            ORDER BY $order $method
        ");

        $statement->bindValue(':query', '%' . $search_query . '%', PDO::PARAM_STR);
        $statement->bindValue(':page', ($page - 1) * 10, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }

    /**
     * Fetch a user by ID
     * @param $id
     * @return User
     */
    public function selectById($id)
    {
        $db = $this->database->connect();
        $statement = $db->prepare("SELECT * FROM users WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return new User(
            $result['first_name'],
            $result['last_name'],
            $result['username'],
            $result['password']
        );
    }

    /**
     * Update a user data
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        $db = $this->database->connect();
        $password = '';
        if ($user->getPassword() != '') {
            $password = ', password = :password';
        }

        $statement = $db->prepare("
            UPDATE users 
            SET 
              first_name = :first_name, 
              last_name = :last_name,
              username = :username
              $password
            WHERE id = :id
        ");
        $statement->bindParam(':first_name', $user->getFirstName());
        $statement->bindParam(':last_name', $user->getLastName());
        $statement->bindParam(':username', $user->getUsername());
        if ($user->getPassword() != '') {
            $statement->bindValue(':password', md5($user->getPassword()));
        }
        $statement->bindParam(':id', $user->getId(), PDO::PARAM_INT);
        echo $statement->queryString;
        $statement->execute();
        if ($statement->rowCount()) {
            return true;
        }
        return false;
    }

    /**
     * Delete data from database
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        $db = $this->database->connect();
        $statement = $db->prepare("DELETE FROM users WHERE id = :id");
        $statement->bindParam(':id', $user->getId());
        $statement->execute();
        if ($statement->rowCount()) {
            return true;
        }
        return false;
    }
}