<?php
session_start();

if(preg_match('/\/supprimercompte\.php/', $_SERVER['REQUEST_URI'], $matches)) {
    if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        if (isset($_SESSION['email'], $_GET['email'], $_GET['mot_de_passe'])) {
            $email_session = $_SESSION['email'];
            $id_utilisateur = $_SESSION['id_utilisateur'];
            $email_a_supprimer = $_GET['email'];
            $motDePasse = $_GET['mot_de_passe'];

            // Vérifier si l'email de la session correspond à l'email à supprimer
            if ($email_session === $email_a_supprimer) {
                $serveur = "localhost"; 
                $utilisateur = "root"; 
                $code = ""; 
                $baseDeDonnees = "palmhaven"; 
                
                $conn = new mysqli($serveur, $utilisateur, $code, $baseDeDonnees);
                if ($conn->connect_error) {
                    echo json_encode(['message' => 'Erreur de connexion à la base de données : ' . $conn->connect_error]);
                    die();
                }
                
                // Requête SQL pour récupérer le mot de passe haché de l'utilisateur
                $sql = "SELECT mot_de_passe FROM utilisateurs WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email_a_supprimer);
                $stmt->execute();
                $result = $stmt->get_result();
                
                // Vérifier si l'utilisateur existe
                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    $motDePasseHacheDansLaBase = $row['mot_de_passe'];
                    
                    // Vérifier si le mot de passe fourni correspond au hachage enregistré
                    if (password_verify($motDePasse, $motDePasseHacheDansLaBase)) {
                        // Supprimer d'abord les avis associés à l'utilisateur
                        $sql_suppression_avis = "DELETE FROM avis WHERE id_utilisateur = ?";
                        $stmt_suppression_avis = $conn->prepare($sql_suppression_avis);
                        $stmt_suppression_avis->bind_param("i", $id_utilisateur);
                        $stmt_suppression_avis->execute();
                        $stmt_suppression_avis->close();
                        
                        // Supprimer les réservations de l'utilisateur
                        $requeteSuppressionReservations = "DELETE FROM reservation WHERE id_utilisateur = ?";
                        $stmt_suppression_reservations = $conn->prepare($requeteSuppressionReservations);
                        $stmt_suppression_reservations->bind_param("i", $id_utilisateur);
                        $stmt_suppression_reservations->execute();
                        $stmt_suppression_reservations->close();
                        
                        // Ensuite, supprimer l'utilisateur
                        $sql_suppression_utilisateur = "DELETE FROM utilisateurs WHERE id_utilisateur = ?";
                        $stmt_suppression_utilisateur = $conn->prepare($sql_suppression_utilisateur);
                        $stmt_suppression_utilisateur->bind_param("i", $id_utilisateur);
                        
                        if ($stmt_suppression_utilisateur->execute()) {
                            // Détruisez toutes les variables de session
                            session_unset();
                            echo json_encode(["succes" => 'true', 'message' => 'Suppression de compte réussie.']);
                            exit();
                        } else {
                            echo json_encode(['message' => 'Erreur lors de la suppression de l\'utilisateur : ' . $stmt_suppression_utilisateur->error ]);
                        }
                        $stmt_suppression_utilisateur->close();
                    } else {
                        echo json_encode(['message' => 'Le mot de passe fourni est incorrect.']);
                    }
                } else {
                    echo json_encode(['message' => 'Erreur : L\'utilisateur n\'existe pas.']);
                }

                // Fermer les déclarations et la connexion à la base de données
                $stmt->close();
                $conn->close();
            } else {
                echo json_encode(['message' => 'Erreur : Les informations d\'identification ne correspondent pas à l\'utilisateur connecté.']);
            }
        } else {
            echo json_encode(['message' => 'Erreur : L\'utilisateur n\'est pas connecté ou les données nécessaires ne sont pas fournies.']);
        }
    } else {
         // Gérer le cas où la méthode de la requête n'est pas DELETE
         http_response_code(405);
         echo json_encode(['message' => 'Méthode HTTP non autorisée.']);
    }
}
?>
