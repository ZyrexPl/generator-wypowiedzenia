<?php

namespace Sklady;

/**
 * Description of main
 *
 * @author zyrex
 */
class Main {

    var $smarty;
    var $main;
    var $serwis;

    function __construct() {
        $db = DB::getInstance();
        $this->pdo = $db->pdo;
        session_start();
        $this->smarty = new \Smarty();
        $this->parsowanie();
        if ($this->uri[1] == '') {
          $title = "Home";
          $this->smarty->assign('title', $title);
          $this->serwis .= $this->smarty->fetch('home.tpl');
          $this->stopka = $this->smarty->fetch('stopka.tpl');
          $this->smarty->assign('stopka', $this->stopka);
        } else if ($this->uri[1] == 'ubezpieczenia' || $this->uri[1] == 'telekomunikacja' || $this->uri[1] == 'fitness' || $this->uri[1] == 'energia') {
          $this->stopka = $this->smarty->fetch('stopka.tpl');
          $this->smarty->assign('stopka', $this->stopka);
          $this->parsowanie();
          $this->serwisWyp();
        } else if ($this->uri[1] == 'wzor') {
          $this->stopka = $this->smarty->fetch('stopka.tpl');
          $this->smarty->assign('stopka', $this->stopka);
          $this->parsowanie();
          $this->wzory();
        } else if ($this->uri[1] == 'dziekujemy') {
          $this->serwis .= $this->smarty->fetch('dziekujemy.tpl');
          $this->stopka = $this->smarty->fetch('stopka.tpl');
          $this->smarty->assign('stopka', $this->stopka);
        } else if ($this->uri[1] == 'dyrektor') {
//          $this->serwis .= $this->smarty->fetch('login.tpl');
          $this->zaloguj();
        } else if (preg_match('/^\?firmy_json/', $this->uri[1])) {
          if (isset($_POST['query'])) {
            $inpText = $_POST['query'];
            $statement = $this->pdo->prepare('SELECT * FROM firma, kategoria WHERE f_kid = kid AND f_nazwa LIKE "%":nazwa"%"');
            $statement->bindParam(":nazwa", $inpText);
            $statement->execute();
            $firmy = $statement->fetchAll();
            //return $firmy;
            if ($firmy) {
              header('Content-Type: application/json; charset=utf8');
              $out = '';
              foreach ($firmy as $row) {
                $out .= '<a href="/wzor/' . $row['f_url'] .'" class="list-group-item list-group-item-action border-1">' . $row['f_nazwa'] . '</a> ';
              }
              echo json_encode($out);
              exit();
            } else {
              header('Content-Type: application/json; charset=utf8');
              echo json_encode('<p class="list-group-item border-1">Brak firmy</p>');
              exit();
            }
          }
        }
//        $this->zaloguj();
        //$this->rejestruj();
        $this->smarty->assign('main', $this->main);
        $this->smarty->assign('serwis', $this->serwis);
        $this->smarty->display('index.tpl');
    }

    function routing() {
      if (isset($_POST["dodaj"]) && $_POST["dodaj"] == "firma") {
          $firma = new Firma();
          $firma->addFirma($_POST["nazwa"], $_POST["url"], $_POST["opis"], $_POST["kategoria"], $_POST["adres1"], $_POST["adres2"], $_POST["adres3"]);
      }
      if (isset($_POST["firma"]) && $_POST["firma"] == "delete") {
          $firma = new Firma();
          $firma->deleteFirma($_POST["fid"]);
      }
        if (isset($this->uri[2]) && $this->uri[2] == '?wyloguj') {
            session_destroy();
            header('Location: /');
            exit();
        } else if (!isset($this->uri[2]) || $this->uri[2] == '') {
            $title = "Home";
            $this->smarty->assign('title', $title);
            $name = $_SESSION['login'];
            $this->smarty->assign('name', $name);

            $this->main .= $this->smarty->fetch('panel.tpl');
        } else if (!isset($this->uri[2]) || $this->uri[2] == '?firmy') {
            $title = "Firmy";
            $this->smarty->assign('title', $title);
            $firmy = new Firma();
            $f = $firmy->getTenFirmy();
            $this->smarty->assign('firmy', $f);

            $this->main .= $this->smarty->fetch('panel-firmy.tpl');
        } else if (!isset($this->uri[2]) || $this->uri[2] == '?zamowienia') {
            $title = "Zamówienia";
            $this->smarty->assign('title', $title);
            $zamowienia = new Zlecenie();
            $z = $zamowienia->getZlecenia();
            $this->smarty->assign('zamowienia', $z);

            $this->main .= $this->smarty->fetch('panel-zamowienia.tpl');
        } else if (!isset($this->uri[2]) || $this->uri[2] == '?statystyki') {
            $title = "Firmy";
            $this->smarty->assign('title', $title);

            $this->main .= $this->smarty->fetch('panel-statystyki.tpl');
        } else if ($this->uri[2] == '?wypowiedzenie' && isset($this->uri[3]) && intval($this->uri[3]) > 0) {
          $title = "Wypowiedzenie";
          $zid = $this->uri[3];
          $pdf = new Dokumenty();
          $pdf->generujPDF($zid);
        }
    }

    function serwisWyp() {
        if ($this->uri[1] == '') {
          $title = "Home";
          $this->smarty->assign('title', $title);
          $this->serwis .= $this->smarty->fetch('home.tpl');
        } else {
            $nazwaKat = $this->uri[1];
            $title = "Kategoria " . $nazwaKat;
            $this->smarty->assign('title', $title);
            $firmy = new Firma();
            $f = $firmy->getFirmy($nazwaKat);
            $this->smarty->assign('firmy', $f);

            $this->serwis .= $this->smarty->fetch('kategoria.tpl');
        }
    }

    function wzory() {
      if (isset($_POST["zamowienie"]) && $_POST["zamowienie"] == "dodaj") {
        $wzor = new Zlecenie();
        $w = $wzor->addWzor($_POST["fid"], $_POST["imie"], $_POST["nazwisko"], $_POST["ulica"], $_POST["kod"], $_POST["miasto"], $_POST["email"], $_POST["polisa"], $_POST["data"]);
        $wid = $w;
//        print_r ($wid);
        $zlecenie = new Zlecenie();
        $zlecenie->addZlecenie($wid);
      }
      if (isset($this->uri[2])) {
        $title = "Wygeneruj dokument";
        $this->smarty->assign('title', $title);
        $nazwaFirmy = $this->uri[2];
        $this->smarty->assign('firma', $nazwaFirmy);
        $firma = new Firma();
        $f = $firma->getFirma($nazwaFirmy);
        $this->smarty->assign('firmadane', $f);

        $this->serwis .= $this->smarty->fetch('wzor.tpl');
      }
    }

    function zaloguj() {
        if (!isset($_SESSION['zalogowany'])) {
            if (isset($_POST["zaloguj"]) && $_POST["zaloguj"] == "zaloguj") {
                if (!isset($_POST['login']) || $_POST['login'] == '' || !isset($_POST['pass']) || $_POST['pass'] == '') {
                    $this->smarty->assign('blad', 'Brakuje loginu lub hasła');
                } else {
                    $login = $_POST['login'];
                    $pass = $_POST['pass'];
                    $salt = $this->hashed($login);
                    $crypted = crypt($pass, '$6$rounds=50000$' . $salt);
                    //print_r($crypted);
                    $user = $this->pdo->prepare("SELECT * FROM uzytkownik WHERE u_login=:login  AND u_haslo=:pass");
                    $user->bindParam(":login", $login);
                    $user->bindParam(":pass", $crypted);
                    $user->execute();
                    $rezultat = $user->fetchAll();
                    //print_r($rezultat);
                    if (count($rezultat) > 0) {
                        $_SESSION['zalogowany'] = true;
                        $_SESSION['id'] = $rezultat[0]['uid'];
                        $_SESSION['login'] = $rezultat[0]['u_login'];
                            header('Location: /dyrektor');
                            exit();

                    } else {
                        $this->smarty->assign('blad', 'Nieprawidłowe logowanie');
                    }
                    $user->closeCursor();
                }
            }

            $this->serwis .= $this->smarty->fetch('login.tpl');
//              $this->serwisWyp();
        } else {

            $this->menu = $this->smarty->fetch('menu.tpl');
            $this->smarty->assign('menu', $this->menu);
            $this->parsowanie();
            $this->routing();
        }
    }

    function parsowanie() {
        $this->uri = explode("/", $_SERVER['REQUEST_URI']);
    }

    function hashed($login) {
        $db_hash = $this->pdo->prepare("SELECT u_haslo FROM uzytkownik WHERE u_login = :name");
        $db_hash->bindParam(":name", $login);
        $db_hash->execute();
        $hashed_pass = $db_hash->fetchAll();
        $hash = $hashed_pass[0]['u_haslo'];
        //print_r($hash);
        return explode("$", $hash)[3];
//        $salt = substr($hash, 17, 16);
//        return $salt;
    }

}
