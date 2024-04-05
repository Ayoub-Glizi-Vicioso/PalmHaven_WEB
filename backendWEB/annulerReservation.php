<?php
session_start();

if(preg_match('/\/annulerReservation\.php/', $_SERVER['REQUEST_URI'], $matches)) {
    if($_SERVER['REQUEST_METHOD'] == 'DELETE') {

        // Vérification si les données contiennent l'ID de réservation
        if(isset($_GET['id_reservation']) && isset($_GET['email']) ) {
            //obtenir les données de l'url 
            $id_reservation = $_GET['id_reservation'];
            $email= $_GET['email'];
            $email_session = $_SESSION['email'];

            // si l'email saisit et le même que l'email de session
            if($email == $email_session){

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
                $sql = "DELETE FROM reservation WHERE numero_reservation = " .$id_reservation ;
                    // supprime les données d'une réservation

                if($conn->query($sql)) {
                    // Redirection vers la page de profil après l'annulation de la réservation
                    echo json_encode(array("message" => "La réservation a été annuler avec succès."));
                    exit;
                } else {
                    echo "Erreur lors de l'annulation de la réservation : " . $conn->error;
                }
            }else{
                echo json_encode(array("message" => "Erreur, vous essayer de suppprimer un reservation qui n'est pas à votre nom."));
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
} else {

    echo json_encode(['message' => 'Mauvais url.']);
}
?>
