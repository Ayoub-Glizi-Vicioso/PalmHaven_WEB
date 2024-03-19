<?php

session_start(); // Démarrer la session
// Vérifier si le formulaire a été soumis

if(isset($_SESSION['email'])){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(isset($_POST['numero_chambre'])){
        // Vérifier si toutes les données requises sont présentes et valides
        
        $numero_chambre = $_POST["numero_chambre"];
        
        $start_date = $_SESSION["date_debut"];
        $end_date = $_SESSION["date_fin"];
        
        
        
        
        
        $serveur = "localhost"; // adresse du serveur MySQL
        $utilisateur = "root"; 
        $motDePasse = ""; 
        $baseDeDonnees = "palmhaven"; // nom de la base de données MySQL
        
        // Connexion à la base de données
        $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);
        
        // Vérifier la connexion
        if ($connexion->connect_error) {
            die("Connexion échouée: " . $connexion->connect_error);
        } 
        
        // attribuer la reservation a l'id de l'utilisateur
        $email =  $_SESSION['email'];
        
        
        $sql_user = "SELECT id_utilisateur FROM utilisateurs WHERE email = ?";
        $stmt_user = $connexion->prepare($sql_user);
        $stmt_user->bind_param("s", $email);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $row_user = $result_user->fetch_assoc();
        $id_utilisateur = $row_user['id_utilisateur'];
        
        
        
        // Exécuter une requête SELECT pour vérifier si l'utilisateur a déjà réservé cette chambre pour cette période
        $sql_check_reservation = "SELECT * FROM reservation WHERE id_utilisateur = ? AND numero_chambre = ? AND date_debut = ? AND date_fin = ?";
        $stmt_check_reservation = $connexion->prepare($sql_check_reservation);
        $stmt_check_reservation->bind_param("iiss", $id_utilisateur, $numero_chambre, $start_date, $end_date);
        $stmt_check_reservation->execute();
        $result_check_reservation = $stmt_check_reservation->get_result();
        
        // Vérifier si une réservation existe déjà
        if ($result_check_reservation->num_rows > 0) {
            // Afficher un message à l'utilisateur
            echo "Vous avez déjà réservé cette chambre pour cette période.";
        } else {
            // Si aucune réservation n'existe, procéder à l'insertion de la nouvelle réservation
            // Exemple de requête d'insertion de réservation
            $sql_insert_reservation = "INSERT INTO reservation (numero_chambre, date_debut , date_fin , id_utilisateur) VALUES (?,?,?,?)";
            $stmt_insert_reservation = $connexion->prepare($sql_insert_reservation);
            $stmt_insert_reservation->bind_param("issi", $numero_chambre, $start_date, $end_date, $id_utilisateur);
            
            if ($stmt_insert_reservation->execute()) {
                
                header("Location: ../interfaceWEB/chambresDetailsBungalow.php?reservation_success=true");
                
            } else {
                echo "Erreur lors de la réservation : " . $connexion->error;
            }
        }
        
        // Fermer la connexion
        $connexion->close();
    }
}
}else{
    echo ('vous devais être connecter afin de pour faire une réservation');
}
