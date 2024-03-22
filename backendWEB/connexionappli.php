<?php

session_start(); // Démarrer la session

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

// Créer un tableau pour stocker la réponse
$response = array();

// Vérifier si les données email sont présentes
if(isset($inputData['email'])) {
    $email = $inputData['email'];

    // Requête SQL qui vérifie si l'email existe
    $requete = "SELECT * FROM utilisateurs WHERE email = '" . $email . "'";
    // Exécuter la requête 
    $resultat = $connexion->query($requete);

    if ($resultat->num_rows == 0) {
        // Aucun compte n'est lié à cet email
        $response['success'] = false;
        $response['message'] = "Aucun compte n'est lié à cet email.";
    } else {
        // Récupérer le mot de passe de l'utilisateur
        $requete = "SELECT mot_de_passe FROM utilisateurs WHERE email = '" . $email . "'";
        $resultat = $connexion->query($requete);

        // Vérifier si le mot de passe correspond
        if ($resultat) {
            $utilisateur = $resultat->fetch_assoc(); // Récupérer les informations de l'utilisateur

            //Si le mot de passe déhaché correspond
            if (password_verify($inputData['mot_de_passe'], $utilisateur["mot_de_passe"])) {
                // La session est créée et l'utilisateur est connecté
                $_SESSION['email'] = $email;
                
                $response['success'] = true;
                $response['message'] = "Connexion réussie.";
            } else {
                $response['success'] = false;
                $response['message'] = "Mot de passe ou utilisateur invalide.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Erreur lors de la récupération du mot de passe.";
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "Aucune donnée email n'a été envoyée.";
}

// Fermer la connexion lorsque vous avez fini de travailler avec la base de données
$connexion->close();

// Envoyer la réponse JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
