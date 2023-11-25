<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class main {

    var $smarty;
    var $main;

    function __construct() {
        $db = DB::getInstance();
        $this->pdo = $db->pdo;
        session_start();
        $this->smarty = new Smarty();
        $this->zaloguj();
        $this->smarty->assign('main', $this->main);
        $this->smarty->display('index.tpl');
    }

    function routing() {
        //$smarty = new Smarty;
        if (isset($_POST["typ"]) && $_POST["typ"] == "klient") {
            $klient = new klient();
            $klient->addKlient($_POST["k_nazwa"], $_POST["k_ulica"], $_POST["k_miasto"], $_POST["k_nip"], $_POST["k_email"], $_POST["k_tel"], $_POST["k_opis"]);
        }

        if (isset($_POST["usun"]) && $_POST["usun"] == "usun") {
            $klient = new klient();
            $klient->deleteKlient($_POST["kid"]);
        }

        if (isset($_POST["typ_strona"]) && $_POST["typ_strona"] == "strona") {
            $strona = new strona();
            $strona->addStrona($_POST["w_kid"], $_POST["adres"], $_POST["ftp"], $_POST["loginftp"], $_POST["passftp"], $_POST["w_opis"]);
        }

        if (isset($_POST["typ_faktura"]) && $_POST["typ_faktura"] == "faktura") {
            //print_r($_POST);
            $faktura = new faktura();
            $us_fid = $faktura->addFaktura($_POST["f_kid"], $_POST["f_sprzedaz"], $_POST["f_platnosc"], $_POST["numer"], $_POST["zaplata"]);
            $usluga = new usluga();
            $usluga->addUslugi($us_fid, $_POST["us_nazwa"], $_POST["netto"]);
        }

        if (isset($_POST["usun_str"]) && $_POST["usun_str"] == "usun_str") {
            $strona = new strona();
            $strona->deleteStrona($_POST["wid"]);
        }

        if ($this->uri[1] == '?wyloguj') {
            session_destroy();
            header('Location: ./');
            exit();
        } else if ($this->uri[1] == '?klient' && isset($this->uri[2]) && intval($this->uri[2]) > 0) {
            $kid = intval($this->uri[2]);
            $klient2 = $this->pdo->prepare("SELECT * FROM klient WHERE kid= :kid");
            $klient2->bindParam(":kid", $kid);
            $klient2->execute();
            $c = $klient2->fetchAll();
            $this->smarty->assign('tablica_klient2', $c);
            $www2 = $this->pdo->prepare("SELECT * FROM www WHERE w_kid= :w_kid");
            $www2->bindParam(":w_kid", $kid);
            $www2->execute();
            $d = $www2->fetchAll();
            $this->smarty->assign('tablica_www2', $d);
            $this->main .= $this->smarty->fetch('klient.tpl');
        } else if ($this->uri[1] == '?strona' && isset($this->uri[2]) && intval($this->uri[2]) > 0) {
            $wid = intval($this->uri[2]);
            $www3 = $this->pdo->prepare("SELECT * FROM www WHERE wid= :wid");
            $www3->bindParam(":wid", $wid);
            $www3->execute();
            $k = $www3->fetchAll();
            $this->smarty->assign('tablica_www3', $k);
            $this->main .= $this->smarty->fetch('strona.tpl');
        } else if ($this->uri[1] == '?home' || $this->uri[1] == '' || $this->uri[1] == 'index.php') {
            $klient = new klient();
            $a = $klient->getKlient();
            $this->smarty->assign('tablica_klienci', $a);
            $this->main .= $this->smarty->fetch('k_dodaj.tpl');
            $this->main .= $this->smarty->fetch('k_wyswietl.tpl');
        } else if ($this->uri[1] == '?strony') {
            $strona = new strona();
            $e = $strona->getStrona();
            $klient = new klient();
            $h = $klient->getKlient();
            $this->smarty->assign('tablica_klienci_strony', $h);
            $this->smarty->assign('tablica_strony', $e);
            $this->main .= $this->smarty->fetch('s_wyswietl.tpl');
            $this->main .= $this->smarty->fetch('s_dodaj.tpl');
        } else if ($this->uri[1] == '?faktury') {
            $wystawiono = date("Y-m-d");
            $pocz = date("Y-m") . '-01';
            $przyszły = date("m") + 1;
            $kon = date("Y-") . '0' . $przyszły . '-01';
            $select_number = $this->pdo->prepare("SELECT COUNT(fid) FROM faktura WHERE f_sprzedaz >= :pocz AND f_sprzedaz < :kon");
            $select_number->bindParam(":pocz", $pocz);
            $select_number->bindParam(":kon", $kon);
            $select_number->execute();
//            print_r($select_number->errorInfo());
            $k = $select_number->fetchAll();
            $j = $k[0][0];
            $numer = ($j + 1) . '/' . date("n/y");
            $this->smarty->assign('numer', $numer);
            $this->smarty->assign('wystawiono', $wystawiono);
            $faktury = $this->pdo->prepare("SELECT * FROM faktura WHERE f_sprzedaz >= :pocz AND f_sprzedaz < :kon");
            $faktury->bindParam(":pocz", $pocz);
            $faktury->bindParam(":kon", $kon);
            $faktury->execute();
            $f = $faktury->fetchAll();
            $this->smarty->assign('tablica_faktury', $f);
            $klient = new klient();
            $l = $klient->getKlient();
            $this->smarty->assign('tablica_klienci_faktury', $l);
            $this->main .= $this->smarty->fetch('f_dodaj.tpl');
            $this->main .= $this->smarty->fetch('faktury.tpl');
        } else if ($this->uri[1] == '?dane') {
            if (isset($_POST['get_option'])) {
                $us_kid = $_POST['get_option'];
                $us_klient = $this->pdo->prepare("SELECT * FROM klient WHERE kid= :kid");
                $us_klient->bindParam(":kid", $us_kid);
                $us_klient->execute();
                $us = $us_klient->fetchAll();
                $this->smarty->assign('tablica_us_klient', $us);
                $this->smarty->display('dane_klienta.tpl');
                exit();
            }
        } else if ($this->uri[1] == '?faktura' && isset($this->uri[2]) && intval($this->uri[2]) > 0) {
            $fid = intval($this->uri[2]);
            $faktura = $this->pdo->prepare("SELECT * FROM faktura WHERE fid= :fid");
            $faktura->bindParam(":fid", $fid);
            $faktura->execute();
            $f = $faktura->fetchAll();
            foreach ($f as $wiersz) {
                $numer = $wiersz['numer'];
                $kid = $wiersz['f_kid'];
                $sprzedaz = date("d.m.Y", strtotime($wiersz['f_sprzedaz']));
                $platnosc = date("d.m.Y", strtotime($wiersz['f_platnosc']));
                $zaplata = iconv('utf-8', 'iso-8859-2', $wiersz['zaplata']);
            }
            $klient = $this->pdo->prepare("SELECT * FROM klient WHERE kid= :kid");
            $klient->bindParam(":kid", $kid);
            $klient->execute();
            $k = $klient->fetchAll();
            foreach ($k as $wiersz) {
                $nazwa = iconv('utf-8', 'iso-8859-2', $wiersz['k_nazwa']);
                $ulica = iconv('utf-8', 'iso-8859-2', $wiersz['k_ulica']);
                $miasto = iconv('utf-8', 'iso-8859-2', $wiersz['k_miasto']);
                $nip = $wiersz['k_nip'];
            }
            $usluga = $this->pdo->prepare("SELECT * FROM usluga WHERE us_fid= :fid");
            $usluga->bindParam(":fid", $fid);
            $usluga->execute();
            $u = $usluga->fetchAll();
            foreach ($u as $wiersz) {
                $us_nazwa = $wiersz['us_nazwa'];
                $netto = $wiersz['netto'];
                $brutto = $wiersz['brutto'];
                $vat = $wiersz['vat'];
            }
            $text = iconv('utf-8', 'iso-8859-2', 'Piekary Śląskie.');
            $sposob = iconv('utf-8', 'iso-8859-2', 'Sposób zapłaty:');
            $termin = iconv('utf-8', 'iso-8859-2', 'Termin płatności:');
            $firma = iconv('utf-8', 'iso-8859-2', 'Michał Żyrek ');
            $moja_ulica = iconv('utf-8', 'iso-8859-2', 'ul. M. C. Skłodowskiej 102/1/1');
            $moje_miasto = iconv('utf-8', 'iso-8859-2', '41-949 Piekary Śląskie');
            $uslugi = iconv('utf-8', 'iso-8859-2', 'Usługa');
            $upowazniona = iconv('utf-8', 'iso-8859-2', 'Osoba upoważniona');
            $zl = iconv('utf-8', 'iso-8859-2', ' zł');
            $zaplacono = iconv('utf-8', 'iso-8859-2', 'Zapłacono: ');
            $wartosc = iconv('utf-8','iso-8859-2','Wartość faktury: ');
            //$urzad = iconv('utf-8','iso-8859-2','Urząd Gminy Zabierzów ');
            $pdf = new FPDF();
            $pdf->AddPage();
            define('FPDF_FONTPATH', 'fpdf/font/');
            $pdf->AddFont('sanspl', '', 'sanspl.php');
            $pdf->SetFont('sanspl', '', 12);
            $pdf->Cell(120);
            $pdf->Cell(0, 0, $sprzedaz . ', ' . $text, 0, 1);
            $pdf->Image('logo.jpg', 10, 6, 30);
            $pdf->Cell(50);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(120, 20, 'Faktura VAT nr' . ' ' . $numer, 0, 1);
            $pdf->AddFont('sanspl', '', 'sanspl.php');
            $pdf->SetFont('sanspl', '', 12);
            $pdf->Cell(0, 7, 'Data dostawy:' . ' ' . $sprzedaz, 0, 1);
            $pdf->Cell(0, 7, $sposob . ' ' . $zaplata, 0, 1);
            $pdf->Cell(0, 7, $termin . ' ' . $platnosc, 0, 1);
            $pdf->SetFont('sanspl', '', 15);
            $pdf->Cell(120, 17, 'Nabywca');
            $pdf->Cell(0, 17, 'Sprzedawca', 0, 1);
            $pdf->SetFont('sanspl', '', 12);
            $pdf->Cell(120, 7, $nazwa);
            $pdf->Cell(0, 7, $firma . 'ZYREX', 0, 1);
            $pdf->Cell(120, 7, $ulica);
            $pdf->Cell(0, 7, $moja_ulica, 0, 1);
            $pdf->Cell(120, 7, $miasto);
            $pdf->Cell(0, 7, $moje_miasto, 0, 1);
            $pdf->Cell(120, 7, 'NIP: ' . $nip);
            $pdf->Cell(0, 7, 'NIP: 4980206409', 0, 1);
            
            //$pdf->SetFont('sanspl', '', 15);
            //$pdf->Cell(0, 17, 'Odbiorca', 0, 1);
            //$pdf->SetFont('sanspl', '', 12);
            //$pdf->Cell(0, 7, $urzad, 0,1);
            //$pdf->Cell(0, 7, $ulica, 0,1);
            //$pdf->Cell(0, 7, $miasto, 0, 1);
            
            $pdf->SetFont('sanspl', '', 15);
            $pdf->Cell(0, 17, 'Pozycje faktury', 0, 1);

            $pdf->SetFillColor(0, 0, 0);
            $pdf->SetTextColor(255);
            $pdf->SetDrawColor(255, 255, 255);
            $pdf->SetLineWidth(.3);
            $pdf->SetFont('sanspl', '', 11);

            $pdf->SetX(10);
            $pdf->Cell(80, 6, $uslugi, 1, 0, 'L', 1);
            $pdf->Cell(35, 6, 'Netto', 1, 0, 'C', 1);
            $pdf->Cell(35, 6, 'VAT (23 %)', 1, 0, 'C', 1);
            $pdf->Cell(35, 6, 'Brutto', 1, 0, 'C', 1);
            $pdf->Cell(0, 6, '', 0, 1);

            $pdf->SetTextColor(0);
            $pdf->SetDrawColor(255, 255, 255);
            $pdf->SetFillColor(245, 245, 245);
            $suma_netto = 0;
            $suma_vat = 0;
            $suma_brutto = 0;
            foreach ($u as $wiersz) {
                $pdf->SetX(10);
                $pdf->Cell(80, 6, iconv('utf-8', 'iso-8859-2', $wiersz['us_nazwa']), 1, 0, 'L', 1);
                $pdf->Cell(35, 6, $wiersz['netto'] . ' PLN', 1, 0, 'R', 1);
                $pdf->Cell(35, 6, $wiersz['vat'] . ' PLN', 1, 0, 'R', 1);
                $pdf->Cell(35, 6, $wiersz['brutto'] . ' PLN', 1, 0, 'R', 1);
                $pdf->Cell(0, 6, '', 0, 1);
                $suma_netto = $suma_netto + $wiersz['netto'];
                $suma_vat = $suma_vat + $wiersz['vat'];
                $suma_brutto = $suma_brutto + $wiersz['brutto'];
            }

            $pdf->SetTextColor(0);
            $pdf->SetDrawColor(255, 255, 255);
            $pdf->SetFillColor(202, 202, 202);
            $pdf->SetX(10);
            $pdf->Cell(80, 6, 'Razem', 1, 0, 'L', 1);
            $pdf->Cell(35, 6, $suma_netto . ' PLN', 1, 0, 'R', 1);
            $pdf->Cell(35, 6, $suma_vat . ' PLN', 1, 0, 'R', 1);
            $pdf->Cell(35, 6, $suma_brutto . ' PLN', 1, 0, 'R', 1);

            $pdf->SetFont('sanspl', '', 12);
            $pdf->Cell(0, 10, '', 0, 1);
            $pdf->Cell(0, 7, $wartosc . $suma_brutto . $zl, 0, 1);
            $pdf->Cell(0, 7, $zaplacono . '0' . $zl, 0, 1);
            $pdf->Cell(0, 7, 'Konto bankowe: ING Bank 74 1050 1621 1000 0092 0041 9274', 0, 1);
            $pdf->Cell(0, 30, '', 0, 1);
            $pdf->Cell(7);
            $pdf->Cell(0, 7, $upowazniona, 0, 1);
            $pdf->Cell(0, 7, 'do wystawienia faktury VAT', 0, 1);
            $pdf->SetFont('sanspl', '', 10);
            $pdf->Cell(16);
            $pdf->Cell(0, 7, $firma, 0, 1);

            $filename = 'faktura-' . $numer . '.pdf';
            //$pdf->Output($filename, 'I');
            $pdf->Output('faktury/' .$filename, 'F');
            
            $mail = new PHPMailer();    //utworzenie nowej klasy phpmailer
            $mail->From = "kontakt@zyrex.pl";    //Pełny adres e-mail
            $mail->FromName = "CRM Zyrex";    //imię i nazwisko lub nazwa użyta do wysyłania wiadomości
            $mail->Host = "zyrex.horisone.net"; //adres serwera pocztowego SMTP
            $mail->Mailer = "smtp";    //do wysłania zostanie użyty serwer SMTP
            $mail->SMTPAuth = true;    //włączenie autoryzacji do serwera SMTP
            $mail->Username = "kontakt@zyrex.pl";    //nazwa użytkownika do skrzynki e-mail
            $mail->Password = "TuRjjSNY3a";    //hasło użytkownika do skrzynki e-mail
            $mail->Port = 587; //port serwera SMTP 
            $mail->Subject = "Faktura VAT";    //Temat wiadomości, można stosować zmienne i znaczniki HTML
            $mail->Body = "Wystawiono fakturę VAT o numerze: ". $numer;    //Treść wiadomości, można stosować zmienne i znaczniki HTML
            $mail->CharSet = "UTF-8";
            $mail->SMTPSecure = 'tls';
            $mail->AddAddress ("kontakt@zyrex.pl","ZyrexPl"); 
            $mail->addAttachment('/faktura.pdf'); // Dodaje załącznik
        }
    }

    function zaloguj() {
        $smarty = new Smarty;
        if (!isset($_SESSION['zalogowany'])) {
            $smarty->display('login.tpl');
            if ((!isset($_POST['login'])) || (!isset($_POST['pass']))) {
                $smarty->display('login.tpl');
            } else {
                $login = $_POST['login'];
                $pass = $_POST['pass'];

                $uzytkownik = $this->pdo->prepare("SELECT * FROM users WHERE login=:login  AND pass=MD5(:pass)");
                $uzytkownik->bindParam(":login", $login);
                $uzytkownik->bindParam(":pass", $pass);
                $uzytkownik->execute();
                $rezultat = $uzytkownik->fetchAll();
                if (count($rezultat) > 0) {
                    $_SESSION['zalogowany'] = true;

                    $_SESSION['login'] = $rezultat[0]['login'];
                    header('Location: ./');
                } else {
                    $_SESSION['blad'] = 'Nieprawidłowe logowanie';
                }


                $uzytkownik->closeCursor();
            }
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

}
