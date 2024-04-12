<?php
session_start();
// Fonction pour calculer la similitude entre deux chaînes de caractères
function similarity($str1, $str2) {
    $len1 = strlen($str1);
    $len2 = strlen($str2);
    $maxLen = max($len1, $len2);
    $minLen = min($len1, $len2);
    
    // Si l'une des chaînes est vide, la similitude est de 0
    if ($minLen === 0) {
        return 0;
    }
    
    $commonChars = similar_text($str1, $str2);
    $similarity = ($commonChars * 2) / ($len1 + $len2);
    
    return $similarity * 100; // Convertir en pourcentage
}

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
                    // Aucune correspondance exacte trouvée, cherchons une correspondance proche
                    // Construire la requête SQL pour sélectionner toutes les options de la base de données
                    $requeteToutesOptions = "SELECT Question, Reponse FROM chatbot";
                    $resultatToutesOptions = $connexion->query($requeteToutesOptions);
                    
                    // Initialisation des variables pour stocker la meilleure correspondance
                    $meilleureCorrespondance = "";
                    $similiteMaximale = 0;
                    
                    // Parcourir les options de la base de données et rechercher la meilleure correspondance
                    while ($row = $resultatToutesOptions->fetch_assoc()) {
                        $optionBD = $row['Question'];
                        $reponse = $row['Reponse'];
                        
                        // Calculer la similitude entre l'option saisie par l'utilisateur et l'option de la base de données
                        $similarity = similarity($option, $optionBD);
                        // Mettre à jour la meilleure correspondance si la similitude est supérieure à la similitude maximale actuelle
                        if ($similarity > $similiteMaximale) {
                            $meilleureCorrespondance = $optionBD;
                            $similiteMaximale = $similarity;
                        }
                    }
                    
                   
                    
                    // Vérifier si la meilleure correspondance a une similitude suffisamment élevée (par exemple, 80%)
                    if ($similiteMaximale >= 60) {
                        // Récupérer la réponse associée à la meilleure correspondance dans la base de données
                        $requeteReponse = "SELECT Reponse FROM chatbot WHERE Question = ?";
                        $statementReponse = $connexion->prepare($requeteReponse);
                        $statementReponse->bind_param('s', $meilleureCorrespondance);
                        $statementReponse->execute();
                        $resultatReponse = $statementReponse->get_result();
                        
                        if ($resultatReponse->num_rows > 0) {
                            $reponse = $resultatReponse->fetch_assoc()['Reponse'];
                            
                            // Retourner la réponse
                            echo json_encode(["reponse" => $reponse]);
                        } else {
                            echo json_encode(["erreur" => "Aucune réponse trouvée pour cette option."]);
                        }
                    } else {
                       // Recherche de correspondance par mot-clé
                        $requeteMotCle = "SELECT Reponse FROM chatbot WHERE Question LIKE ?";
                        $statementMotCle = $connexion->prepare($requeteMotCle);
                        $optionMotCle = '%' . $option . '%';
                        $statementMotCle->bind_param('s', $optionMotCle);
                        $statementMotCle->execute();
                        $resultatMotCle = $statementMotCle->get_result();

                        if ($resultatMotCle->num_rows == 1) {
                            // Retourner la réponse
                            $reponse = "";
                            while ($row = $resultatMotCle->fetch_assoc()) {
                                $reponse = $row['Reponse'];
                            }

                           
                            echo json_encode(["reponse" => $reponse]);
                        } else {

                                // Recherche de correspondance par mot-clé
                            $requeteMotCle = "SELECT Question, Reponse FROM chatbot";
                            $resultatMotCle = $connexion->query($requeteMotCle);

                            $meilleureCorrespondance = ""; // Variable pour stocker la meilleure question correspondante
                            $nombreMotsCommunsMax = 0; // Variable pour stocker le nombre maximum de mots communs

                            // Parcourir les questions de la base de données pour trouver la meilleure correspondance
                            while ($row = $resultatMotCle->fetch_assoc()) {
                                $questionBD = $row['Question'];
                                $reponse = $row['Reponse'];
                                
                                // Compter le nombre de mots communs entre la question de l'utilisateur et la question de la base de données
                                similar_text($option, $questionBD, $similarity);
                                $nombreMotsCommuns = $similarity;

                                // Mettre à jour la meilleure correspondance si le nombre de mots communs est supérieur au maximum actuel
                                if ($nombreMotsCommuns > $nombreMotsCommunsMax) {
                                    $meilleureCorrespondance = $questionBD;
                                    $nombreMotsCommunsMax = $nombreMotsCommuns;
                                }
                            }

                            // Récupérer la réponse associée à la meilleure correspondance dans la base de données
                            if (!empty($meilleureCorrespondance) > 30) {
                                $requeteReponse = "SELECT Reponse FROM chatbot WHERE Question = ?";
                                $statementReponse = $connexion->prepare($requeteReponse);
                                $statementReponse->bind_param('s', $meilleureCorrespondance);
                                $statementReponse->execute();
                                $resultatReponse = $statementReponse->get_result();
                                
                                if ($resultatReponse->num_rows == 1) {
                                    $reponse = $resultatReponse->fetch_assoc()['Reponse'];
                                    
                                    // Retourner la réponse
                                    echo json_encode(["reponse" => $reponse]);
                                } else {
                                    echo json_encode(["erreur" => "Aucune réponse trouvée pour cette option."]);
                                }
                            } else {
                                // Aucune correspondance trouvée, retourner des suggestions
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
