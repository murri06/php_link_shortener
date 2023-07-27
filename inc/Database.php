<?php

namespace Acme;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;
    private object $pdo;


    /**
     * @param $host
     * @param $dbName
     * @param $username
     * @param $password
     */
    public function __construct($host, $dbName, $username, $password)
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect(): void
    {
        try {
            // Establish the database connection using PDO
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);

            // Set PDO error mode to exception (optional but recommended)
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        $this->pdo = $pdo;
    }

    public function getAllData($tablename): array
    {
        $sql = "SELECT * FROM $tablename";
        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute();
        return $sth->fetchAll();
    }

}