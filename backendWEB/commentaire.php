<?php
/*Ce module contient ce qui se passe dans la page commentaire 
avec les méthodes, post, get et delete*/
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (preg_match('/\/commentaire\.php$/', $_SERVER['REQUEST_URI'], $matches)) {

        // Récupérer le titre
        $titre = $_POST['titre'];

        // Récupérer le message
        $message = $_POST['contenu'];

        // Récupérer le nom du client
        $prenom = $_SESSION['prenom'];

        // Récupérer la date actuelle
        $date = date("Y-m-d H:i:s");

        // Paramètres de connexion à la base de données
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "tch056_projet_integrateur";

        // Établir la connexion avec MySQLi
        $conn = new mysqli($hostname, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        }

        // Préparer la requête SQL (en utilisant des requêtes préparées pour éviter les injections SQL)
        $requete = $conn->prepare("INSERT INTO `messages`(`titre`, `contenu`, `auteur`, `date_publication`) VALUES (?, ?, ?, ?)");

        // Liaison des valeurs et exécution de la requête
        $requete->bind_param("ssss", $titre, $message, $prenom, $date);
        $requete->execute();

        // Redirection vers la page commentaire.html après l'insertion du message
        header("Location: ../commentairefront.php");
        exit(); // Terminer le script après la redirection
    }
}
?>
