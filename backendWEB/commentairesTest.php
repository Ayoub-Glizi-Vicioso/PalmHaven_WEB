<?php
session_start();

if (preg_match('/\/commentairesTest\.php/', $_SERVER['REQUEST_URI'], $matches)) {
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

    // Gestion des requêtes HTTP
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Requête pour récupérer les avis des utilisateurs depuis la base de données
        $requete = "SELECT avis.*, utilisateurs.prenom AS nom_utilisateur, utilisateurs.email AS email FROM avis JOIN utilisateurs ON avis.id_utilisateur = utilisateurs.id_utilisateur";
        $resultat = $connexion->query($requete);

        // Vérifie s'il y a des résultats
        if ($resultat->num_rows > 0) {
            $avis = [];
            // Boucle à travers les résultats et les stocke dans un tableau
            while ($row = $resultat->fetch_assoc()) {
                $row['emailSession'] = $_SESSION['email'];  // Ajoute l'e-mail de session à chaque ligne d'avis
                $avis[] = $row;
            }
            echo json_encode($avis);    // Convertit le tableau en format JSON et l'affiche
        } else {
            echo json_encode(array()); // Envoie une réponse JSON vide s'il n'y a pas d'avis
        }

    // Traitement des requêtes POST pour ajouter de nouveaux avis
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Récupération de l'adresse e-mail depuis la session
        $email_utilisateur = $_SESSION['email'];

        // Préparation de la requête pour récupérer l'ID de l'utilisateur
        $requete_id_utilisateur = "SELECT id_utilisateur FROM utilisateurs WHERE email = ?";

        $statement_id_utilisateur = $connexion->prepare($requete_id_utilisateur);
        // Liaison des paramètres
        $statement_id_utilisateur->bind_param("s", $email_utilisateur);
        // Exécution de la requête
        $statement_id_utilisateur->execute();
        // Récupération du résultat
        $resultat_id_utilisateur = $statement_id_utilisateur->get_result();

        // Vérification si l'utilisateur existe dans la base de données
        if ($resultat_id_utilisateur->num_rows > 0) {
            // Récupération de l'ID de l'utilisateur
            $row = $resultat_id_utilisateur->fetch_assoc();
            $id_utilisateur = $row['id_utilisateur'];

            // Récupération des données du formulaire
            $titre = $_POST['titre']; // Assurez-vous de remplacer 'titre' par le nom exact du champ dans votre formulaire
            $contenu = $_POST['contenu']; // Assurez-vous de remplacer 'contenu' par le nom exact du champ dans votre formulaire
            $etoiles = $_POST['etoile']; // Assurez-vous de remplacer 'etoiles' par le nom exact du champ dans votre formulaire
            $date_systeme = date('Y-m-d H:i:s'); // Date et heure actuelles

            // Insertion des données dans la base de données
            $requete_insertion = "INSERT INTO avis (id_utilisateur, Titre, Contenu, Etoiles, Date_Systeme) VALUES (?, ?, ?, ?, ?)";
            $statement_insertion = $connexion->prepare($requete_insertion);
            // Liaison des paramètres
            $statement_insertion->bind_param("issss", $id_utilisateur, $titre, $contenu, $etoiles, $date_systeme);
            // Exécution de la requête
            $statement_insertion->execute();
            // Fermeture du statement
            $statement_insertion->close();

            // Fermeture de la connexion
            $connexion->close();

            header("Location: ../interfaceWEB/commentairesfront.php");
            exit;
        } else {
            echo "Utilisateur non trouvé dans la base de données.";
            header("Location: ../interfaceWEB/commentairesfront.php?commentaire_env=false");
        }

        // Fermeture du statement
        $statement_id_utilisateur->close();
    }
    
    // Traitement des requêtes DELETE pour supprimer des avis
    elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

        // Récupération des données DELETE
        $donneesJSON = file_get_contents("php://input");
    
        // Décodage des données JSON
        $donnees = json_decode($donneesJSON, true);
    
        // Vérification si les données contiennent l'ID du commentaire à supprimer
        if (isset($donnees['id'])) {
            $idCommentaire = $donnees['id'];
    
            // Requête SQL pour supprimer le commentaire
            $requete = "DELETE FROM avis WHERE id_message = ".$idCommentaire;
    
            // Exécuter la requête
            $resultat = $connexion->query($requete);
    
            if ($resultat) {
                // La suppression a réussi
                http_response_code(200);
                echo json_encode(array("message" => "Commentaire supprimé avec succès."));
            } else {
                // La suppression a échoué
                http_response_code(500);
                echo json_encode(array("message" => "Erreur lors de la suppression du commentaire."));
            }
        } else {
            // Si l'ID du commentaire n'est pas fourni dans les données DELETE
            http_response_code(400);
            echo json_encode(array("message" => "ID du commentaire non fourni."));
        }
    }
        
    else{
        // Gestion du cas où la méthode de requête n'est ni GET ni POST
        echo "Méthode de requête non autorisée";
    }

}
?>
