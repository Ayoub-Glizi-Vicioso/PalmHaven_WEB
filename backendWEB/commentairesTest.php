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

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $requete = "SELECT avis.*, utilisateurs.prenom AS nom_utilisateur FROM avis INNER JOIN utilisateurs ON avis.id_utilisateur = utilisateurs.id_utilisateur";
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
            exit;
        } else {
            echo "Utilisateur non trouvé dans la base de données.";
        }

        // Fermeture du statement
        $statement_id_utilisateur->close();
    } else {
        // Gestion du cas où la méthode de requête n'est ni GET ni POST
        echo "Méthode de requête non autorisée";
    }

}
?>
