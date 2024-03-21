<?php
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    http_response_code(401); 
    echo json_encode(array('message' => 'Vous devez être connecté pour effectuer cette action.'));
    exit;
}

require('connexion.php');

if(isset($_GET['id_reservation'])) {
    $id_reservation = $_GET['id_reservation'];

    // verifie si la reservation existe, la fonction est definie en dessous
    if (reservationExists($id_reservation)) {
        // Suppression de la reservation, fonction qui est definie en dessous
        if (deleteReservation($id_reservation)) {
            http_response_code(200);
            echo json_encode(array('message' => 'La réservation a été supprimée avec succès.'));
        } else {
            http_response_code(500); 
            echo json_encode(array('message' => 'Une erreur est survenue lors de la suppression de la réservation.'));
        }
    } else {
        http_response_code(404); 
        echo json_encode(array('message' => 'La réservation n\'existe pas.'));
    }
} else {
    http_response_code(400); 
    echo json_encode(array('message' => 'L\'id de la réservation n\'a pas été spécifié.'));
}

$conn->close();

// fonction qui verifie si la reservation existe
function reservationExists($id_reservation) {
    global $conn;

    $sql_check_reservation = "SELECT id_chambre FROM reservations WHERE id_reservation = ?";
    $stmt_check_reservation = $conn->prepare($sql_check_reservation);
    $stmt_check_reservation->bind_param("i", $id_reservation);
    $stmt_check_reservation->execute();
    $stmt_check_reservation->store_result();

    return $stmt_check_reservation->num_rows > 0;
}

// Fonction qui supprime une reservation
function deleteReservation($id_reservation) {
    global $conn;

    $sql_get_reservation_info = "SELECT id_chambre, date_debut, date_fin FROM reservations WHERE id_reservation = ?";
    $stmt_get_reservation_info = $conn->prepare($sql_get_reservation_info);
    $stmt_get_reservation_info->bind_param("i", $id_reservation);
    $stmt_get_reservation_info->execute();
    $result_get_reservation_info = $stmt_get_reservation_info->get_result();
    $row_reservation_info = $result_get_reservation_info->fetch_assoc();

    $id_chambre = $row_reservation_info['id_chambre'];
    $date_debut = $row_reservation_info['date_debut'];
    $date_fin = $row_reservation_info['date_fin'];

    $stmt_get_reservation_info->close();

    $sql_delete_reservation = "DELETE FROM reservations WHERE id_reservation = ?";
    $stmt_delete_reservation = $conn->prepare($sql_delete_reservation);
    $stmt_delete_reservation->bind_param("i", $id_reservation);
    $delete_success = $stmt_delete_reservation->execute();

    if ($delete_success) {
        // maj de la disponibilite de la chambre
        $sql_update_disponibilite = "UPDATE disponibilite_chambre SET disponible = 1 WHERE id_chambre = ? AND date_disponible BETWEEN ? AND ?";
        $stmt_update_disponibilite = $conn->prepare($sql_update_disponibilite);
        $stmt_update_disponibilite->bind_param("iss", $id_chambre, $date_debut, $date_fin);
        $stmt_update_disponibilite->execute();

        return true;
    } else {
        return false;
    }
}
?>
