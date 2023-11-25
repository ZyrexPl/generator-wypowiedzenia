<?php
namespace Sklady;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db
 *
 * @author zyrex
 */
class db {

    //put your code here

    /*     * ****************************************************
     * connection.php
     * konfiguracja połączenia z bazą danych
     * **************************************************** */

    var $pdo;
    static $singleton = false;

    function __construct() {
        $this->pdo = $this->connection();
    }

    static function getInstance() {
        if (self::$singleton === false) {
            self::$singleton = new db();
        }
        return self::$singleton;
    }

    function connection() {
        // serwer
        $dbhost = "localhost";
        // admin
        //$dbuser = "zyrex_18";
        $dbuser = "zyrex_29";
        // hasło
        //$dbpass = "2SJLNhPWlylZmzaW";
        $dbpass = "tlJZD_EAce(rPb55";
        // nazwa baza
        //$dbname = "zyrex_18";
        $dbname = "zyrex_29";
        // nawiązujemy połączenie z serwerem MySQL
        $dsn = 'mysql:dbname=' . $dbname . ';host=' . $dbhost . ';charset=utf8';
        try {
            $pdo = new \PDO($dsn, $dbuser, $dbpass, array(\PDO::ATTR_PERSISTENT => false));
            $pdo->exec("set names utf8");
            return $pdo;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return $e;
        }
    }

}
