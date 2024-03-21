<?php
session_start();

if(preg_match('/\/annulerReservation\.php/', $_SERVER['REQUEST_URI'], $matches)) {
    if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        // Récupération des données de la requête DELETE
        $donneesJSON = file_get_contents("php://input");
        $donnees = json_decode($donneesJSON, true);

        // Vérification si les données contiennent l'ID de réservation
        if(isset($donnees['id_reservation'])) {
            $id_reservation = $donnees['id_reservation'];
            $email_session = $_SESSION['email'];

            // Connexion à la base de données
            $serveur = "localhost"; 
            $utilisateur = "root"; 
            $code = ""; 
            $baseDeDonnees = "palmhaven"; 
            $conn = new mysqli($serveur, $utilisateur, $code, $baseDeDonnees);
            if ($conn->connect_error) {
                die('Erreur de connexion à la base de données : ' . $conn->connect_error);
            }

            // Requête SQL pour supprimer la réservation
            $sql = "DELETE FROM reservation WHERE numero_reservation = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_reservation);

            if($stmt->execute()) {
                // Redirection vers la page de profil après l'annulation de la réservation
                header("Location: ../interfaceWEB/Profilmesreservtion.php?annulation_success=true");
                exit;
            } else {
                echo "Erreur lors de l'annulation de la réservation : " . $conn->error;
            }
        } else {
            // Si l'ID de réservation n'est pas fourni dans les données DELETE
            http_response_code(400);
            echo json_encode(array("message" => "ID de réservation non spécifié."));
        }
    } else {
        // Gérer le cas où la méthode de la requête n'est pas DELETE
        http_response_code(405);
        echo json_encode(array("message" => "Méthode HTTP non autorisée."));
    }
}
?>
