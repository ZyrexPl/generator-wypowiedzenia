<?php

namespace Sklady;

/**
 * Description of Firma
 *
 * @author zyrex
 */
class Firma {
    var $pdo;

    function __construct() {
        $db = DB::getInstance();
        $this->pdo = $db->pdo;
    }

    function getFirmy($nazwa) {
        $statement = $this->pdo->prepare('SELECT * FROM firma, kategoria WHERE f_kid = kid AND k_nazwa = :nazwa');
        $statement->bindParam(":nazwa", $nazwa);
        $statement->execute();
        $firmy = $statement->fetchAll();
        return $firmy;
    }
    function getTenFirmy() {
        $statement = $this->pdo->prepare('SELECT * FROM firma, kategoria WHERE f_kid = kid ORDER BY fid DESC LIMIT 10');
        $statement->execute();
        $firmy = $statement->fetchAll();
        return $firmy;
    }
    function getFirma($nazwa) {
        $statement = $this->pdo->prepare('SELECT * FROM firma, kategoria WHERE f_kid = kid AND f_url = :nazwa');
        $statement->bindParam(":nazwa", $nazwa);
        $statement->execute();
        $firma = $statement->fetchAll();
        return $firma;
    }
    function addFirma($nazwa, $url, $opis, $kid, $adres1, $adres2, $adres3) {
      $f_add = $this->pdo->prepare("INSERT INTO `firma` (`fid`, `f_nazwa`, `f_url`, `f_opis`, `f_kid`, `f_adres1`, `f_adres2`, `f_adres3`) VALUES (NULL, :nazwa, :url, :opis, :kid, :adres1, :adres2, :adres3)");
      $f_add->bindParam(":nazwa", $nazwa);
      $f_add->bindParam(":url", $url);
      $f_add->bindParam(":opis", $opis);
      $f_add->bindParam(":kid", $kid);
      $f_add->bindParam(":adres1", $adres1);
      $f_add->bindParam(":adres2", $adres2);
      $f_add->bindParam(":adres3", $adres3);
      $f_add->execute();
    }
    function deleteFirma ($fid) {
        $f_delete = $this->pdo->prepare("DELETE FROM `firma` WHERE fid= :fid");
        $f_delete->bindParam(":fid", $fid);
        $f_delete->execute();
    }
}
