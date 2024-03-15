<?php

header('Content-Type: application/json');


if (!isset($_SESSION['email'])) {
    http_response_code(401); 
    echo json_encode(array('message' => 'Vous devez être connecté pour effectuer cette action.'));
    exit;
}

require('connexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id_reservation) && isset($data->id_chambre) && isset($data->date_debut) && isset($data->date_fin)) {
        $id_reservation = $data->id_reservation;
        $id_chambre = $data->id_chambre;
        $date_debut = $data->date_debut;
        $date_fin = $data->date_fin;

        // calculer la duree de la reservation
        $date_debut_obj = new DateTime($date_debut);
        $date_fin_obj = new DateTime($date_fin);
        $duree_reservation = $date_debut_obj->diff($date_fin_obj)->days;

        //fonction faite en dessous
        $total_reservations = verifierDisponibiliteChambre($id_chambre, $date_debut, $date_fin, $id_reservation);

        if ($total_reservations == 0) {
            // fonction faite en dessous
            if (modifierReservation($id_reservation, $id_chambre, $date_debut, $date_fin)) {
                //fonction faite en dessous
                mettreAJourDisponibiliteChambre($id_chambre, $date_debut, $date_fin);

                http_response_code(200); 
                echo json_encode(array('message' => 'La réservation a été modifiée avec succès.'));
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(array('message' => 'Une erreur est survenue lors de la modification de la réservation.'));
            }
        } else {
            http_response_code(400); 
            echo json_encode(array('message' => 'La chambre n\'est pas disponible pour les dates sélectionnées.'));
        }
    } else {
        http_response_code(400); 
        echo json_encode(array('message' => 'Les paramètres id_reservation, id_chambre, date_debut et date_fin sont requis.'));
    }
} else {
    http_response_code(405); 
    echo json_encode(array('message' => 'Méthode non autorisée.'));
}

$conn->close();

// Fonction pour verifier si une chambre est disponible
function verifierDisponibiliteChambre($id_chambre, $date_debut, $date_fin, $id_reservation) {
    global $conn;

    $sql_check_disponibilite = "SELECT COUNT(*) AS total_reservations
                                FROM reservations
                                WHERE id_chambre = ? AND
                                      ((date_debut BETWEEN ? AND ?) OR
                                       (date_fin BETWEEN ? AND ?)) AND
                                      id_reservation != ?";
    $stmt_check_disponibilite = $conn->prepare($sql_check_disponibilite);
    $stmt_check_disponibilite->bind_param("issssi", $id_chambre, $date_debut, $date_fin, $date_debut, $date_fin, $id_reservation);
    $stmt_check_disponibilite->execute();
    $result_check_disponibilite = $stmt_check_disponibilite->get_result();
    $row_check_disponibilite = $result_check_disponibilite->fetch_assoc();
    $total_reservations = $row_check_disponibilite['total_reservations'];

    $stmt_check_disponibilite->close();

    return $total_reservations;
}

// Fonction pour modifier une reservation
function modifierReservation($id_reservation, $id_chambre, $date_debut, $date_fin) {
    global $conn;

    $sql_update_reservation = "UPDATE reservations
                               SET id_chambre = ?, date_debut = ?, date_fin = ?
                               WHERE id_reservation = ?";
    $stmt_update_reservation = $conn->prepare($sql_update_reservation);
    $stmt_update_reservation->bind_param("isss", $id_chambre, $date_debut, $date_fin, $id_reservation);
    $result = $stmt_update_reservation->execute();

    $stmt_update_reservation->close();

    return $result;
}

// Fonction pour faire la maj des disponibilites d'une chambre
function mettreAJourDisponibiliteChambre($id_chambre, $date_debut, $date_fin) {
    global $conn;

    $date_debut_obj = new DateTime($date_debut);
    $date_fin_obj = new DateTime($date_fin);

    $current_date = clone $date_debut_obj;
    while ($current_date <= $date_fin_obj) {
        $date = $current_date->format('Y-m-d');
        $sql_update_disponibilite = "UPDATE disponibilites_chambres
                                      SET disponible = 1
                                      WHERE id_chambre = ? AND date = ?";
        $stmt_update_disponibilite = $conn->prepare($sql_update_disponibilite);
        $stmt_update_disponibilite->bind_param("is", $id_chambre, $date);
        $stmt_update_disponibilite->execute();

        $current_date->modify('+1 day');
    }
}
?>
