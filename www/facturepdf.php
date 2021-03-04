<?php
require('fpdf/fpdf.php');
require_once("commons/_header.php");

define('EURO',chr(128));
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('img/logo.png',10,10,-300);
$pdf->Ln(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,10,'La Remise');
$pdf->Ln(5);
$pdf->Cell(40,10,'53 bd des Arceaux');
$pdf->Ln(5);
$pdf->Cell(40,10,'34000 Montpellier');
$pdf->Ln(5);
$pdf->Cell(40,10,'Tel : 04 67 92 37 10');
$pdf->Ln(5);

$numcommande= $DB->select1('SELECT * FROM commande WHERE cmd_id = :idcmd', array('idcmd'=>$_GET['idcmd']));
$idclient=$numcommande->cmd_compte;
$client=$DB->select1('SELECT * FROM client WHERE cpt_id = :idclient', array('idclient'=> $idclient));
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,10,'');
$pdf->Cell(20,10,$client->cli_nom);
$pdf->Cell(40,10,$client->cli_prenom);
$pdf->Ln(5);
$pdf->Cell(80,10,'');
$pdf->Cell(40,10,$client->cli_rue);
$pdf->Ln(5);
$pdf->Cell(80,10,'');
$pdf->Cell(15,10,$client->cli_cp);
$pdf->Cell(30,10,$client->cli_ville);
$pdf->Ln(20);



$pdf->Cell(50,10,utf8_decode("Commande numéro : "));
$pdf->Cell(50,10,$numcommande->cmd_id);
$pdf->Ln(10);


$commande= $DB->query('SELECT * FROM panier, produit WHERE produit.`pdt_id` = panier.`pan_pdt` AND pan_commande = :idcmd', array('idcmd'=>$_GET['idcmd']));

$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,10,'Produit');
$pdf->Cell(40,10,'Prix unitaire HT');
$pdf->Cell(20,10,utf8_decode('Quantité'));
$pdf->Cell(20,10,'Montant TTC');
$pdf->Ln(10);

foreach ($commande as $produit) {
$pdf->SetFont('Arial','',10);
$pdf->Cell(50,10,utf8_decode($produit->pdt_nom));
$pdf->Cell(40,10,$produit->pdt_prixht);
$pdf->Cell(20,10,$produit->pan_quantite);
$pdf->Cell(20,10,$produit->pan_montant);
$pdf->Ln(10);
}

$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,10,"Total TTC : ");
$pdf->Cell(40,10,$numcommande->cmd_total." ".EURO);
$pdf->Ln(10);
$pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');


$pdf->Output();
?>
