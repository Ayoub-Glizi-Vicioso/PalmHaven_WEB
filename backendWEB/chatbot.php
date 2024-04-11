<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Vérifie si l'URL est conforme à ce que le chatbot attend
    if (preg_match('/\/chatbot\.php/', $_SERVER['REQUEST_URI'], $matches)) {
        // Assure-toi que l'option est présente dans l'URL
        if (isset($_GET['option'])) {
            $option = $_GET['option'];

            // Connexion à la base de données
            $serveur = "localhost";
            $utilisateur = "root";
            $motDePasse = "";
            $baseDeDonnees = "palmhaven";
            
            $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);
            
            // Vérifier la connexion
            if ($connexion->connect_error) {
                die("Connexion échouée: " . $connexion->connect_error);
            }
            
            // Construire la requête SQL pour sélectionner la réponse en fonction de l'option
            $requete = "SELECT Reponse FROM chatbot WHERE Question = ?";
            $statement = $connexion->prepare($requete);
            $statement->bind_param('s', $option);
            $statement->execute();
            $resultat = $statement->get_result();
            
            if ($resultat->num_rows > 0) {
                $reponse = $resultat->fetch_assoc()['Reponse'];
                
                // Si l'option est "réservation", renvoyer la réponse et les options supplémentaires
                if ($option == "Réservations") {
                    $optionsSupplementaires = [
                        "reponse" => $reponse,
                        "options" => [
                            "Comment annuler ou modifier ma réservation?",
                            "Comment savoir si ma réservation est confirmée?",
                            "Comment fonctionne le remboursement?"
                        ]
                    ];
                    echo json_encode($optionsSupplementaires);
                } else {
                    echo json_encode(["reponse" => $reponse]); // Renvoie la réponse sous forme de JSON
                }
            } else {
                echo json_encode(["erreur" => "Aucune réponse trouvée pour cette option."]);
            }

            $statement->close();
            $connexion->close();
        } else {
            // L'option n'est pas présente dans l'URL
            echo json_encode(["erreur" => "L'option est obligatoire."]);
        }
    } else {
        // L'URL ne correspond pas à ce qui est attendu
        http_response_code(404); 
        echo json_encode(['erreur' => 'URL non valide.', 'code' => 404]);
    }
} else {
    // Méthode non autorisée
    http_response_code(405); 
    echo json_encode(['erreur' => 'Méthode non autorisée.', 'code' => 405]);
}
?>
