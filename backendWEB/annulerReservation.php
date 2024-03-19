<?php
session_start();

if(isset($_POST['id_reservation'])){
    $identification_reservation = $_POST['id_reservation']; 
    $email_saisie = $_POST['email'];
    $email_session = $_SESSION['email'];
    
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
        // Requête SQL pour supprimer la réservation
        $sql = "DELETE FROM reservation WHERE numero_reservation = ' $identification_reservation'";
        
        if ($conn->query($sql) === TRUE) {
            
            header("Location: ../interfaceWEB/Profilmesreservtion.php?annulation_success=true");



        } else {
            echo "Erreur lors de l'annulation de la réservation : " . $conn->error;
        }
        // Fermer la connexion à la base de données
        $conn->close();
    }else{
        echo "Vous essayer de supprimer une reservation qui n'est pas associé à votre compte";
    }
} else {
    // Gérer le cas où l'ID de réservation n'est pas fourni
    echo "ID de réservation non spécifié.";
}
?>
