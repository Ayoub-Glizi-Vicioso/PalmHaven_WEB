<!--Cette page est la page d'acceuil. Elle s'appelle index.html, car c'est elle qui doit être ouvert par 
défaut dans le système du serveur.-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        .navbar {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            background-color: darkgrey;
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
            background-color: darkgray;
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
            background-color: #6d597a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-form input[type="submit"]:hover {
            background-color: #b56576;
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
            align-items: center; /* Aligner les éléments sur l'axe vertical */
            margin: 0 auto; /* Centrer horizontalement les chambres */
            padding: 20px; /* Ajouter un espacement autour des chambres */
            padding-left: 10px;
            padding-right: 10px;
            width: 100%;
            
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
            color: var(--darkblue);
        }

        #photo{
            background-image: url(./images/hotel.jpeg);
            background-size: cover; 
            background-repeat: no-repeat; 
            height: auto;
            width: 100%;
            background-position: center;

        }

        .blanc{
            color: black;

        }

        #swipe{
            text-align: center;
            color: #6d597a;
            font-weight: bold;
            font-size: large;
            margin-top: -40px;
            margin-bottom: 20px;
            font-style: italic;

        }

        
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="pageAccueil.html" target="_SELF" class="navbar-brand">
            <img src="images/home.png" alt="page d'accueil">Reservation
        </a>
        <ul class="navbar-nav">
            <li class="nav-item"><a href="Aide.html" class="nav-link">Aide</a></li>
            <li class="nav-item"><a href="connexionfront.php" class="nav-link">Connexion</a></li>
        </ul>
    </nav>

    <h1>Découvrer votre nouvelle hébergement</h1>

    <div class="container">
        <ul class="cards">
            <li class="card">
                <div>
                    <h2 class="card-title">Bienvenue sur le site d'<strong><em><u>Hotel Reservation</u></em></strong></h2>
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
    <h3 class="blanc">Hôtels et endroits où séjourner:</h3>
    <h4 class="blanc">Entrez des dates pour découvrir les meilleures offres disponibles.</h4>
        <div id="photo">
            <br>
            <br><br><br><br>
            <div method="get" class="container-form">
                <form class="search-form">
                    <label for="start_date">Date de début réservation</label>
                    <input type="date" id="start_date" name="start_date" placeholder="entrer la date de début">
                    <label for="end_date">Date de fin de réservation</label>
                    <input type="date" id="end_date" name="end_date">
                    <input type="submit" value="Rechercher">
                 </form>
                 <br>
                 <br><br><br><br>
        </div>
    </div>

    <br>
    <hr>

    
    <h4>Chambre disponible</h4>
        
    <div class="affichage-annonce">
        <div class="chambre">
            <div class="image-container"></div>
            <div class="content">
            </div>
        </div>
    </div>


    <footer>
        <a href="Aide.html" class="footer-item" >Aide</a>
        <a href="#revue" class="footer-item">Review</a>
        <a href="politique.html" class="footer-item" target="_blank">Politique</a>
    </footer>

        <script src="../backendWEB/AffichageChambre.js"></script>
    
</body>
</html>
