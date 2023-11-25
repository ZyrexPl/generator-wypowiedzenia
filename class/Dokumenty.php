<?php

namespace Sklady;

/**
 * Description of Dokumenty
 *
 * @author zyrek
 */
class Dokumenty {

    var $pdo;

    function __construct() {
        $db = DB::getInstance();
        $this->pdo = $db->pdo;
    }

    function generujPDF($zid) {
        $daneWypowiedzenia = new Zlecenie();
        $dane = $daneWypowiedzenia->getZlecenie($zid);
        $data = date("d.m.Y");
        $imie = iconv('utf-8', 'iso-8859-2', $dane[0]['w_imie']);
        $nazwisko = iconv('utf-8', 'iso-8859-2', $dane[0]['w_nazwisko']);
        $miasto = iconv('utf-8', 'iso-8859-2', $dane[0]['w_miasto']);
        $ulica = iconv('utf-8', 'iso-8859-2', $dane[0]['w_ulica']);
        $kod = $dane[0]['w_kod'];
        $email = $dane[0]['w_email'];
        $dataWyp = date("d.m.Y", strtotime($dane[0]['w_data']));
        $ubezpieczenie = iconv('utf-8', 'iso-8859-2', 'Oświadczam, że wypowiadam umowę ubezpieczenia  z dniem ');
        $potwierdzenie = iconv('utf-8', 'iso-8859-2', 'Proszę o przesłanie potwierdzenia wypowiedzenia ww. umowy.');
        $polisa = iconv('utf-8', 'iso-8859-2', $dane[0]['w_polisa']);
        $adres1 = iconv('utf-8', 'iso-8859-2', $dane[0]['f_adres1']);
        $adres2 = iconv('utf-8', 'iso-8859-2', $dane[0]['f_adres2']);
        $adres3 = iconv('utf-8', 'iso-8859-2', $dane[0]['f_adres3']);

        $pdf = new FPDF();
        $pdf->AddPage();
        define('FPDF_FONTPATH', '/fpdf/font/');
        $pdf->AddFont('sanspl', '', 'sanspl.php');
        $pdf->SetFont('sanspl', '', 12);
        $pdf->Cell(190, 7, $miasto . ' ' . $data, 0, 1, 'R');
        $pdf->Cell(130, 7, $imie . ' ' . $nazwisko, 0, 1);
        $pdf->Cell(130, 7, $ulica, 0, 1);
        $pdf->Cell(130, 7, $kod . ' ' . $miasto, 0, 1);
        $pdf->Cell(0, 10, '', 0, 1);
        $pdf->Cell(190, 7, $adres1, 0, 1, 'R');
        $pdf->Cell(190, 7, $adres2, 0, 1, 'R');
        $pdf->Cell(190, 7, $adres3, 0, 1, 'R');
        $pdf->Cell(0, 10, '', 0, 1);
        $pdf->SetFont('sanspl', '', 15);
        $pdf->Cell(190, 20, 'Wypowiedzenie umowy', 0, 1, 'C');
        $pdf->SetFont('sanspl', '', 12);
        $pdf->Cell(0, 7, $ubezpieczenie . $dataWyp . 'r.', 0, 1);
        $pdf->Cell(0, 10, '', 0, 1);
        $pdf->Cell(0, 7, 'Polisa: ' . $polisa, 0, 1);
        $pdf->Cell(130, 7, $imie . ' ' . $nazwisko, 0, 1);
        $pdf->Cell(130, 7, $ulica, 0, 1);
        $pdf->Cell(130, 7, $kod . ' ' . $miasto, 0, 1);
        $pdf->Cell(130, 7, 'email: ' . $email, 0, 1);
        $pdf->Cell(0, 10, '', 0, 1);
        $pdf->Cell(0, 7, $potwierdzenie, 0, 1);
        $pdf->Cell(0, 40, '', 0, 1);
        $pdf->Cell(170, 7, '...........................', 0, 1, 'R');
        $pdf->Cell(160, 7, 'Podpis', 0, 1, 'R');

        //$faktura = 'Faktura';
        $pdf->Output('Wypowiedzenie' . $zid . '.pdf','I');
    }

}
