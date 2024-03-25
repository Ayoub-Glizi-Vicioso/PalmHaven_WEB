<?php

session_start();
if(preg_match('/\/modificationReservation\.php/', $_SERVER['REQUEST_URI'], $matches)) {
    
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        // Obtenir les données POST au format JSON
        $donneesJSON = file_get_contents("php://input");
    
        // Décoder les données JSON en tableau associatif
        $donnees = json_decode($donneesJSON, true);
        
        // Extraire les valeurs du tableau associatif
        $date_debut = $donnees['nouv_debut'];
        $date_fin = $donnees['nouv_fin']; 
        $identification_reservation = $donnees['id_reservation']; 
        $email_saisie = $donnees['email'];
        $email_session = $_SESSION['email'];
       
          
        if(isset($donnees['id_reservation'])){

                
            $serveur = "localhost"; 
            $utilisateur = "root"; 
            $code = ""; 
            $baseDeDonnees = "palmhaven"; 
            
            // Connexion à la base de données
            $conn = new mysqli($serveur, $utilisateur, $code, $baseDeDonnees);
            if ($conn->connect_error) {
                http_response_code(500);
                echo json_encode(array("message" => "Erreur de connexion à la base de données : " . $conn->connect_error));
                die();
            }
            
            if($email_saisie  == $email_session){

                
                $sql_get_reservation_id = "SELECT numero_reservation FROM reservation WHERE numero_reservation = ?";
                $stmt_get_reservation_id = $conn->prepare($sql_get_reservation_id);
                $stmt_get_reservation_id->bind_param("i", $identification_reservation);
                $stmt_get_reservation_id->execute();
                $stmt_get_reservation_id->bind_result($id_reservation);
                $stmt_get_reservation_id->fetch();
                $stmt_get_reservation_id->close();

                if($id_reservation==0){

                    echo json_encode(array("message" => "Numéro de reservation introuvable"));

                }else{
                    
                    // Requête SQL pour récupérer l'identifiant de la chambre
                    $sql_get_chambre_id = "SELECT numero_chambre FROM reservation WHERE numero_reservation = ?";
                    $stmt_get_chambre_id = $conn->prepare($sql_get_chambre_id);
                    $stmt_get_chambre_id->bind_param("i", $identification_reservation);
                    $stmt_get_chambre_id->execute();
                    $stmt_get_chambre_id->bind_result($id_chambre);
                    $stmt_get_chambre_id->fetch();
                    $stmt_get_chambre_id->close();
                    
                    
                    
                        
                        // si la chambre est dispo pour les nouvelles dates
                        $sql_check_disponibilite = "SELECT c.numero AS numero_chambre, COUNT(*) AS total_reservations
                    FROM reservation r
                    INNER JOIN chambre c ON r.numero_chambre = c.numero
                    WHERE (r.numero_chambre = ? AND
                        ((? BETWEEN r.date_debut AND r.date_fin) OR
                        (? BETWEEN r.date_debut AND r.date_fin) OR
                        (r.date_debut BETWEEN ? AND ?) OR
                        (r.date_fin BETWEEN ? AND ?))) AND
                        r.numero_reservation != ?
                    GROUP BY c.numero";
        
                
                    
                    $stmt_check_disponibilite = $conn->prepare($sql_check_disponibilite);
                    $stmt_check_disponibilite->bind_param("issssssi", $id_chambre, $date_debut, $date_fin, $date_debut, $date_fin, $date_debut, $date_fin, $identification_reservation);
                    $stmt_check_disponibilite->execute();
                    $stmt_check_disponibilite->bind_result($numero_chambre ,$total_reservations);
                    $stmt_check_disponibilite->fetch();
                    $stmt_check_disponibilite->close();
                    
                    
                    if ($total_reservations == 0) {
                        // modifier la reservation
                        $sql_update_reservation = "UPDATE reservation
                                    SET numero_chambre = ?, date_debut = ?, date_fin = ?
                                    WHERE numero_reservation = ?";
                                $stmt_update_reservation = $conn->prepare($sql_update_reservation);
                                $stmt_update_reservation->bind_param("isss", $id_chambre, $date_debut, $date_fin, $identification_reservation);
                                
                                if ($stmt_update_reservation->execute()) {
                                    
                                    http_response_code(200);
                                    echo json_encode(array("message" => "La réservation a été modifiée avec succès."));
                                    
                                    
                                } else {
                                    http_response_code(500);
                                    echo json_encode(array("message" => "Une erreur est survenue lors de la modification de la réservation."));
                                }
                                
                                $stmt_update_reservation->close();
                    } else {
                        http_response_code(400);
                        echo json_encode(array("message" => "La chambre n'est pas disponible pour les dates sélectionnées."));
                    }
                
               }
                
            }else{
                http_response_code(403);
                echo json_encode(array("message" => "Vous essayez de modifier une réservation qui n'est pas associée à votre compte"));
            }
        } else {
            // Gérer le cas où l'ID de réservation n'est pas fourni
            http_response_code(400);
            echo json_encode(array("message" => "ID de réservation non spécifié."));
        }
    } else {
        // Gérer le cas où la méthode de la requête n'est pas POST
        http_response_code(405);
        echo json_encode(array("message" => "Méthode HTTP non autorisée."));
    }

}
?>
