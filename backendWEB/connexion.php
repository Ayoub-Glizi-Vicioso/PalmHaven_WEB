<?php

session_start(); // Démarrer la session

if(preg_match('/\/connexion\.php/', $_SERVER['REQUEST_URI'], $matches)) {
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        

        $serveur = "localhost"; // adresse du serveur MySQL
        $utilisateur = "root"; 
        $motDePasse = ""; 
        $baseDeDonnees = "palmhaven"; // nom de la base de données MySQL

        // Connexion à la base de données
        $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

        // Vérifier la connexion
        if ($connexion->connect_error) {
            die("Connexion échouée: " . $connexion->connect_error);
        } 


        // Obtenir les données POST au format JSON
        $donneesJSON = file_get_contents("php://input");
        
        // Décoder les données JSON en tableau associatif
        $donnees = json_decode($donneesJSON, true);
        
    
        $email = $connexion->real_escape_string(trim($donnees['email']));
        $motDePasse = $donnees['mot_de_passe'];
        


        // Requête SQL qui vérifie si l'email existe
        $requete = "SELECT * FROM utilisateurs WHERE email = '" .$email. "'";
        // Exécuter la requête 
        $resultat = $connexion->query($requete);
        if ($resultat->num_rows == 0) {
            // Utiliser JavaScript pour afficher une alerte
            echo "Oups! Aucun compte n\'est lié à cet email ! Veuillez vous inscrire ou réessayer.";
            }
        else 
        {
                // Récupérer l'ID utilisateur depuis la base de données
            $requete_id = "SELECT id_utilisateur FROM utilisateurs WHERE email = '" . $email . "'";
            $resultat_id = $connexion->query($requete_id);

            if ($resultat_id->num_rows > 0) {
                $utilisateur_id = $resultat_id->fetch_assoc(); // Récupérer l'ID utilisateur
                $_SESSION['id_utilisateur'] = $utilisateur_id['id_utilisateur']; // Stocker l'ID utilisateur dans la session
            } else {
                echo 'Erreur';
            }
            // Récupérer le mot de passe de l'utilisateur
            $requete = "SELECT mot_de_passe FROM utilisateurs WHERE email = '" . $email . "'";
            $resultat = $connexion->query($requete);

            // Vérifier si le mot de passe correspond
            if ($resultat) {
                $utilisateur = $resultat->fetch_assoc(); // Récupérer les informations de l'utilisateur
                //Si le mot de passe déhacté correspond
                if (password_verify($motDePasse, $utilisateur["mot_de_passe"])) 
                
                { //La session est créée et l'utilisateur est connecté
                    $_SESSION['email'] = $email;
                    
                    // Indiquer que l'utilisateur est connecté en JavaScript
                    
                    echo json_encode(array("succes"=>"Connexion réussie!"));

                   
                    // Rediriger vers la page d'accueil
                } else {
                    echo ('Mot de passe ou utilisateur invalide.');
                }
            } else {
                echo ('Erreur lors de la récupération du mot de passe.');
            }
        }

    } else {
        echo "<script> alert('methode non autorisé');</script>";
    }

        // Fermer la connexion
        $connexion->close();

} else {
// Gérer le cas où la méthode de la requête n'est pas DELETE
http_response_code(405);
echo json_encode(array("message" => "Méthode HTTP non autorisée."));
}


?>
