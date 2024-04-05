<?php
session_start();

if(preg_match('/\/inscription\.php/', $_SERVER['REQUEST_URI'], $matches)) {
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        
        $serveur = "localhost"; // adresse du serveur MySQL
        $utilisateur = "root"; 
        $motDePasse = ""; 
        $baseDeDonnees = "palmhaven"; // nom de la base de données MySQL
        
        // Connexion à la base de données
        $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);
        
        // Vérifier la connexion
        if ($connexion->connect_error) {
            die(json_encode(['error' => 'Connexion échouée: ' . $connexion->connect_error]));
        }

        // Obtenir les données POST au format JSON
        $donneesJSON = file_get_contents("php://input");
        
        // Décoder les données JSON en tableau associatif
        $donnees = json_decode($donneesJSON, true);
        
        // récuperer les données Json
        $nom = $connexion->real_escape_string(trim($donnees['nom']));
        $prenom = $connexion->real_escape_string(trim($donnees['prenom']));
        $email = $connexion->real_escape_string(trim($donnees['email']));
        $motDePasse = $donnees['mot_de_passe'];

        // Vérifier si toutes les données sont présentes
        if(empty($nom) || empty($prenom) || empty($email) || empty($motDePasse)) {
            http_response_code(400);
            echo json_encode(['message' => 'Tous les champs du formulaire doivent être remplis.']);
            return;
        }

        // Vérifier si l'adresse email est déjà utilisée
        $requete = "SELECT * FROM utilisateurs WHERE email = '$email'";
        $resultat = $connexion->query($requete);
        
        if ($resultat->num_rows > 0) {
            echo json_encode(['message' => 'Oups ! Cette adresse email est déjà utilisée.']);
        } else {
            // Vérifier la validité du mot de passe
            if (strlen($motDePasse) < 8 || !preg_match('/[a-z]/', $motDePasse) || !preg_match('/[A-Z]/', $motDePasse) || !preg_match('/[0-9]/', $motDePasse) || !preg_match('/[^a-zA-Z0-9]/', $motDePasse))
            {
                echo json_encode(['message' => 'Le mot de passe doit contenir au moins 8 caractères, une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.']);
            } else {
                // Hasher le mot de passe
                $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
                
                // Insérer le nouvel utilisateur dans la base de données
                $requete = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES ('$nom','$prenom','$email', '$motDePasseHash')";
                
                // Si l'utilisateur est inséré dans la base de données
                if ($connexion->query($requete)) {
                    // Rediriger vers la page d'index dans le répertoire IntefaceWEB
                    echo json_encode(['succes' => 'true', 'message' => 'Création du compte réussie!']);

                } else {
                    echo json_encode(['message' => 'Erreur lors de l\'inscription : ' . $connexion->error]);
                }
            }
        }
    } else {
        echo json_encode(['message' => 'Méthode non autorisée']);
    }

    // Fermer la connexion
    $connexion->close();

} else {

    echo json_encode(['message' => 'Mauvais url.']);
}
?>
