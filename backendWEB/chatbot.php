<?php
session_start();

// Fonction pour calculer la similarité entre deux chaînes de caractères
function similarity($str1, $str2) {
    $len1 = strlen($str1);
    $len2 = strlen($str2);
    $maxLen = max($len1, $len2);
    $minLen = min($len1, $len2);
    
    if ($minLen === 0) {
        return 0;
    }
    
    $commonChars = similar_text($str1, $str2);
    $similarity = ($commonChars * 2) / ($len1 + $len2);
    
    return $similarity * 100;
}

// Vérifier si la méthode HTTP est GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       // Vérifier si l'URL correspond à chatbot.php
    if (preg_match('/\/chatbot\.php/', $_SERVER['REQUEST_URI'], $matches)) {
        // Vérifier si l'option est définie dans les paramètres de la requête
        if (isset($_GET['option'])) {
            $option = $_GET['option'];
            
            // Connexion à la base de données
            $serveur = "localhost";
            $utilisateur = "root";
            $motDePasse = "";
            $baseDeDonnees = "palmhaven";
            
            $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);
            
            // Vérifier la connexion à la base de données
            if ($connexion->connect_error) {
                die("Connexion échouée: " . $connexion->connect_error);
            }
            
            // Préparer et exécuter la requête SQL pour récupérer la réponse du chatbot
            $requete = "SELECT Reponse FROM chatbot WHERE Question = ?";
            $statement = $connexion->prepare($requete);
            $statement->bind_param('s', $option);
            $statement->execute();
            $resultat = $statement->get_result();
            
             // Si une réponse est trouvée dans la base de données
            if ($resultat->num_rows > 0) {
                $reponse = $resultat->fetch_assoc()['Reponse'];

                 // Générer des options supplémentaires basées sur l'option sélectionnée
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
                } else if ($option == "Politique") {
                    $optionsSupplementaire = [
                        "reponse" => $reponse,
                        "options" => [
                            "Enregistrement",
                            "Annulation",
                            "Enfants",
                            "Paiement",
                            "Animaux"
                        ]
                    ];
                    echo json_encode($optionsSupplementaire);
                } else {
                    echo json_encode(["reponse" => $reponse]);
                }
            } else {
                // Si aucune réponse directe n'est trouvée, rechercher une correspondance partielle
                $requeteToutesOptions = "SELECT Question, Reponse FROM chatbot";
                $resultatToutesOptions = $connexion->query($requeteToutesOptions);
                
                $meilleureCorrespondance = "";
                $similiteMaximale = 0;
                
                  // Parcourir toutes les options pour trouver la meilleure correspondance
                while ($row = $resultatToutesOptions->fetch_assoc()) {
                    $optionBD = $row['Question'];
                    $reponse = $row['Reponse'];
                    
                    $similarity = similarity($option, $optionBD);
                    
                    if ($similarity > $similiteMaximale) {
                        $meilleureCorrespondance = $optionBD;
                        $similiteMaximale = $similarity;
                    }
                }
                
                 // Si la similarité est supérieure à 50%, récupérer la réponse associée
                if ($similiteMaximale >= 50) {
           
                    $requeteReponse = "SELECT Reponse FROM chatbot WHERE Question = ?";
                    $statementReponse = $connexion->prepare($requeteReponse);
                    $statementReponse->bind_param('s', $meilleureCorrespondance);
                    $statementReponse->execute();
                    $resultatReponse = $statementReponse->get_result();
                    
                    if ($resultatReponse->num_rows > 0) {
                        $reponse = $resultatReponse->fetch_assoc()['Reponse'];
                        
                        echo json_encode(["reponse" => $reponse]);
                    } else {
                        echo json_encode(["erreur" => "Aucune réponse trouvée pour cette option."]);
                    }
                } else {
                     // Si aucune correspondance directe ou partielle n'est trouvée, rechercher par mots-clés
                    $requeteMotCle = "SELECT Reponse FROM chatbot WHERE Question LIKE ?";
                    $statementMotCle = $connexion->prepare($requeteMotCle);
                    $optionMotCle = '%' . $option . '%';
                    $statementMotCle->bind_param('s', $optionMotCle);
                    $statementMotCle->execute();
                    $resultatMotCle = $statementMotCle->get_result();

                     // Si une seule réponse correspondante est trouvée, la renvoyer
                    if ($resultatMotCle->num_rows == 1) {
                        $reponse = "";
                        while ($row = $resultatMotCle->fetch_assoc()) {
                            $reponse = $row['Reponse'];
                        }

                        echo json_encode(["reponse" => $reponse]);
                    } else {
                        
                        // Récupérer les mots saisis par l'utilisateur et les stocker dans un tableau
                        $motsUtilisateur = explode(' ', $option);


                        $reponsesPotentielles ;

                        // Parcourir chaque mot saisi par l'utilisateur
                        foreach ($motsUtilisateur as $mot) {
                            // Construire la requête SQL dynamique avec LIKE %mot%
                            $requeteMotCle = "SELECT Question, Reponse FROM chatbot WHERE Question LIKE ?";
                            $statement = $connexion->prepare($requeteMotCle);
                            $parametre = "%$mot%";
                            $statement->bind_param('s', $parametre);
                            $statement->execute();
                            $resultat = $statement->get_result();

                            // Parcourir les résultats de la requête et ajouter les réponses potentielles au tableau
                            while ($row = $resultat->fetch_assoc()) {
                                $reponsesPotentielles = $row['Reponse'];
                            }
                        }

                        // Si une reponse potentielle a été trouvée,la renvoyer
                        if (!empty($reponsesPotentielles)) {
                            echo json_encode(["reponse" => $reponsesPotentielles]);
                        } else {
                             // Si aucune correspondance n'est trouvée, renvoyer des suggestions de questions communes
                            $optionsSupplementaires = [
                                "reponse" => "Je suis désolé, je n'ai pas compris votre demande. Voici quelques questions communes :",
                                "options" => [
                                    "Comment annuler ou modifier ma réservation?",
                                    "Comment savoir si ma réservation est confirmée?",
                                    "Comment fonctionne le remboursement?"
                                ]
                            ];
                            echo json_encode($optionsSupplementaires);
                        }
                    }
                }
            }

            $statement->close();
            $connexion->close();
        } else {
            // Si l'option n'est pas définie dans les paramètres de la requête, renvoyer une erreur
            echo json_encode(["erreur" => "L'option est obligatoire."]);
        }
    } else {
        // Si l'URL n'est pas valide, renvoyer une erreur 404
        http_response_code(404);
        echo json_encode(['erreur' => 'URL non valide.', 'code' => 404]);
    }
} else {
      // Si la méthode HTTP n'est pas autorisée, renvoyer une erreur 405
    http_response_code(405);
    echo json_encode(['erreur' => 'Méthode non autorisée.', 'code' => 405]);
}
?>
