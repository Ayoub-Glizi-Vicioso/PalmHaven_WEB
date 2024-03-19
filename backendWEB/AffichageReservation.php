<?php

session_start();

if(isset($_SESSION['email'])){
    if(preg_match('/\/AffichageReservation\.php/', $_SERVER['REQUEST_URI'] , $matches)){
        
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
        
        // Requête SQL pour récupérer l'ID de l'utilisateur à partir de son e-mail
        $sql_user = "SELECT id_utilisateur FROM utilisateurs WHERE email = ?";
        $stmt_user = $connexion->prepare($sql_user);
        $stmt_user->bind_param("s", $email);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $row_user = $result_user->fetch_assoc();
        $id_utilisateur = $row_user['id_utilisateur'];
             // Requête SQL pour récupérer l'ID de l'utilisateur à partir de son e-mail
                // Requête SQL pour récupérer les réservations de l'utilisateur avec les détails de la chambre
                $requete = "SELECT  * FROM reservation r
                INNER JOIN chambre c ON r.numero_chambre = c.numero
                WHERE r.id_utilisateur = ?";
        
                // Préparer la requête SQL
                $stmt = $connexion->prepare($requete);
        
                // Vérifier si la préparation de la requête a réussi
                if ($stmt) {
                // Binder les paramètres à la requête
                $stmt->bind_param("i", $id_utilisateur);
        
                // Exécuter la requête
                $stmt->execute();
        
                // Récupérer les résultats de la requête
                $resultat = $stmt->get_result();
                $reservations = [];
        
                // Parcourir les résultats de la requête
                while ($courant = $resultat->fetch_assoc()) {
                $reservations[]=$courant;
                }
        
                // Afficher le tableau encodé en JSON
                echo json_encode($reservations);
        
                // Fermer la requête préparée
                $stmt->close();
                } else {
                // La préparation de la requête a échoué
                http_response_code(500); // Internal Server Error
                echo json_encode(['erreur' => 'Erreur lors de la préparation de la requête.', 'code' => 500]);
                }
        
             
                
                // Fermer la connexion à la base de données
                $connexion->close();
    } else {
        // L'URL ne correspond pas au format attendu
        http_response_code(400); // Bad Request
        echo json_encode(['erreur' => 'URL incorrecte.', 'code' => 400]);
    }   
} else {
    // L'utilisateur n'est pas connecté
    http_response_code(403); // Forbidden
    echo json_encode(['erreur' => 'Vous devez être connecté pour accéder à vos réservations.', 'code' => 403]);
}
        
        