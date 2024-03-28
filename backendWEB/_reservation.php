<?php
session_start(); // Démarrer la session
// Vérifier si le formulaire a été soumis



if(isset($_SESSION['email'])){
   
    if(preg_match('/\/_reservation\.php/', $_SERVER['REQUEST_URI'], $matches)) {
        // Vérifier si la requête est une requête POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Récupérer le contenu de la requête
            $data = file_get_contents('php://input');
            
            // Vérifier si des données ont été envoyées
            if (!empty($data)) {
                // Analyser les données JSON en tableau associatif
                $formData = json_decode($data, true);

                // Vérifier si le numéro de chambre est présent dans les données
                if (isset($formData['numero_chambre'])) {
                    // Récupérer le numéro de chambre
                    $numero_chambre = $formData['numero_chambre'];
                    
                    // Faire quelque chose avec le numéro de chambre (par exemple, l'insérer dans la base de données)
                    //echo  "Numéro de chambre reçu : " . $numero_chambre;
                } else {
                    // Le numéro de chambre n'a pas été envoyé
                    //echo "Le numéro de chambre n'a pas été spécifié.";
                }
            } else {
                // Aucune donnée n'a été envoyée
                //echo "Aucune donnée n'a été envoyée.";
            }
            
            $start_date = $_SESSION['date_debut'];
            $end_date = $_SESSION["date_fin"];
          

            // accès à la base de données
            $serveur = "localhost"; 
            $utilisateur = "root"; 
            $motDePasse = ""; 
            $baseDeDonnees = "palmhaven"; // nom de la base de données MySQL
            
            // Connexion à la base de données
            $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);
            
            // Vérifier la connexion
            if ($connexion->connect_error) {
                die("Connexion échouée: " . $connexion->connect_error);
            } 
            
            $email =  $_SESSION['email'];
            
            
            //obtenir le id_utilisateur
            $sql_user = "SELECT id_utilisateur FROM utilisateurs WHERE email = ?";
            $stmt_user = $connexion->prepare($sql_user);
            $stmt_user->bind_param("s", $email);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $row_user = $result_user->fetch_assoc();
            $id_utilisateur = $row_user['id_utilisateur'];


            
            /// Exécution de la requête SELECT
$sql_check_reservation = "SELECT numero_reservation FROM reservation WHERE id_utilisateur = $id_utilisateur AND numero_chambre = $numero_chambre AND date_debut = '$start_date' AND date_fin = '$end_date'";
$result_check_reservation = $connexion->query($sql_check_reservation);

            
            // Vérifier si une réservation existe déjà
            if ($result_check_reservation->num_rows > 0) {
                // Afficher un message à l'utilisateur
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "Vous avez déjà réservé cette chambre pour cette période."]);
            } else {
                // Si aucune réservation n'existe, procéder à l'insertion de la nouvelle réservation
                
                $sql_insert_reservation = "INSERT INTO reservation (numero_chambre, date_debut, date_fin, id_utilisateur) VALUES ('$numero_chambre', '$start_date', '$end_date', $id_utilisateur)";
                
                if ($connexion->query($sql_insert_reservation) === TRUE) {
                    // si l'exécution réussit, redirigez l'utilisateur vers la page de succès
                    // Renvoyer une réponse JSON indiquant le succès de la réservation
                    
                    http_response_code(200);
                    echo json_encode(["success" => true, "message" => "Réservation réussie.  "]);
                
                    exit(); // Assurez-vous de quitter après la redirection
                } else {
                    // en cas d'erreur, affichez le message d'erreur
                    http_response_code(500);
                    echo json_encode(["success" => false, "message" => "Erreur lors de la réservation."]);
                    
                }
            }
            
            
            // Fermer la connexion
            $connexion->close();
           
            
        } else {
            http_response_code(405); 
            echo json_encode(["success" => false, "message" => "La méthode de requête n'est pas autorisée pour cette action."]);
        }
    }
    
} else {
    echo json_encode(array("success" => false, "message" => "Vous devez être connecté pour effectuer une réservation."));
}
?>
