<?php

session_start();


if(isset($_POST['id_reservation'])){
    $identification_reservation = $_POST['id_reservation']; 
    $email_saisie = $_POST['email'];
    $email_session = $_SESSION['email'];
    
    $date_debut = $_POST['nouv_debut'];
    $date_fin = $_POST['nouv_fin'];

    echo $date_debut;
    echo '<br>';
    echo $date_fin;
    echo '<br>';
    
    
    $serveur = "localhost"; 
    $utilisateur = "root"; 
    $code = ""; 
    $baseDeDonnees = "palmhaven"; 
    
    // Connexion à la base de données
    $conn = new mysqli($serveur, $utilisateur, $code, $baseDeDonnees);
    if ($conn->connect_error) {
        echo ('Erreur de connexion à la base de données : ' . $conn->connect_error  );
        die();
    }
    
    if($email_saisie  == $email_session){

        


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
         WHERE (r.numero_chambre = '$id_chambre' AND
             ((('$date_debut' BETWEEN r.date_debut AND r.date_fin) OR
             ('$date_fin' BETWEEN r.date_debut AND r.date_fin) OR
             (r.date_debut BETWEEN '$date_debut' AND '$date_fin') OR
             (r.date_fin BETWEEN '$date_debut' AND '$date_fin'))) AND
             r.numero_reservation != '$identification_reservation')
         GROUP BY c.numero";
 
 
 
         $stmt_check_disponibilite = $conn->prepare($sql_check_disponibilite);
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
        

                echo "La réservation a été modifiée avec succès.";
                header("Location: ../interfaceWEB/Profilmesreservtion.php?modif_success=true");
            } else {
                echo "Une erreur est survenue lors de la modification de la réservation.";
            }

            $stmt_update_reservation->close();
        } else {
            echo "La chambre n'est pas disponible pour les dates sélectionnées.";
        }
        
       
    }else{
        echo "Vous essayer de supprimer une reservation qui n'est pas associé à votre compte";
    }
} else {
    // Gérer le cas où l'ID de réservation n'est pas fourni
    echo "ID de réservation non spécifié.";
}
