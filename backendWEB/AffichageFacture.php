<?php

session_start();


if (preg_match('/\/AffichageFacture\.php/', $_SERVER['REQUEST_URI'], $matches)) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' ) {
          // Vérifier la connexion à la base de données
          $connexion = new mysqli("localhost", "root", "", "palmhaven");

          if ($connexion->connect_error) {
              http_response_code(500); // Internal Server Error
              echo json_encode(['erreur' => 'Connexion échouée à la base de données.', 'code' => 500]);
              exit();
          }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
      
            // Obtenir les données POST au format JSON
            $donneesJSON = file_get_contents("php://input");
            
            // Décoder les données JSON en tableau associatif
            $donnees = json_decode($donneesJSON, true);
            
            $num_reservation = $donnees['numero_reservation'];


             // Vérifier si le numéro de réservation existe dans la table des réservations
            $requete_verif = "SELECT COUNT(*) AS count FROM reservation WHERE numero_reservation = ?";
            $stmt_verif = $connexion->prepare($requete_verif);
            $stmt_verif->bind_param("i", $num_reservation);
            $stmt_verif->execute();
            $resultat_verif = $stmt_verif->get_result();
            $row = $resultat_verif->fetch_assoc();
            $nombre_reservations = $row['count'];

            // Si le numéro de réservation n'existe pas, retourner une erreur
            if ($nombre_reservations == 0) {
                http_response_code(400);
                echo json_encode(['erreur' => 'Numéro de réservation invalide']);
                exit();
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            
            // Assurez-vous que le numéro de réservation est fourni et est un nombre entier
            if (isset($_SESSION['numero_reservation']) && is_numeric($_SESSION['numero_reservation'])) {
                // Récupérer le numéro de réservation et échapper les caractères spéciaux
                $num_reservation = $_SESSION['numero_reservation'];
            } else {
                // Le numéro de réservation n'est pas valide
                http_response_code(400); 
                echo json_encode(['erreur' => 'Numéro de réservation non valide.', 'code' => 400]);
                exit();
            }
            
            
        }
        
            
        $mail= $_SESSION["email"];

      

        $requete = "SELECT r.date_debut, r.numero_reservation , r.date_fin, c.prix, c.type_chambre, u.nom FROM reservation r
        INNER JOIN chambre c ON r.numero_chambre = c.numero
        INNER JOIN utilisateurs u ON r.id_utilisateur = u.id_utilisateur
        WHERE r.numero_reservation = ? 
        AND  u.email = '$mail'";
        

        // Préparation de la requête SQL
        $stmt = $connexion->prepare($requete);

        if ($stmt) {
            // Binder le paramètre à la requête
            $stmt->bind_param("i", $num_reservation);

            // Exécuter la requête
            $stmt->execute();

            // Récupérer les résultats de la requête
            $resultat = $stmt->get_result();
            $valeur = [];

            // Parcourir les résultats de la requête
            while ($courant = $resultat->fetch_assoc()) {
                $valeur[] = $courant;
            }
            // Afficher les résultats en JSON
            echo json_encode($valeur);

            // Fermer la requête préparée
            $stmt->close();

            // Fermer la connexion à la base de données
            $connexion->close();

        } else {
            // La préparation de la requête a échoué
            http_response_code(500); 
            echo json_encode(['erreur' => 'Erreur lors de la préparation de la requête.', 'code' => 500]);
        }
    } else {
        // Méthode non autorisée
        http_response_code(405);
        echo json_encode(['erreur' => 'Méthode non autorisée.', 'code' => 405]);
    }
} else {
    // L'URL ne correspond pas au format attendu
    http_response_code(400);
    echo json_encode(['erreur' => 'URL incorrecte.', 'code' => 400]);
}
    