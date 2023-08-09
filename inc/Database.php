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
        $sql = "SELECT * FROM $tablename ORDER BY id ";
        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getLinkValidation($short): array
    {
        $sql = "SELECT shortLink FROM links WHERE shortLink = '$short'";
        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function insertLinkData($short, $long, $userId): bool
    {
        $sql = "INSERT INTO links(shortLink, longLink, userId, clicks) VALUES('$short' , '$long', '$userId', '0')";
        if ($this->pdo->query($sql))
            return true;
        else return false;
    }

    public function getLongLink($short)
    {
        $sql = "SELECT longLink FROM links WHERE shortLink = '$short'";
        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute();
        return $sth->fetch();
    }

    public function deleteQuery($tablename, $id): bool
    {
        $sql = "DELETE FROM $tablename WHERE id = '$id'";
        if ($this->pdo->query($sql))
            return true;
        else return false;
    }

    public function updateClicks($short): void
    {
        $sql = "UPDATE links SET clicks = clicks + 1 WHERE shortLink = '$short'";
        $this->pdo->query($sql);
    }

    public function userValidation($login)
    {
        $sql = "SELECT username, password FROM users WHERE username = '$login' LIMIT 1";
        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function createUser($login, $password): bool
    {
        $sql = "INSERT INTO users(username, password) VALUES('$login' , '$password')";
        if ($this->pdo->query($sql))
            return true;
        else return false;
    }
}