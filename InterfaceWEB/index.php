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








?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/pourINDEX/styleINDEX.css">
    <style>
       
</style>
</head>
<body>


    <header class="section__container header__container">
        <div class="header__image__container">
          <div class="header__content">
            <h3 class="blanc">Hôtels et endroits où séjourner:</h3>
            <h4 class="blanc">Entrez des dates pour découvrir les meilleures offres disponibles.</h4>
          </div>
         
          <div class="booking__container">
            
          
          <form method="get" action="../backendWEB/AffichageChambre.php" class="search-form">
              
              <div class="form__group">
                <div class="input__group">
                  <input type="date" id="start_date" name="start_date" placeholder="entrer la date de début"> 
                  <label for="start_date" id="date_debut">Date de début réservation</label>
                </div>
            </div>
           
            
              <div class="form__group">
                 <div class="input__group">
                    <input type="date" id="end_date" name="end_date"> 
                     <label for="end_date" id=date_fin >Date de fin de réservation</label>
                 </div>
              </div>
        
       
              <input id="btn_rechercher" type="submit" value="Rechercher">
             
            </form>
            
          </div>


        </div>
      </header>


    <h1>Découvrez votre nouvelle hébergement</h1>

    <div class="container">
        <ul class="cards">
            <li class="card">
                <div>
                    <h2 class="card-title">Bienvenue sur le site de <strong><em><u>PALM HAVEN</u></em></strong></h2>
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
        <a href="politique.php" class="footer-item" target="_blank">Politique</a>
    </footer>

    <script src="../backendWEB/AffichageChambre.js"></script>
    

</body>
</html>
