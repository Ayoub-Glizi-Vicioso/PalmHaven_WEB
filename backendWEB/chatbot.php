<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (preg_match('/\/chatbot\.php/', $_SERVER['REQUEST_URI'], $matches)) {
        if (isset($_GET['option'])) {
            $option = $_GET['option'];
            
            $serveur = "localhost";
            $utilisateur = "root";
            $motDePasse = "";
            $baseDeDonnees = "palmhaven";
            
            $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);
            
            if ($connexion->connect_error) {
                die("Connexion échouée: " . $connexion->connect_error);
            }
            
            $requete = "SELECT Reponse FROM chatbot WHERE Question = ?";
            $statement = $connexion->prepare($requete);
            $statement->bind_param('s', $option);
            $statement->execute();
            $resultat = $statement->get_result();
            
            if ($resultat->num_rows > 0) {
                $reponse = $resultat->fetch_assoc()['Reponse'];
                
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
                $requeteToutesOptions = "SELECT Question, Reponse FROM chatbot";
                $resultatToutesOptions = $connexion->query($requeteToutesOptions);
                
                $meilleureCorrespondance = "";
                $similiteMaximale = 0;
                
                while ($row = $resultatToutesOptions->fetch_assoc()) {
                    $optionBD = $row['Question'];
                    $reponse = $row['Reponse'];
                    
                    $similarity = similarity($option, $optionBD);
                    
                    if ($similarity > $similiteMaximale) {
                        $meilleureCorrespondance = $optionBD;
                        $similiteMaximale = $similarity;
                    }
                }
                
                if ($similiteMaximale >= 60) {
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
                    $requeteMotCle = "SELECT Reponse FROM chatbot WHERE Question LIKE ?";
                    $statementMotCle = $connexion->prepare($requeteMotCle);
                    $optionMotCle = '%' . $option . '%';
                    $statementMotCle->bind_param('s', $optionMotCle);
                    $statementMotCle->execute();
                    $resultatMotCle = $statementMotCle->get_result();

                    if ($resultatMotCle->num_rows == 1) {
                        $reponse = "";
                        while ($row = $resultatMotCle->fetch_assoc()) {
                            $reponse = $row['Reponse'];
                        }

                        echo json_encode(["reponse" => $reponse]);
                    } else {
                        $requeteMotCle = "SELECT Question, Reponse FROM chatbot";
                        $resultatMotCle = $connexion->query($requeteMotCle);

                        $meilleureCorrespondance = "";
                        $nombreMotsCommunsMax = 0;

                        while ($row = $resultatMotCle->fetch_assoc()) {
                            $questionBD = $row['Question'];
                            $reponse = $row['Reponse'];
                            
                            similar_text($option, $questionBD, $similarity);
                            $nombreMotsCommuns = $similarity;

                            if ($nombreMotsCommuns > $nombreMotsCommunsMax) {
                                $meilleureCorrespondance = $questionBD;
                                $nombreMotsCommunsMax = $nombreMotsCommuns;
                            }
                        }

                        if (!empty($meilleureCorrespondance) && $nombreMotsCommunsMax > 30) {
                            $requeteReponse = "SELECT Reponse FROM chatbot WHERE Question = ?";
                            $statementReponse = $connexion->prepare($requeteReponse);
                            $statementReponse->bind_param('s', $meilleureCorrespondance);
                            $statementReponse->execute();
                            $resultatReponse = $statementReponse->get_result();
                            
                            if ($resultatReponse->num_rows == 1) {
                                $reponse = $resultatReponse->fetch_assoc()['Reponse'];
                                
                                echo json_encode(["reponse" => $reponse]);
                            } else {
                                echo json_encode(["erreur" => "Aucune réponse trouvée pour cette option."]);
                            }
                        } else {
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
            echo json_encode(["erreur" => "L'option est obligatoire."]);
        }
    } else {
        http_response_code(404);
        echo json_encode(['erreur' => 'URL non valide.', 'code' => 404]);
    }
} else {
    http_response_code(405);
    echo json_encode(['erreur' => 'Méthode non autorisée.', 'code' => 405]);
}
?>
