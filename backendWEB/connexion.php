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

// Requête SQL qui vérifie si l'email existe
$requete = "SELECT * FROM utilisateurs WHERE email = '" . $_POST['email'] . "'";
// Exécuter la requête 
$resultat = $connexion->query($requete);
if ($resultat->num_rows == 0) {
    // Utiliser JavaScript pour afficher une alerte
    echo "<script>alert('Oups! Aucun compte n\'est lié à cet email ! Veuillez vous inscrire ou réessayer.')</script>";
    }
else 
{
        // Récupérer l'ID utilisateur depuis la base de données
    $requete_id = "SELECT id_utilisateur FROM utilisateurs WHERE email = '" . $_POST['email'] . "'";
    $resultat_id = $connexion->query($requete_id);

    if ($resultat_id->num_rows > 0) {
        $utilisateur_id = $resultat_id->fetch_assoc(); // Récupérer l'ID utilisateur
        $_SESSION['id_utilisateur'] = $utilisateur_id['id_utilisateur']; // Stocker l'ID utilisateur dans la session
    } else {
        echo "<script> alert('Erreur')</script>";
    }
    // Récupérer le mot de passe de l'utilisateur
    $requete = "SELECT mot_de_passe FROM utilisateurs WHERE email = '" . $_POST['email'] . "'";
    $resultat = $connexion->query($requete);

    // Vérifier si le mot de passe correspond
    if ($resultat) {
        $utilisateur = $resultat->fetch_assoc(); // Récupérer les informations de l'utilisateur
        //Si le mot de passe déhacté correspond
        if (password_verify($_POST['mot_de_passe'], $utilisateur["mot_de_passe"])) 
        
        { //La session est créée et l'utilisateur est connecté
            $_SESSION['email'] = $_POST['email'];
            
            // Indiquer que l'utilisateur est connecté en JavaScript
            
            
            echo "<script> alert('Connexion réussie!')</>";
            header('Location: index.php'); 
            // Rediriger vers la page d'accueil
        } else {
            echo "<script> alert('Mot de passe ou utilisateur invalide.')</script>";
        }
    } else {
        echo "<script> alert('Erreur lors de la récupération du mot de passe.')</script>";
    }
}

// Fermer la connexion lorsque vous avez fini de travailler avec la base de données
$connexion->close();


