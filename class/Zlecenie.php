<?php

namespace Sklady;

/**
 * Description of Zlecenie
 *
 * @author zyrex
 */
class Zlecenie {
    var $pdo;

    function __construct() {
        $db = DB::getInstance();
        $this->pdo = $db->pdo;
    }

    function getZlecenia() {
        $statement = $this->pdo->prepare('SELECT * FROM zlecenie, wzor, firma WHERE z_wid = wid AND w_fid = fid ORDER BY zid DESC LIMIT 20');
        $statement->execute();
        $zlecenia = $statement->fetchAll();
        return $zlecenia;
    }
    function getZlecenie($zid) {
        $statement = $this->pdo->prepare('SELECT * FROM zlecenie, wzor, firma WHERE z_wid = wid AND w_fid = fid AND zid = :zid');
        $statement->bindParam(":zid", $zid);
        $statement->execute();
        $zlecenie = $statement->fetchAll();
        return $zlecenie;
    }
    function addWzor($fid, $imie, $nazwisko, $ulica, $kod, $miasto, $email, $polisa, $data) {
      $w_add = $this->pdo->prepare("INSERT INTO `wzor` (`wid`, `w_fid`, `w_imie`, `w_nazwisko`, `w_ulica`, `w_kod`, `w_miasto`, `w_email`, `w_polisa`, `w_data`) VALUES (NULL, :fid, :imie, :nazwisko, :ulica, :kod, :miasto, :email, :polisa, :data)");
      $w_add->bindParam(":fid", $fid);
      $w_add->bindParam(":imie", $imie);
      $w_add->bindParam(":nazwisko", $nazwisko);
      $w_add->bindParam(":ulica", $ulica);
      $w_add->bindParam(":kod", $kod);
      $w_add->bindParam(":miasto", $miasto);
      $w_add->bindParam(":email", $email);
      $w_add->bindParam(":polisa", $polisa);
      $w_add->bindParam(":data", $data);
      $w_add->execute();
      $last_id = $this->pdo->lastInsertId();
//      print_r ($last_id);
      return $last_id;
    }
    function addZlecenie($wid) {
      $platnosc = "oczekuje";
      $status = "w realizacji";
      $z_add = $this->pdo->prepare("INSERT INTO `zlecenie` (`zid`, `z_wid`, `z_platnosc`, `z_status`) VALUES (NULL, :wid, :platnosc, :status)");
      $z_add->bindParam(":wid", $wid);
      $z_add->bindParam(":platnosc", $platnosc);
      $z_add->bindParam(":status", $status);
      $z_add->execute();
    }
    function deleteZlecenie ($zid) {
        $z_delete = $this->pdo->prepare("DELETE FROM `zlecenie` WHERE zid= :zid");
        $z_delete->bindParam(":zid", $zid);
        $z_delete->execute();
    }
}
