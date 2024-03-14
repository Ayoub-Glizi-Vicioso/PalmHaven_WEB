<?php
// ajouter attribut disponible et prix dans la table chambre de la base de donnees
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_reservation'])) {
    require('connexion.php'); 

    $id_reservation = $_POST['id_reservation'];
    $id_chambre = $_POST['id_chambre'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $date_debut_obj = new DateTime($date_debut);
    $date_fin_obj = new DateTime($date_fin);
    $duree_reservation = $date_debut_obj->diff($date_fin_obj)->days;

    // si la chambre est dispo pour les nouvelles dates
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

    if ($total_reservations == 0) {
        // modifier la reservation
        $sql_update_reservation = "UPDATE reservations
                                   SET id_chambre = ?, date_debut = ?, date_fin = ?
                                   WHERE id_reservation = ?";
        $stmt_update_reservation = $conn->prepare($sql_update_reservation);
        $stmt_update_reservation->bind_param("isss", $id_chambre, $date_debut, $date_fin, $id_reservation);

        if ($stmt_update_reservation->execute()) {
            // rendre la chambre dispo pour les dates changes
            mettreAJourDisponibiliteChambre($id_chambre, $date_debut, $date_fin);
        
            echo "La réservation a été modifiée avec succès.";
        } else {
            echo "Une erreur est survenue lors de la modification de la réservation.";
        }

        $stmt_update_reservation->close();
    } else {
        echo "La chambre n'est pas disponible pour les dates sélectionnées.";
    }

    $stmt_check_disponibilite->close();
}
    header('Location: reservations.php');
    exit;
?>

<?php
// fonction pour mettre a jour les dispo des chambres apres la modification
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
