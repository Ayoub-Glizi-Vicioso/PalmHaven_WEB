<?php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit;
}

// Vérifier si le formulaire de modification a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_reservation'])) {
    require('connexion.php'); 

    $id_reservation = $_POST['id_reservation'];
    $id_chambre = $_POST['id_chambre'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    // Récupérer le prix de la chambre depuis la table chambre
    // Ajouter un champ prix dans la table chambre svp
    $sql_chambre = "SELECT prix FROM chambre WHERE id_chambre = ?";
    $stmt_chambre = $conn->prepare($sql_chambre);
    $stmt_chambre->bind_param("i", $id_chambre);
    $stmt_chambre->execute();
    $result_chambre = $stmt_chambre->get_result();
    $row_chambre = $result_chambre->fetch_assoc();
    $prix_chambre = $row_chambre['prix'];

    // nouveau prix en fonction des dates
    $date_debut_obj = new DateTime($date_debut);
    $date_fin_obj = new DateTime($date_fin);
    $duree_reservation = $date_debut_obj->diff($date_fin_obj)->days;
    $prix_total = $prix_chambre * $duree_reservation;

    //MAJ de la chambre
    $sql_update = "UPDATE reservations
                   SET id_chambre = ?, date_debut = ?, date_fin = ?, prix = ?
                   WHERE id_reservation = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("isssi", $id_chambre, $date_debut, $date_fin, $prix_total, $id_reservation);

    
    if ($stmt_update->execute()) {
        echo "La réservation a été modifiée avec succès.";
    } else {
        echo "Une erreur est survenue lors de la modification de la réservation.";
    }

    // Fermer les requêtes
    $stmt_chambre->close();
    $stmt_update->close();
}
// fichier a faire pour la reservation
header('Location: reservations.php');
exit;
?>
