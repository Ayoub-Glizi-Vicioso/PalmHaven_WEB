<?php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit;
}

require('fpdf/fpdf.php');

// Connexion à la base de données
$serveur = "localhost"; // adresse du serveur MySQL
$utilisateur = "root"; 
$motDePasse = ""; 
$baseDeDonnees = "palmheaven"; // nom de la base de données MySQL

$conn = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Préparer la requête SQL
$email_client = $_SESSION['email'];
$sql = "SELECT nom, prenom, email
        FROM utilisateurs
        WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email_client);

// Exécuter la requête
$stmt->execute();
$result = $stmt->get_result();

// Récupérer les informations du client
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Créer une nouvelle instance de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Informations sur l'entreprise
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'PALM HAVEN', 0, 1, 'L');
    $pdf->Cell(0, 10, 'palmheaven@contact.com', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Montreal, QC', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Canada', 0, 1, 'L');
    $pdf->Ln(10); // Saut de ligne

    // Informations du client
    $pdf->Cell(0, 10, 'Nom du client : ' . $row['nom'] . ' ' . $row['prenom'], 0, 1);
    $pdf->Cell(0, 10, 'Email du client : ' . $row['email'], 0, 1);
    $pdf->Ln(10); // Saut de ligne

    // Tableau des réservations (à mettre à jour lorsque la réservation de chambre sera implémentée)
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Quantite', 1, 0, 'C');
    $pdf->Cell(100, 10, 'Description', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Prix unitaire', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Total', 1, 1, 'C');
    $pdf->Cell(30, 10, '30.00', 1, 1, 'R');

    // Sauvegarder le PDF dans un fichier
    $nom_fichier = 'facture_' . $_SESSION['email'] . '.pdf';
    $pdf->Output('F', $nom_fichier);

    echo "<p>Facture générée avec succès. <a href='$nom_fichier'>Télécharger la facture</a></p>";
} else {
    echo "Aucun client trouvé.";
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>
