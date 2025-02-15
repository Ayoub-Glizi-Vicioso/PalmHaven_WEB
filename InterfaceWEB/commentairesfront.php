<?php

    session_start();
    
    // Vérifie si l'utilisateur est connecté
    if(isset($_SESSION['email'])) {
        // Utilisateur connecté : inclure la barre de navigation pour les utilisateurs connectés
        include 'nav_connected.php';
    } else {
        // Utilisateur non connecté : inclure la barre de navigation pour les utilisateurs non connectés
        include 'nav_not_connected.php';
    }

    // Vérifier si le paramètre de suppression réussie est présent dans l'URL
if (isset($_GET['commentaire_env']) && $_GET['commentaire_env'] === 'false') {
    echo "<script>alert('Vous devez vous connecter avant de publier un commentaire');</script>";
}

    // if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'GET') {
    //     require '../backendWEB/commentairesTest.php';
    // }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <title>Témoignages HTML</title>
    <!-- Feuille de style -->
    <!-- Icône favorite -->
    <link rel="shortcut icon" href="images/fav-icon.png"/>
    <!-- Police Poppins -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script> </script> 
    
    <link rel="stylesheet" href="css/pourCOMMENTAIRE/styleCOMMENTAIRE.css">
</head>
<body>


    <!-- Témoignages -->
    <section id="temoignages">
        <div class="ligne-horizontale"></div>
        <!-- Entête -->
        <div class="entete-temoignages">
            <span>Commentaires</span>
            <h1>Avis des Clients</h1>
            <br>
            <br>
            <h2>Laissez nous un avis !</h2>
        
            
    
        <form id="commentaire" action="../backendWEB/commentairesTest.php" method="post">
            <hr>
            <br>
            <div id = "etoiles">
                <input type="radio" id="etoile1" name="etoile" value="1">
                <label for="etoile1">1 étoile</label>
                <input type="radio" id="etoile2" name="etoile" value="2">
                <label for="etoile2">2 étoiles</label>
                <input type="radio" id="etoile3" name="etoile" value="3">
                <label for="etoile3">3 étoiles</label>
                <input type="radio" id="etoile4" name="etoile" value="4">
                <label for="etoile4">4 étoiles</label>
                <input type="radio" id="etoile5" name="etoile" value="5">
                <label for="etoile5">5 étoiles</label>
            </div>
            <br>
            <label for="titre">Titre du message</label>
            <input id="titre" name="titre" type="text" required placeholder = "Exemple: Mon merveilleux séjour..." maxlength="100"> <!-- Utilisation d'un champ de texte simple pour le titre -->
            <br>
            <label for="contenu">Contenu</label>
            <textarea id="contenu" name="contenu" rows="8" required placeholder="Entrer le contenu ici" maxlength="400"></textarea> <!-- Utilisation d'une zone de texte pour le contenu avec 8 lignes de hauteur -->

           

            <button type="reset" id="effacer">Effacer</button>
            <button type="submit" id="publier">Envoyer</button>
            
        </form>
        <br>
        
        
            

        
        <!-- Conteneur des boîtes de témoignages -->
        <div class="conteneur-boites-temoignages">
            <!-- Boîte de témoignage 1 -->
            
            <!-- Ajouter les autres boîtes de témoignage ici -->
        </div>
    </section>

    <div class="affichage-annonce">

    </div>
    <footer>
        <a href="Aide.php" class="footer-item" >Aide</a>
        <a href="commentairesfront.php" class="footer-item">Review</a>
        <a href="politique.php" class="footer-item" target="_blank">Politique</a>
    </footer>
<script src="../backendWEB/commentairesTest.js"></script>
</body>
</html>
