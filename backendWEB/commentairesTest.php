<?php

session_start();

if(preg_match('/\/commentairesTest\.php/', $_SERVER['REQUEST_URI'], $matches)){
    $serveur = "localhost"; 
    $utilisateur = "root"; 
    $motDePasse = ""; 
    $baseDeDonnees = "palmhaven"; // Nom de la base de données MySQL
        
    // Connexion à la base de données
    $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);
        
    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Connexion échouée: " . $connexion->connect_error);
    }
        
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $requete = "SELECT avis.*, utilisateurs.prenom AS nom_utilisateur 
                FROM avis 
                INNER JOIN utilisateurs 
                ON avis.id_utilisateur = utilisateurs.id_utilisateur";
        $resultat = $connexion->query($requete);
        
        if ($resultat->num_rows > 0) {
            $avis = [];
            while ($row = $resultat->fetch_assoc()) {
                $avis[] = $row;
            }
            echo json_encode($avis);
        } else {
            echo json_encode(array()); // Envoyer une réponse JSON vide
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['id_utilisateur'])) {
            // Récupérer l'ID de l'utilisateur depuis la session
            $id_utilisateur = $_SESSION['id_utilisateur'];
            // Récupérer le titre et le contenu du commentaire depuis le formulaire
            $titre = $_POST['titre'];
            $contenu = $_POST['contenu'];

            // Récupérer la valeur de l'étoile choisie
            $etoile = isset($_POST['etoile']) ? $_POST['etoile'] : null;

            // Insérer le nouvel avis dans la base de données
            $requete = "INSERT INTO avis (Contenu, Etoiles, id_utilisateur, Titre) VALUES ('$contenu', '$etoile', '$id_utilisateur', '$titre')";
            $resultat = $connexion->query($requete);
            if ($resultat) {
                echo json_encode(['message' => 'Avis ajouté avec succès']);
            } else {
                echo json_encode(['erreur' => 'Erreur lors de l\'ajout de l\'avis']);
            }
        } else {
            // Si l'utilisateur n'est pas connecté, renvoyer une erreur
            echo json_encode(['erreur' => 'Vous devez être connecté pour laisser un avis']);
        }
    }
}

?>
