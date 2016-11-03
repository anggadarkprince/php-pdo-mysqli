<?php

/**
 * Created by PhpStorm.
 * User: angga
 * Date: 03/11/16
 * Time: 10:28
 */
class Database
{
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=sandbox', 'root', 'anggaari');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $this->connection;
    }

    public function disconnect()
    {
        $this->connection = null;
    }
}