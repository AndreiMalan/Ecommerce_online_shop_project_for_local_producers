<?php
require_once "ShoppingCart.php";
require("fpdf/fpdf.php");
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index-user.html');
    exit;
}

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(80);
        $this->Cell(50, 10, "Comanda " . $_SESSION['id_user'], 1, 0, 'C');
        $this->Ln();
        $this->Cell(50, 10, " Firma:  " . "Naturino", 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' .
        $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function __construct()
    {
        parent::__construct();
    }
}

function generatePDF() {
    $member_id = $_SESSION['id_user'];
    $cart = new ShoppingCart();
    $cartItems = $cart->getMemberCartItem($member_id);
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times', 'B', 20);
    $pdf->Ln();
    $pdf->SetFont('Times', '', 14);
    $pdf->Ln();
    $total = 0;
    $pdf->SetFont('Times', 'B', 20);
    $pdf->Cell(0, 20, "                                    Produsele cumparate");
    $pdf->SetFont('Times', '', 15);
    $pdf->Ln();
    foreach ($cartItems as $products) {
        $nume = $products["nume_produs"];
        $id = $products["id_produs"];
        $cantitate = $products["cantitate"];
        $pret = $products["pret"];
        $raspuns = $products["raspuns"];
        if ($raspuns == "Refuzat") {
            continue; 
        }
        $pdf->Image("imagini/" . "$id" . ".jpg", $pdf->getX(), $pdf->getY() + 5, 20, 20);
        $pdf->Cell(0, 20, "                      Denumire: $nume " . " ||  Nr bucati: $cantitate" . "  ||  Pret: $pret RON", 0, 2);
        $total += ($pret * $cantitate);
    }
    $pdf->SetFont('Times', 'B', 20);
    $pdf->Ln();
    $pdf->Cell(0, 10, "                                 -----------------------------------------------------------------");
    $pdf->Ln();
    $pdf->Cell(0, 10, "                                                                       Total: " . $total . " RON");
    $pdf->Output();
}

if (isset($_POST['generate_pdf'])) {
    generatePDF();
}

?>


