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
}

?>
