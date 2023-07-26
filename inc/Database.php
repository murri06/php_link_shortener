<?php

namespace Acme;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $dbName;
    private $username;
    private $password;
    private $pdo;


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

            // Now you have a connection ($pdo) that you can use to perform queries
            // For example:
            // $query = "SELECT * FROM your_table_name";
            // $result = $pdo->query($query);
            // while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            //     // Do something with the row data
            // }

            echo "Connected to the database successfully!";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        $this->pdo = $pdo;
    }

    public function getAllData($tablename): array
    {

        $sql = "SELECT * FROM :tablename";
        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute(['tablename' => $tablename]);

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

}