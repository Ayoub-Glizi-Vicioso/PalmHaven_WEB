<?php

    session_start();
    // Vérifie si l'utilisateur est connecté
    if(isset($_SESSION['email'])) {
        // Utilisateur connecté : inclure la barre de navigation pour les utilisateurs connectés
        include 'nav_connected.php';
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'GET') {
        require '../backendWEB/commentairesTest.php';
    }

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
    
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        * {
            margin: 0px;
            padding: 0px;
            font-family: "Montserrat";
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
        }
        
        /* #temoignages {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width:100%;
        } */

        .ligne-horizontale {
            border-top: 1px solid #ccc; /* Couleur et épaisseur de la ligne */
            margin-top: 20px; /* Marge en haut de la ligne */
        }
        .entete-temoignages {
            letter-spacing: 1px;
            margin: 30px 0px;
            padding: 10px 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center; 
        }
        .entete-temoignages h1 {
            font-size: 2.2rem;
            font-weight: 500;
            background-color: #16b0c4;
            color: #ffffff;
            padding: 10px 20px;
        }
        .entete-temoignages h2 {
            font-size: 1.6rem;
            font-weight: 400;
            color: #3d3d3d;
            margin-bottom: 20px;
        }
        .entete-temoignages span {
            font-size: 1.3rem;
            color: #252525;
            margin-bottom: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .conteneur-boites-temoignages {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            width:100%;
        }
        .boite-temoignage {
            width:500px;
            height:250px;
            box-shadow: 2px 2px 30px rgba(0,0,0,0.1);
            background-color: #ffffff;
            padding: 20px;
            margin: 15px;
            cursor: pointer;
            position: relative; /* Ajout de la position relative pour positionner la date */
        }
        .photo-profil {
            width:50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }
        .photo-profil img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .profil {
            display: flex;
            align-items: center;
        }
        .nom-utilisateur {
            display: flex;
            flex-direction: column;
        }
        .nom-utilisateur strong {
            color: #3d3d3d;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }
        .nom-utilisateur span {
            color: #979797;
            font-size: 0.8rem;
        }
        .avis {
            color: #f9d71c;
        }
        .date {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.8rem;
            color: #979797;
        }
        .boite-temoignage:hover {
            transform: translateY(-10px);
            transition: all ease 0.3s;
        }
        @media(max-width:1060px) {
            .boite-temoignage {
                width:45%;
                padding: 5px;
            }
        }
        @media(max-width:790px) {
            .boite-temoignage {
                width:100%;
            }
            .entete-temoignages h1 {
                font-size: 1.4rem;
            }
        }
        @media(max-width:340px) {
            .box-top {
                flex-wrap: wrap;
                margin-bottom: 10px;
            }
            .avis {
                margin-top: 10px;
            }
        }
        ::selection {
            color: #ffffff;
            background-color: #252525;
        }

        nav {
            max-width: var(--max-width);
            height: 20px;
            margin:auto;
            padding: 2rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: white;
        }

        .nav_logo img {
            width: 140px;
            margin-right: 10px;
        }

        .nav__links{
            list-style: none;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .link{
            margin-right: 20px;
        }
        .link a{
            font-weight: 500;
            color: rgba(152, 150, 150, 0.932);
            transition:  0.3;
        }

        .link a:hover{
            color: (--primary-color);
        }
        .entete-temoignages {
            text-align: center;
            margin-bottom: 30px;
        }
        #commentaire {
        display: flex;
        flex-direction: column;
        }

        #commentaire label {
            margin-bottom: 10px;
            text-align: left;
        }

        #commentaire textarea {
            resize: vertical;
        }
        #commentaire label span {
        font-size: 0.8rem;
        color: #777;
        margin-left: 5px;
        }

        #etoiles {
            text-align: center;
            margin-bottom: 10px;
        }

        #publier{
            width: 150px; /* Largeur du bouton */
            height: 50px; /* Hauteur du bouton */
            margin-top: 20px; /* Marge en haut */
            margin-left: 1px; /* Marge à gauche */
            background-color: #16b0c4;
        }
        #publier:hover{
            background-color: lightskyblue; /* Couleur de fond au survol */
            color: white;
        }

        #effacer {
        margin-left: auto;
        

        }
        #effacer:hover{
            background-color: grey;

    }
    footer {
        background-color: #16b0c4;
        color: var(--white);
        padding: 20px 0;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
    }
    footer a {
            color: var(--white);
<<<<<<< Updated upstream
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
    }
    .footer-item:hover {
            color: blue;
    }
    .affichage-annonce {
        border: 1px solid black;
        background-color: #16b0c4;
        height: 90%; 
        width: 100%; 
        display: flex; 
        flex-direction: column; 
        flex-wrap: wrap; 
    }


=======
            padding: 20px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        footer a {
                color: var(--white);
                text-decoration: none;
                font-weight: bold;
                margin: 0 10px;
        }
        .footer-item:hover {
                color: blue;
        }
        .affichage-annonce {
            border: 1px solid black;
            background-color: #16b0c4;
            height: 90%; 
            width: 100%; 
            display: flex; 
            flex-direction: column; 
            flex-wrap: wrap; 
        }
        
    </style>
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
            <div class="boite-temoignage">
                <!-- Date -->
                <div class="date">2024-03-16 10:45:20</div>
                <!-- En-tête -->
                <div class="entete-boite-temoignage">
                    <!-- Profil -->
                    <div class="profil">
                        <!-- Nom et pseudo -->
                        <div class="nom-utilisateur">
                            <strong>Touseeq Ijaz</strong>
                        </div>
                    </div>
                    <!-- Avis -->
                    <div class="avis">
                        <h2 class ="titre">Titre</h2>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i><!-- Etoile vide -->
                    </div>
                </div>
                <!-- Commentaires -->
                <div class="commentaire-client">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat quis? Provident temporibus architecto asperiores nobis maiores nisi a. Quae doloribus ipsum aliquam tenetur voluptates incidunt blanditiis sed atque cumque.</p>
                </div>
            </div>
            <!-- Ajouter les autres boîtes de témoignage ici -->
        </div>
    </section>

    <div class="affichage-annonce">

    </div>
    <footer>
        <a href="Aide.html" class="footer-item" >Aide</a>
        <a href="commentairesfront.php" class="footer-item">Review</a>
        <a href="politique.html" class="footer-item" target="_blank">Politique</a>
    </footer>
<script src="../backendWEB/commentairesTest.js"></script>
</body>
</html>
