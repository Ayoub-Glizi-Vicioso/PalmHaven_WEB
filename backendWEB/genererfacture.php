<?php
header('Content-Type: application/json');

// envoie une reponse JSON selon le code du statut
function envoyerRep($code, $message) {
    http_response_code($code);
    echo json_encode(array('message' => $message));
    exit;
}

session_start();
if (!isset($_SESSION['email'])) {
    envoyerRep(401, 'Vous devez être connecté pour effectuer cette action.');
}

// connexion a la bd
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$baseDeDonnees = "palmheaven";

$conn = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

if ($conn->connect_error) {
    envoyerRep(500, 'Erreur de connexion à la base de données.');
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$sql_client = "SELECT nom, prenom, email FROM utilisateurs WHERE id_utilisateur = ?";
$stmt_client = $conn->prepare($sql_client);
$stmt_client->bind_param("i", $id_utilisateur);
$stmt_client->execute();
$result_client = $stmt_client->get_result();

if ($result_client->num_rows > 0) {
    $row_client = $result_client->fetch_assoc();

    // recuperer les informations de reservation
    $sql_reservation = "SELECT id_chambre, date_debut, date_fin, prix FROM reservations WHERE id_utilisateur = ?";
    $stmt_reservation = $conn->prepare($sql_reservation);
    $stmt_reservation->bind_param("i", $id_utilisateur);
    $stmt_reservation->execute();
    $result_reservation = $stmt_reservation->get_result();

    $reservations = array();
    if ($result_reservation->num_rows > 0) {
        while ($row_reservation = $result_reservation->fetch_assoc()) {
            $reservations[] = array(
                'id_chambre' => $row_reservation['id_chambre'],
                'date_debut' => $row_reservation['date_debut'],
                'date_fin' => $row_reservation['date_fin'],
                'prix' => $row_reservation['prix']
            );
        }
    }

    // Creation d'un tableau avec les infos du client et ses reservations
    $data = array(
        'nom' => $row_client['nom'],
        'prenom' => $row_client['prenom'],
        'email' => $row_client['email'],
        'reservations' => $reservations
    );

    // sauvegarde le pdf dans un fichier
    require('fpdf/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'PALM HAVEN', 0, 1, 'L');
    $pdf->Cell(0, 10, 'palmheaven@contact.com', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Montreal, QC', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Canada', 0, 1, 'L');
    $pdf->Ln(10);

    $pdf->Cell(0, 10, 'Nom du client : ' . $row_client['nom'] . ' ' . $row_client['prenom'], 0, 1);
    $pdf->Cell(0, 10, 'Email du client : ' . $row_client['email'], 0, 1);
    $pdf->Ln(10); // Saut de ligne

    // affiche les infos de la reservation dans le pdf
    if ($result_reservation->num_rows > 0) {
        while ($row_reservation = $result_reservation->fetch_assoc()) {
            $prix_chambre = $row_reservation['prix'];
            $date_debut = new DateTime($row_reservation['date_debut']);
            $date_fin = new DateTime($row_reservation['date_fin']);
            $duree_reservation = $date_debut->diff($date_fin)->days;
            $total = $prix_chambre * $duree_reservation;

            //ajout de ligne pour chaque reservation
            $pdf->Cell(30, 10, $row_reservation['id_chambre'], 1, 0, 'C');
            $pdf->Cell(30, 10, $date_debut->format('Y-m-d'), 1, 0, 'C');
            $pdf->Cell(30, 10, $date_fin->format('Y-m-d'), 1, 0, 'C');
            $pdf->Cell(30, 10, number_format($prix_chambre, 2), 1, 0, 'C');
            $pdf->Cell(30, 10, number_format($total, 2), 1, 1, 'C');
        }
    } else {
        $pdf->Cell(0, 10, 'Aucune réservation trouvée.', 0, 1);
    }

    // Sauvegarder le pdf dans un fichier
    $nom_fichier = 'facture_' . $_SESSION['email'] . '.pdf';
    $pdf->Output('F', $nom_fichier);

    /
    $stmt_client->close();
    $stmt_reservation->close();
    $conn->close();

    // wnvoi le nom du fichier en reponse JSON
    echo json_encode(array('message' => 'Facture générée avec succès.', 'fichier' => $nom_fichier));
} else {
    envoyerRep(404, 'Aucun client trouvé.');
}

?>
