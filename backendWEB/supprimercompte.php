<?php
session_start();

if (isset($_SESSION['email'], $_POST['email'], $_POST['mot_de_passe'])) {
    $email_session = $_SESSION['email'];
    $email_a_supprimer = $_POST['email'];
    $motDePasse = $_POST['mot_de_passe'];

    // Vérifier si l'email de la session correspond à l'email à supprimer
    if ($email_session === $email_a_supprimer) {
        // Connexion à la base de données
        $serveur = "localhost"; // adresse du serveur MySQL
        $utilisateur = "root"; 
        $motDePasse = ""; 
        $baseDeDonnees = "palmhaven"; // nom de la base de données MySQL

        $conn = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        // Préparer et exécuter la requête de suppression
        $sql = "DELETE FROM utilisateurs WHERE email = ? AND mot_de_passe = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email_a_supprimer, $motDePasse);

        if ($stmt->execute()) {
            echo "<p>L'utilisateur a été supprimé avec succès.</p>";
        } else {
            echo "<p>Erreur lors de la suppression de l'utilisateur : " . $stmt->error . "</p>";
        }

        // Fermer la connexion à la base de données
        $stmt->close();
        $conn->close();
    } else {
        echo "Erreur : Les informations d'identification ne correspondent pas à l'utilisateur connecté.";
    }
} else {
    echo "Erreur : L'utilisateur n'est pas connecté ou les données nécessaires ne sont pas fournies.";
}
?>
