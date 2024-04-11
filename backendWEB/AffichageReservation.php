<?php

session_start();

if(preg_match('/\/AffichageReservation\.php/', $_SERVER['REQUEST_URI'], $matches)) {

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_SESSION['email'])) {
            // Récupérer l'email de session
            $email = $_SESSION['email'];

            // Connexion à la base de données
            $serveur = "localhost"; // Adresse du serveur MySQL
            $utilisateur = "root";
            $motDePasse = "";
            $baseDeDonnees = "palmhaven"; // Nom de la base de données MySQL

            // Connexion à la base de données
            $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

            // Vérifier la connexion
            if ($connexion->connect_error) {
                die("Connexion échouée: " . $connexion->connect_error);
            }

            // Requête SQL pour récupérer les réservations de l'utilisateur avec les détails de la chambre
            $requete = "SELECT r.*, c.* FROM reservation r
                        INNER JOIN chambre c ON r.numero_chambre = c.numero
                        WHERE r.id_utilisateur = (SELECT id_utilisateur FROM utilisateurs WHERE email = ?) AND r.date_debut > NOW()"; 
                        // Filtre les réservations d'un utilisateur selon la date actuelle

            // Préparer la requête SQL
            $stmt = $connexion->prepare($requete);

            // Vérifier si la préparation de la requête a réussi
            if ($stmt) {
                // Binder les paramètres à la requête
                $stmt->bind_param("s", $email);

                // Exécuter la requête
                $stmt->execute();

                // Récupérer les résultats de la requête
                $resultat = $stmt->get_result();
                $reservations = [];

                // Parcourir les résultats de la requête
                while ($courant = $resultat->fetch_assoc()) {
                    $reservations[] = $courant;
                }

                // Fermer la requête préparée
                $stmt->close();

                // Supprimer les réservations expirées
                $requeteSuppression = "DELETE FROM reservation WHERE id_utilisateur = (SELECT id_utilisateur FROM utilisateurs WHERE email = ?) AND date_debut <= NOW()";
                $stmtSuppression = $connexion->prepare($requeteSuppression);
                if ($stmtSuppression) {
                    $stmtSuppression->bind_param("s", $email);
                    $stmtSuppression->execute();
                    $stmtSuppression->close();
                } else {
                    // La préparation de la requête de suppression a échoué
                    http_response_code(500);
                    echo json_encode(['erreur' => 'Erreur lors de la préparation de la requête de suppression.', 'code' => 500]);
                }

                // Afficher le tableau encodé en JSON
                echo json_encode($reservations);
            } else {
                // La préparation de la requête a échoué
                http_response_code(500);
                echo json_encode(['erreur' => 'Erreur lors de la préparation de la requête.', 'code' => 500]);
            }

            // Fermer la connexion à la base de données
            $connexion->close();
        } else {
            //L'utilisateur n'est pas connecté
            // Afficher le contenu de $_SESSION['email'] dans le logcat du serveur
            error_log("Email: " . $_SESSION['email']);
            echo json_encode(['erreur' => 'Vous devez être connecté pour accéder à vos réservations.']);
        }

    } else {
        echo json_encode(array("succes" => 'false', "message" => "Méthode non autorisée."));
    }

} else {
    echo json_encode(['message' => 'Mauvais url.']);
}
    
?>
