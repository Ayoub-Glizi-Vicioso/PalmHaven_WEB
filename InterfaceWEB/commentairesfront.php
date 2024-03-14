<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'GET') {
        require '../backendWEB/commentaire.php';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <title>Témoignages HTML</title>
    <!-- Feuille de style -->
    <link rel="stylesheet" href="css/style.css"/>
    <!-- Icône favorite -->
    <link rel="shortcut icon" href="images/fav-icon.png"/>
    <!-- Police Poppins -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>
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
        #temoignages {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width:100%;
        }
        .entete-temoignages {
            letter-spacing: 1px;
            margin: 30px 0px;
            padding: 10px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .entete-temoignages h1 {
            font-size: 2.2rem;
            font-weight: 500;
            background-color: #202020;
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
                padding: 10px;
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
    </style>
</head>
<body>
    <!-- Témoignages -->
    <section id="temoignages">
        <!-- Entête -->
        <div class="entete-temoignages">
            <span>Commentaires</span>
            <h1>Avis des Clients</h1>
            <h2>Laissez nous un avis !</h2>
            <form id="commentaire" action="../backendWEB/commentaire.php" method="post">
    <label for="titre">Titre du message</label>
    <input id="titre" name="titre" type="text" required> <!-- Utilisation d'un champ de texte simple pour le titre -->

    <label for="contenu">Contenu</label>
    <textarea id="contenu" name="contenu" rows="8" required></textarea> <!-- Utilisation d'une zone de texte pour le contenu avec 8 lignes de hauteur -->
    
    <button type="submit">Envoyer</button>
</form>
            
                <label for="etoiles">Niveau d'étoiles</label>
                <div id="etoiles">
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
            
                <button class="bouton" id="publier" type="submit">Publier</button>
                <button class="bouton" type="reset">Effacer</button>
            </form>
            
        </div>
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
                        <!-- Photo de profil -->
                        <div class="photo-profil">
                            <img src="images/c-1.jpg" />
                        </div>
                        <!-- Nom et pseudo -->
                        <div class="nom-utilisateur">
                            <strong>Touseeq Ijaz</strong>
                        </div>
                    </div>
                    <!-- Avis -->
                    <div class="avis">
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
    <script src="../backendWEB/commentaire.js"></script>
</body>
</html>
