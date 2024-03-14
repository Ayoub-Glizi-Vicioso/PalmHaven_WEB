<?php

session_start();

// Vérifier si le client est connecté
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); // Rediriger vers la page de connexion si le client n'est pas connecté
    exit;
}
require('fpdf/fpdf.php');

// Créer une nouvelle instance de FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Ajouter un titre
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Facture', 0, 1, 'C');

// Informations sur l'entreprise
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'PALM HAVEN', 0, 1, 'L');
$pdf->Cell(0, 10, 'palmheaven@contact.com', 0, 1, 'L');
$pdf->Cell(0, 10, 'Montreal, QC', 0, 1, 'L');
$pdf->Cell(0, 10, 'Canada', 0, 1, 'L');
$pdf->Ln(10); // Saut de ligne

// Informations sur le client
$pdf->Cell(0, 10, 'Nom du client : John Doe', 0, 1, 'L');
$pdf->Cell(0, 10, 'Adresse du client : 123 Rue de la Facture', 0, 1, 'L');
$pdf->Cell(0, 10, 'Ville, Code postal', 0, 1, 'L');
$pdf->Cell(0, 10, 'Pays', 0, 1, 'L');
$pdf->Ln(10); // Saut de ligne

// Tableau des reservation (MAJ quand on aura implemente la reservation de chmabre)
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'Quantite', 1, 0, 'C');
$pdf->Cell(100, 10, 'Description', 1, 0, 'C');
$pdf->Cell(30, 10, 'Prix unitaire', 1, 0, 'C');
$pdf->Cell(30, 10, 'Total', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 10, '1', 1, 0, 'C');
$pdf->Cell(100, 10, 'Produit A', 1, 0);
$pdf->Cell(30, 10, '10.00', 1, 0, 'R');
$pdf->Cell(30, 10, '10.00', 1, 1, 'R');

$pdf->Cell(30, 10, '1', 1, 0, 'C');
$pdf->Cell(100, 10, 'Produit B', 1, 0);
$pdf->Cell(30, 10, '20.00', 1, 0, 'R');
$pdf->Cell(30, 10, '20.00', 1, 1, 'R');

$pdf->Cell(30, 10, '', 0);
$pdf->Cell(100, 10, '', 0);
$pdf->Cell(30, 10, 'Total', 1, 0, 'R');
$pdf->Cell(30, 10, '30.00', 1, 1, 'R');

$nom_fichier = 'facture_' . $_SESSION['email'] . '.pdf';

// Sauvegarder le PDF dans un fichier
$pdf->Output('F', 'facture.pdf');

echo "<p>Facture générée avec succès. <a href='$nom_fichier'>Télécharger la facture</a></p>";
?>