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

// Préparer la requête SQL pour récupérer les informations du client
$id_utilisateur = $_SESSION['id_utilisateur'];
$sql = "SELECT nom, prenom, email
        FROM utilisateurs
        WHERE id_utilisateur = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_utilisateur);

// Exécuter la requête pour récupérer les informations du client

$stmt->execute();
$result = $stmt->get_result();

// Récupérer les informations du client
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Préparer la requête SQL pour récupérer les informations de réservation
    $sql_reservation = "SELECT id_chambre, date_debut, date_fin, prix
                        FROM reservations
                        WHERE id_utilisateur = ?";
    $stmt_reservation = $conn->prepare($sql_reservation);
    $stmt_reservation->bind_param("s", $id_utilisateur);

    // Exécuter la requête pour les informations de réservation
    $stmt_reservation->execute();
    $result_reservation = $stmt_reservation->get_result();

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

    // Afficher les informations de réservation dans le PDF
    if ($result_reservation->num_rows > 0) {
        while ($row_reservation = $result_reservation->fetch_assoc()) {
            $prix_chambre = $row_reservation['prix'];
            $date_debut = new DateTime($row_reservation['date_debut']);
            $date_fin = new DateTime($row_reservation['date_fin']);
            $duree_reservation = $date_debut->diff($date_fin)->days;
            $total = $prix_chambre * $duree_reservation;

            // Ajouter une ligne pour chaque réservation
            $pdf->Cell(30, 10, $row_reservation['id_chambre'], 1, 0, 'C');
            $pdf->Cell(30, 10, $date_debut->format('Y-m-d'), 1, 0, 'C');
            $pdf->Cell(100, 10, $date_fin->format('Y-m-d'), 1, 0, 'C');
            $pdf->Cell(30, 10, number_format($prix_chambre, 2), 1, 0, 'C');
            $pdf->Cell(30, 10, number_format($total, 2), 1, 1, 'C');
        }
    } else {
        echo "Aucune réservation trouvée.";
    }

    // Sauvegarder le PDF dans un fichier
    $nom_fichier = 'facture_' . $_SESSION['email'] . '.pdf';
    $pdf->Output('F', $nom_fichier);

    echo "<p>Facture générée avec succès. <a href='$nom_fichier'>Télécharger la facture</a></p>";
} else {
    echo "Aucun client trouvé.";
}

// Fermer les requêtes et la connexion à la base de données
$stmt->close();
$stmt_reservation->close();
$conn->close();
?>
