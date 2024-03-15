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

    if (isset($data->id_chambre) && isset($data->date_debut) && isset($data->date_fin)) {
        $id_chambre = $data->id_chambre;
        $date_debut = $data->date_debut;
        $date_fin = $data->date_fin;

        // Verifie si la chambre est disponible pour les dates voulues
        $sql_verif_dispo = "SELECT COUNT(*) AS total_reservations
                            FROM reservations
                            WHERE id_chambre = ? AND
                                    ((date_debut BETWEEN ? AND ?) OR
                                    (date_fin BETWEEN ? AND ?))";
        $stmt_verif_dispo = $conn->prepare($sql_verif_dispo);
        $stmt_verif_dispo->bind_param("issss", $id_chambre, $date_debut, $date_fin, $date_debut, $date_fin);
        $stmt_verif_dispo->execute();
        $result_verif_dispo = $stmt_verif_dispo->get_result();
        $row_verif_dispo = $result_verif_dispo->fetch_assoc();
        $total_reservations = $row_verif_dispo['total_reservations'];

        if ($total_reservations == 0) {
            $date_debut_obj = new DateTime($date_debut);
            $date_fin_obj = new DateTime($date_fin);
            $duree_reservation = $date_debut_obj->diff($date_fin_obj)->days;

            // trouve le prix de la chambre 
            $sql_prix = "SELECT prix FROM chambre WHERE id_chambre = ?";
            $stmt_prix = $conn->prepare($sql_prix);
            $stmt_prix->bind_param("i", $id_chambre);
            $stmt_prix->execute();
            $result_prix = $stmt_prix->get_result();
            $row_prix = $result_prix->fetch_assoc();
            $prix_chambre = $row_prix['prix'];

            $prix_total = $prix_chambre * $duree_reservation;

            // attribue la reservation a l'id de l'utilisateur
            $email = $_SESSION['email'];
            $sql_user = "SELECT id_utilisateur FROM utilisateur WHERE email = ?";
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->bind_param("s", $email);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $row_user = $result_user->fetch_assoc();
            $id_utilisateur = $row_user['id_utilisateur'];

            // mettre la reservation
            $sql_reservation = "INSERT INTO reservation (id_utilisateur, id_chambre, date_debut, date_fin, prix)
                                VALUES (?, ?, ?, ?, ?)";
            $stmt_reservation = $conn->prepare($sql_reservation);
            $stmt_reservation->bind_param("iisss", $id_utilisateur, $id_chambre, $date_debut, $date_fin, $prix_total);

            if ($stmt_reservation->execute()) {
                http_response_code(201); 
                echo json_encode(array('message' => 'La réservation a été créée avec succès.'));
            } else {
                http_response_code(500); 
                echo json_encode(array('message' => 'Une erreur est survenue lors de la création de la réservation.'));
            }

            $stmt_prix->close();
            $stmt_user->close();
            $stmt_reservation->close();
        } else {
            http_response_code(400); 
            echo json_encode(array('message' => 'La chambre n\'est pas disponible pour les dates sélectionnées.'));
        }

        $stmt_verif_dispo->close();
    } else {
        http_response_code(400); 
        echo json_encode(array('message' => 'Les paramètres id_chambre, date_debut et date_fin sont requis.'));
    }
} else {
    http_response_code(405); 
    echo json_encode(array('message' => 'Méthode non autorisée.'));
}

$conn->close();
?>
