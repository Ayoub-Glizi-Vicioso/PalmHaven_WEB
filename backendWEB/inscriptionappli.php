<?php
// Démarre une nouvelle session
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

// Lire le flux d'entrée brut
$inputJSON = file_get_contents('php://input');

// Décoder les données JSON en tableau associatif
$inputData = json_decode($inputJSON, true);

// Vérifier si les données JSON contiennent les champs nécessaires
if(isset($inputData['nom']) && isset($inputData['prenom']) && isset($inputData['email']) && isset($inputData['mot_de_passe'])) {
    $nom = $connexion->real_escape_string(trim($inputData['nom']));
    $prenom = $connexion->real_escape_string(trim($inputData['prenom']));
    $email = $connexion->real_escape_string(trim($inputData['email']));
    $motDePasse = $inputData['mot_de_passe'];

    // Vérifier si l'adresse email est déjà utilisée
    $requete = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $resultat = $connexion->query($requete);
    
    if ($resultat->num_rows > 0) {
        echo json_encode(array("message" => "Oups ! Cette adresse email est déjà utilisée."));
    } else {
        // Vérifier la validité du mot de passe
        if (strlen($motDePasse) < 8 || !preg_match('/[a-z]/', $motDePasse) || !preg_match('/[A-Z]/', $motDePasse) || !preg_match('/[0-9]/', $motDePasse) || !preg_match('/[^a-zA-Z0-9]/', $motDePasse))
        {
            echo json_encode(array("message" => "Le mot de passe doit contenir au moins 8 caractères, une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial."));
        } else {
            // Hasher le mot de passe
            $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
            
            // Insérer le nouvel utilisateur dans la base de données
            $requete = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES ('$nom','$prenom','$email', '$motDePasseHash')";
            
            // Si l'utilisateur est inséré dans la base de données
            if ($connexion->query($requete)) {
                // Retourner un message de succès au format JSON
                echo json_encode(array("message" => "Inscription réussie."));
            } else {
                // Retourner un message d'erreur au format JSON
                echo json_encode(array("message" => "Erreur lors de l'inscription : " . $connexion->error));
            }
        }
    }
} else {
    // Retourner un message d'erreur si des champs sont manquants dans les données JSON
    echo json_encode(array("message" => "Veuillez remplir tous les champs du formulaire."));
}

// Fermer la connexion
$connexion->close();
?>
