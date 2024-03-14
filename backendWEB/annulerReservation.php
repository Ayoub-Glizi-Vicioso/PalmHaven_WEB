<?php
// ajouter disponible et le prix dans la table chambre
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit;
}

if(isset($_GET['id_reservation'])) {
    require('connexion.php'); 

    $id_reservation = $_GET['id_reservation'];

    // si la reservation existe
    $sql_check_reservation = "SELECT id_chambre, date_debut, date_fin FROM reservations WHERE id_reservation = ?";
    $stmt_check_reservation = $conn->prepare($sql_check_reservation);
    $stmt_check_reservation->bind_param("i", $id_reservation);
    $stmt_check_reservation->execute();
    $result_check_reservation = $stmt_check_reservation->get_result();

    if ($result_check_reservation->num_rows > 0) {
        // recuperer les info de reservation
        $row_check_reservation = $result_check_reservation->fetch_assoc();
        $id_chambre = $row_check_reservation['id_chambre'];
        $date_debut = $row_check_reservation['date_debut'];
        $date_fin = $row_check_reservation['date_fin'];

        
        $sql_delete = "DELETE FROM reservations WHERE id_reservation = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id_reservation);

        if ($stmt_delete->execute()) {
            // Maj disponibilite de la chambre
            $sql_update_disponibilite = "UPDATE disponibilite_chambre SET disponible = 1 WHERE id_chambre = ? AND date_disponible BETWEEN ? AND ?";
            $stmt_update_disponibilite = $conn->prepare($sql_update_disponibilite);
            $stmt_update_disponibilite->bind_param("iss", $id_chambre, $date_debut, $date_fin);
            $stmt_update_disponibilite->execute();

            echo "La réservation a été supprimée avec succès.";
        } else {
            echo "Une erreur est survenue lors de la suppression de la réservation.";
        }

        $stmt_delete->close();
        $stmt_update_disponibilite->close();
    } else {
        echo "La réservation n'existe pas.";
    }

    header('Location: reservations.php');
    exit;
} else {
    echo "L'id de la réservation n'a pas été spécifié.";
}
?>
