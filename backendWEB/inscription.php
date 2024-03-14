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

// Récupérer les données du formulaire
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
    $nom = $connexion->real_escape_string(trim($_POST['nom']));
    $prenom = $connexion->real_escape_string(trim($_POST['prenom']));
    $email = $connexion->real_escape_string(trim($_POST['email']));
    $motDePasse = $_POST['mot_de_passe'];

    // Vérifier si l'adresse email est déjà utilisée
    $requete = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $resultat = $connexion->query($requete);

    if ($resultat->num_rows > 0) {
        echo "<script> alert('Oups ! Cette adresse email est déjà utilisée.');</script>";
    } else {
        // Vérifier la validité du mot de passe
        if (strlen($motDePasse) < 8 || !preg_match('/[a-z]/', $motDePasse) || !preg_match('/[A-Z]/', $motDePasse) || !preg_match('/[0-9]/', $motDePasse) || !preg_match('/[^a-zA-Z0-9]/', $motDePasse))
        {
            echo "<script> alert('Le mot de passe doit contenir au moins 8 caractères, une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.')</script>";
        } else {
            // Hasher le mot de passe
            $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

            // Insérer le nouvel utilisateur dans la base de données
            $requete = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES ('$nom','$prenom','$email', '$motDePasseHash')";
            // Si l'utilisateur est inséré dans la base de données
            if ($connexion->query($requete) === TRUE) {
                // Rediriger vers la page d'index dans le répertoire IntefaceWEB
                echo "<script> alert('Création de compte réussie! Veuillez cliquer sur le bouton de retour à la page de connexion et vous connectez.');</script>";
            } else {
                echo "Erreur lors de l'inscription : " . $connexion->error;
            }
        }
    }
} else {
    echo "<script> alert('Veuillez remplir tous les champs du formulaire.');</script>";
}

// Fermer la connexion
$connexion->close();
?>
