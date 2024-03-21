<!--Cette page est la page d'acceuil. Elle s'appelle index.html, car c'est elle qui doit être ouvert par 
défaut dans le système du serveur.-->

<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if(isset($_SESSION['email'])) {
    // Utilisateur connecté : inclure la barre de navigation pour les utilisateurs connectés
    include 'nav_connected.php';
} else {
    // Utilisateur non connecté : inclure la barre de navigation pour les utilisateurs non connectés
    include 'nav_not_connected.php';
}



// Vérifier si le paramètre de suppression réussie est présent dans l'URL
if (isset($_GET['delete_success']) && $_GET['delete_success'] === 'true') {
    echo "<script>alert('Votre compte a été supprimé avec succès.');</script>";
}

// Vérifier si le paramètre de connexion réussie est présent dans l'URL
if (isset($_GET['conn_success']) && $_GET['conn_success'] === 'true') {
    echo "<script>alert('Bienvenu!');</script>";
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        
        @media only screen and (max-width: 768px) {
            body {
                font-size: 14px; /* Réduire la taille de la police pour les écrans plus petits */
            }

            .container {
                max-width: 90%; /* Réduire la largeur de la conteneur pour mieux s'adapter aux petits écrans */
            }

            .nav__links {
                flex-direction: column; /* Réorganiser les liens de navigation en colonne pour les écrans plus petits */
            }

            .booking__container,
            .search-form {
                display: grid; /* Utiliser CSS Grid */
                grid-template-columns: 1fr; /* Une seule colonne */
                justify-items: center; /* Centrer horizontalement */
                width: 70%; /* Exemple de modification de la largeur */
            }

            .annonce,
            .chambre {
                display: flex;
                flex-direction: column; /* Modification de la direction des éléments pour être verticale */
            }

            .form__group {
                margin-bottom: 10px; /* Ajouter de l'espace entre les groupes de champs */
            }

            .input__group {
                display: flex;
                flex-direction: column; /* Aligner les éléments verticalement */
                align-items: flex-start; /* Aligner les éléments à gauche */
            }

            .search-form input[type="date"],
            .search-form input[type="submit"] {
                width: 100%; /* Faire en sorte que les éléments occupent toute la largeur disponible */
                padding: 10px; /* Ajouter du remplissage pour un meilleur aspect */
                margin-bottom: 10px; /* Ajouter de l'espace entre les champs */
            }

            /* Style des étiquettes */
            .search-form label {
                font-size: smaller; /* Réduire la taille de la police */
                margin-bottom: 5px; /* Ajouter de l'espace en bas des étiquettes */
            }
        }




        :root {
            --blue: #6d597a;
            --darkblue: #6d597a;
            --platinum: #e5e5e5;
            --black: #000000;
            --white: #ffffff;
            --thumb: #edf2f4;
        }

        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: "Montserrat";
            letter-spacing: .2rem;
        }

        body {
            font: 16px / 24px "Rubik", sans-serif;
            color: var(--black);
            background: var(--platinum);
            margin: 0;
            padding-top: 50px;
            background-color: white;
            height: 200vh;
            
        }

        /* .navbar {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #16b0c4;
            color: var(--white);
            display: flex;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }

        .navbar img{
            width: 100%;
        }

        .navbar-brand {
            margin-right: auto;
            color: var(--white);
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }

        .navbar-brand img {
            width: 30px;
            margin-right: 10px;
        }

        .navbar-nav {
            display: flex;
            list-style: none;
        }

        .nav-item {
            margin-right: 20px;
        }

        .nav-link {
            color: var(--white);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--darkblue);
        } */

        nav {
            max-width: var(--max-width);
            height: 2%;
            margin:auto;
            padding: 2rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: white;
        }

        /* .nav__logo{
            font-size: 1.5rem;
            font-weight: 60;
            color: var(--text-dark);

        } */
        .nav_logo img {
            width: 150px;
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

        .container {
            max-width: 1400px;
            padding: 0 15px;
            margin: 0 auto;
        }

        h1 {
            font-size: 28px;
            margin: 1em;
            color: var(--blue);
            padding: 10px;
        }

        .cards {
            display: flex;
            padding: 25px 0px;
            list-style: none;
            overflow-x: scroll;
            overflow-y: hidden;
        }

        .card {
            display: flex;
            flex-direction: column;
            flex: 0 0 100%;
            padding: 20px;
            border-bottom: 1px solid var(--black);
            margin-bottom: 20px;
            position: relative;
            
        }

        .card-title {
            color: var(--blue);
            font-size: 24px;
            margin-bottom: 10px;
        }

        .card-content {
            color: var(--black);
        }

        .card-link-wrapper {
            margin-top: 20px;
        }

        .card-link {
            color: var(--blue);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .card-link:hover {
            color: var(--darkblue);
        }

        .card:not(:last-child)::after {
            content: "→";
            position: absolute;
            top: 60%;
            right: 100px;
            transform: translateY(-50%);
            font-size: 24px;
            color: var(--blue);
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

        .search-form {
            max-width: 90%;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: -3px 1px 15px 18px rgba(0,0,0,0.1),0px 10px 15px -3px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center; 
        }


        .search-form label {
            flex: 1; 
            margin-right: 8px; 
            text-align: right; 
            font-size: smaller;
        }

        .search-form input[type="date"] {
            flex: 2; 
            padding: 8px;
            margin-right: 8px; 
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-form input[type="submit"] {
            flex: 1; 
            padding: 10px;
            margin-left: 8px; 
            background-color: #16b0c4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-form input[type="submit"]:hover {
            background-color: #b56576;
        }


        .search-form input[type="date_fin"]{
            border:


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

        h3{
            padding: 15px;
            margin: 5px;
            text-align: center;
            font-style: italic;
        }

        h4{
            margin-bottom: 15px;
            text-align: center;
            font-style: italic;
            font-size: small;

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

        /* #photo{
            background-image: url(./images/hotel_profil.jpeg);
            background-size: cover; 
            background-repeat: no-repeat; 
            height: auto;
            width: 100%;
            background-position: center;

        } */

        .blanc{
            color: black;

        }

        #swipe{
            text-align: center;
            color: #0d7d8c;
            font-weight: bold;
            font-size: large;
            margin-top: -40px;
            margin-bottom: 20px;
            font-style: italic;

        }
        
        .card-body {
            padding: 1rem; /* Add padding to the card body */
            display: flex; /* Utiliser Flexbox pour aligner les éléments verticalement */
            flex-direction: column; /* Aligner les éléments verticalement */
            justify-content: center; /* Aligner les éléments verticalement au centre */
            align-items: center;
            
        }
        .card {
            border: none;
            display: flex; /* Utiliser Flexbox pour aligner les éléments */
            justify-content: center; /* Centrer horizontalement */
            align-items: center; /* Centrer verticalement */
            text-align: center; /* Centrer le texte horizontalement */
            
         /* Ajoutez de la marge à gauche */
         /* Ajoutez de la marge à droite */
        }

        .img-chambre {
            max-width: 100%; /* Make sure the image doesn't overflow */
            height: auto;
            
        }
        .card:not(:last-child)::after {
        content: none; /* Supprimer la flèche à droite */
        }

        .btn-primary {
            background-color: #0d7d8c;
            border-color: #0d7d8c;
        }

        .btn-primary:hover {
            background-color: lightslategrey; 
            border-color: lightslategrey; 
        }


        .header__container {
             padding: 1rem 1rem 5rem 1rem;
        }

        .header__image__container {
        position: relative;
        min-height: 500px;
        background-image: linear-gradient(
            to right,
            rgba(83, 108, 123, 0.4),
            rgba(235, 238, 245, 0.1)
            ),
            url("./images/hotel_profil.jpeg");
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        border-radius: 2rem;
        }

        .header__content {
        max-width: 600px;
        padding: 5rem 2rem;
        
        }
 
        .header__content h3, .header__content h4 {
        color: white; /* Changement de la couleur du texte en blanc */
        }

        .booking__container {
        position: absolute;
        bottom: -5rem;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 6rem);
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 3rem 2rem;
        border-radius: 2rem;
        background-color: rgba(255, 255, 255, 0.7);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.1);
        }

        .booking__container form {
        width: 100%;
        flex: 1;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        }

        .booking__container .input__group {
        width: 100%;
        position: relative;
        }

        .booking__container label {
            position: absolute;
            top: 0; /* Positionner le label au-dessus du champ d'entrée */
            left: 0;
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--text-dark);
            pointer-events: none;
            transition: 0.3s;
            transform: translateY(-100%);
        }

        .booking__container input {
        width: 100%;
        padding: 10px 0;
        font-size: 1rem;
        outline: none;
        border: none;
        background-color: transparent;
        border-bottom: 1px solid var(--primary-color);
        color: var(--text-dark);
        
        }

        .booking__container input:focus ~ label {
        font-size: 0.8rem;
        top: 0;
        }

        .booking__container .form__group p {
        margin-top: 0.5rem;
        font-size: 0.8rem;
        color: var(--text-light);
        }

        .booking__container .btn {
        padding: 1rem;
        outline: none;
        border: none;
        font-size: 1.5rem;
        color: var(--white);
        background-color: var(--primary-color);
        border-radius: 100%;
        cursor: pointer;
        transition: 0.3s;
        }

        .booking__container .btn:hover {
        background-color: var(--primary-color-dark);
        }

        #date_fin, #date_debut{
            font-size: 0.7rem;
            text-align: center;

        }


        /* Style de la section d'affichage des annonces */
        .affichage-annonce {
            border: 1px solid black; /* Bordure de 1px solide noire */
            background-color: lightgray; /* Fond de couleur gris clair */
            padding: 10px; /* Espacement intérieur de 10px */
            border-radius: 5px; /* Coins arrondis de 5px */
            display: grid; /* Utilisation de la grille pour organiser les éléments */
            grid-template-columns: repeat(auto-fill, 100%); /* Colonnes de largeur minimale de 250px et flexible */
            gap: 10px; /* Espacement de 10px entre les éléments */
        }

        /* Style des éléments de chambre */
        .chambre {
            display: flex; /* Utiliser flexbox pour aligner les éléments horizontalement */
            margin: 0 auto; /* Centrer horizontalement les chambres */
            padding: 10px; /* Ajouter un espacement autour des chambres */
            padding-left: 10px;
            padding-right: 10px;
            width: 100%;
            background-color: white;
            border: 1px solid lightgray;
            
        }

        /* Style du conteneur d'image */
        .image-container {
            margin-right: 20px; /* Espacement entre l'image et le texte */
            flex-shrink: 0; /* Empêcher le rétrécissement du conteneur d'image */
            margin-left: 50px;
            margin-right: 50px;
            width: 35%;
        }

       


        .content {
            flex: 1; /* Le contenu occupe tout l'espace restant */
            display: flex;
            flex-direction: column;
            margin-left: 10px;
            margin-right: 10px;
            width: 65%;
        }


        /* Style du titre de la chambre */
        .chambre h5 {
            margin: 10px; /* Suppression des marges par défaut */
        }

        /* Style du paragraphe de la chambre */
        .chambre .content p {
            text-align: center;
            padding: 5px 10px;
            font-size: 16px;
        }

        /* Style du lien "Plus d'options" */
        .chambre a {
            display: block; /* Affichage en bloc pour occuper toute la largeur */
            text-align: center; /* Centrage du texte */
            background-color: #007bff; /* Fond de couleur bleue */
            color: white; /* Texte de couleur blanche */
            padding: 5px 10px; /* Remplissage de 5px en haut/bas et 10px à gauche/droite */
            border-radius: 5px; /* Coins arrondis de 5px */
            text-decoration: none; /* Suppression du soulignement du lien */
            margin-top: 10px; /* Marge supérieure de 10px */
        }



        /* Style du lien "Plus d'options" au survol */
        .chambre a:hover {
            background-color: #0056b3; /* Fond de couleur plus foncée au survol */
        }

        

        .image-container img {
            width: 100%; /* Faire en sorte que l'image prenne 100% de la largeur disponible */
            height: auto; /* Ajuster automatiquement la hauteur pour maintenir les proportions de l'image */
            align-items: center;
        }

</style>
</head>
<body>
    <!-- <nav class="navbar">
        <a href="pageAccueil.html" target="_SELF" class="navbar-brand">
            <img src="images/home.png" alt="page d'accueil">Reservation
        </a>
        <ul class="navbar-nav">
            <li class="nav-item"><a href="Aide.html" class="nav-link">Aide</a></li>
            <li class="nav-item"><a href="connexionfront.php" class="nav-link">Connexion</a></li>
        </ul>
    </nav> -->




    <header class="section__container header__container">
        <div class="header__image__container">
          <div class="header__content">
            <h3 class="blanc">Hôtels et endroits où séjourner:</h3>
            <h4 class="blanc">Entrez des dates pour découvrir les meilleures offres disponibles.</h4>
          </div>
          <div class="booking__container">
            
          

          
          <form  method="get" class="search-form">
              
              <div class="form__group">
                <div class="input__group">
                  <input type="date" id="start_date" name="start_date" placeholder="entrer la date de début"> 
                  <label for="start_date" id="date_debut">Date de début réservation</label>
                </div>
            </div>
            <br><br>
            
              <div class="form__group">
                <div class="input__group">
                    <input type="date" id="end_date" name="end_date"> 
                     <label for="end_date" id=date_fin >Date de fin de réservation</label>
                </div>
              </div>
             
              <input type="submit" value="Rechercher">
            </form>
            




          </div>
        </div>
      </header>


    <h1>Découvrez votre nouvelle hébergement</h1>

    <div class="container">
        <ul class="cards">
            <li class="card">
                <div>
                    <h2 class="card-title">Bienvenue sur le site de<strong><em><u> PALM HAVEN</u></em></strong></h2>
                    <div class="card-content">
                        <p>Bienvenue sur notre site de réservation d'hôtels !
                            Nous sommes ravis de vous accueillir dans notre univers 
                            dédié au voyage et à l'hospitalité. Forts d'une expertise approfondie dans le domaine du voyage et de l'hospitalité, nous nous efforçons de vous offrir un service exceptionnel et personnalisé. Notre objectif est de vous fournir les meilleurs hébergements adaptés à vos besoins, que ce soit pour un voyage d'affaires, des vacances en famille ou une escapade romantique. Avec notre engagement envers l'excellence et notre attention aux détails, nous sommes là pour rendre chaque étape de votre voyage aussi fluide et agréable que possible. </p>
                    </div>
                </div>
            </li>
            <li class="card">
                <div>
                    <h2 class="card-title">Reservation</h2>
                    <div class="card-content">
                        <p>Que vous recherchiez un hôtel de luxe pour une escapade romantique, une chambre d'hôtes pittoresque pour une immersion locale, ou un appartement moderne pour un séjour en famille, nous avons tout ce qu'il vous faut. Explorez nos options de réservation et découvrez des hébergements confortables,</p>
                    </div>
                </div>
            </li>
            <li class="card">
                <div>
                    <h2 class="card-title">Créer un compte ou connecter vous!</h2>
                    <div class="card-content">
                        <p>Créez un compte dès maintenant et bénéficiez d'avantages exclusifs ! 
                            En vous inscrivant, vous pourrez profiter d'une expérience de réservation 
                            personnalisée, avec la possibilité de sauvegarder vos préférences et consulter 
                            l'historique de vos réservations. De plus, en vous connectant, vous simplifiez 
                            le processus de réservation en accédant rapidement à vos informations et en 
                            évitant de saisir à nouveau vos coordonnées à chaque fois que vous réservez. </p>
                    </div>
                </div>
                <div class="card-link-wrapper">
                    <a href="inscriptionfront.php" class="card-link">Créer un compte ici!</a>
                </div>
                <div class="card-link-wrapper">
                    <a href="connexionfront.php" class="card-link">Connecter vous ici!</a>
                </div>
            </li>
            <li class="card">
                <div>
                    <h2 class="card-title">Besoin d'Aide</h2>
                    <div class="card-content">
                        <p>Besoin d'aide pour finaliser votre réservation ? Notre équipe est là 
                            pour vous guider à chaque étape du processus. Que vous ayez des 
                            questions sur les disponibilités, les tarifs, les conditions 
                            d'annulation ou tout autre sujet lié à votre séjour, nous sommes 
                            là pour vous fournir les réponses dont vous avez besoin. Consultez 
                            notre foire aux questions pour trouver des réponses aux questions 
                            fréquemment posées, ou contactez notre service clientèle dédié pour 
                            une assistance personnalisée.</p>
                    </div>
                    <div class="card-link-wrapper">
                        <a href="" class="card-link">AJOUTER UN EMAIL .... et liens vers la page FAQ</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div id="swipe">
        Balayer!
    </div>
    <br>
    <hr>
    
        <!-- <div id="photo">
            <br>
            <br><br><br><br>
            <div class="container-form">
                <form action="../backendWEB/AffichageChambre.php" method="post" class="search-form">
                    <label for="start_date">Date de début réservation</label>
                    <input type="date" id="start_date" name="start_date" placeholder="entrer la date de début">
                    <label for="end_date">Date de fin de réservation</label>
                    <input type="date" id="end_date" name="end_date">
                    <input type="submit" value="Rechercher">
                 
                </form>
                 <br>
                 <br><br><br><br>
        </div> -->
    </div>

    <br>
    <hr>

    

    <div class="card mb-3 " style="max-width: 100%;border-top: none;">
        <div class="row g-0">
          <div class="col-md-6">
            <img src="./images/bungalow/Suite_Bungalow.png" class="img-chambre" alt="suite-bungalow">
          </div>
          <div class="col-md-5">
            <div class="card-body">
              <h5 class="card-title">Suite Bungalow</h5>
              <p class="card-text">Nous mettons à votre disposition 1 Suite en Bungalow, l'option la plus confortable pour vous et votre famille. La Suite Bungalow est idéale pour votre repos et votre détente, dans un environnement naturel très spécial. Vous aurez l'impression d'être au paradis ! *Occupation maximale : 4 personnes (3 adultes + 1 enfant ou 2 adultes + 2 enfants ou 1 adulte + 2 enfants) *Enfants 3-12 ans (tous deux inclus)</p>
              <a href="#" class="btn btn-primary">Plus d'options</a>
            </div>
          </div>
        </div>
    </div>

    <div class="card mb-3" style="max-width: 100%;">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="card-body">
                    <h5 class="card-title">Suite Club Familiale</h5>
                    <p class="card-text">Chambres familiales de 53 m2 conçues pour garantir aux adultes et aux enfants des vacances vraiment spéciales. Nous disposons d'une Suite Club Familiale équipée d'un lit double et de trois lits simples superposés, avec tous les avantages exclusifs d'être situées dans l'espace privé Palm Haven. *Occupation maximale : 5 personnes (3 adultes + 2 enfants ou 2 adultes + 3 enfants ou 1 adulte + 4 enfants) *Enfants 3-12 ans (tous deux inclus)</p>
                    <a href="#" class="btn btn-primary">Plus d'options</a>
                </div>
            </div>
            <div class="col-md-6">
                <img src="./images/familiale/Club_Familiale_Suite.png" class="img-chambre" alt="Image d'une suite familiale"> 
            </div>
        </div>
    </div>
    <div class="card mb-3 " style="max-width: 100%;border-top: none;">
        <div class="row g-0">
          <div class="col-md-6">
            <img src="./images/lunedemiel/Lune_de_miel_Suite.png" class="img-chambre" alt="suite-bungalow">
          </div>
          <div class="col-md-5">
            <div class="card-body">
              <h5 class="card-title">Suite Lune de Miel</h5>
              <p class="card-text">Si vous êtes un couple qui préfère des vacances plus paisibles et romantiques, notre Suite lune de miel offre un bain à remous et une ambiance parfaite. Profitez des services et avantages exclusifs inclus dans cette suite pour les jeunes mariés et aussi pour les couples qui souhaitent partager une expérience romantique. Adultes seulement (+18). *Occupation maximale : 2 adultes *Séjour minimum 4 nuits</p>
              <a href="#" class="btn btn-primary">Plus d'options</a>
            </div>
          </div>
        </div>
    </div>

    <!-- <div class="card mb-3" style="max-width: 100%;">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="card-body">
                    <h5 class="card-title">Suite Club Familiale Swimout</h5>
                    <p class="card-text">Savourez le luxe de plonger directement dans la piscine depuis votre terrasse. Nous disposons de 41 Junior Suites Family Club avec un lit double et des lits superposés, offrant aux clients l'accès à tous les services, privilèges et espaces privés réservés aux clients du Family Club. *Occupation maximale : 5 personnes (3 adultes + 2 enfants ou 2 adultes + 3 enfants ou 1 adulte + 4 enfants) *Enfants 3-12 ans (tous deux inclus)</p>
                    <a href="#" class="btn btn-primary">Plus d'options</a>
                </div>
            </div>
            <div class="col-md-6">
                <img src="./images/Club_Familiale.png" class="img-chambre" alt="Image d'une suite familiale avec piscine">
            </div>
        </div>
    </div> -->
    
    <h4>Chambre disponible</h4>

    <div class="affichage-annonce">
        <div class="chambre">
            <div class="image-container"></div>
            <div class="content">
            </div>
        </div>
    </div>

    </div>
    <footer>
        <a href="Aide.html" class="footer-item" >Aide</a>
        <a href="commentairesfront.php" class="footer-item">Review</a>
        <a href="politique.html" class="footer-item" target="_blank">Politique</a>
    </footer>

    <script src="../backendWEB/AffichageChambre.js"></script>
    

</body>
</html>
