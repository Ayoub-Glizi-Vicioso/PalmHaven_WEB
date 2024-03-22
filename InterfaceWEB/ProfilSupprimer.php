<?php

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    require '../backendWEB/supprimercompte.php';
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/pourSUPPRIMER/styleSPPRIMER.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div id="Barre_nav">
            <!--<img src="./images/profil.JPG" ></a>--> 
            <button onclick="window.location.href='Profilmesreservtion.php'" id="btn_reservations">Mes réservations</button>
            
            
            <button id="btn_effacer_compte">Supprimer mon compte</button>

            <form action="../backendWEB/deconnexion.php">
                <button  id="btn_decon">Deconnexion</button>
            </form>
        </div>
        <div id="zone_text">
            <div id="btn_retour">
                <button onclick="window.location.href='../interfaceWEB/index.php'">Retour à la page d’accueil</button>
            </div>
            <div class="text">
                <h2>Aimeriez-vous effacer votre compte?</h2>
                <p> Si vous choisissez de supprimer votre compte sur
                    notre plateforme de réservation d'hôtel, veuillez 
                    noter que toutes vos données personnelles seront 
                    définitivement effacées de notre système, soit 
                    vos informations d’authentifications. Une fois 
                    votre compte supprimé, il ne sera pas possible de
                    récupérer ces informations.</p>

                    <br>
                   
                    <p>Nous vous encourageons à réfléchir attentivement 
                    avant de prendre cette décision, car elle entraînera 
                    la perte totale de votre accès à notre service de 
                    réservation. Si vous êtes sûr de vouloir procéder à 
                    la suppression de votre compte, veuillez confirmer 
                    vos informations d’authentifications.</p>
                    <br>
                <div id="effacer_compte">
                    <form id="form_supprimer" action="../backendWEB/supprimercompte.php" method="post" >
                        <label for="email"></label>
                        <input id='email' name="email" type="text" placeholder="email" required>
                        <br><br>
                        <label for="mot_de_passe"></label>
                        <input id='mot_de_passe' name="mot_de_passe" type="password" placeholder="mot de passe" required>
                        <br>
                        <button type="submit">Effacer Compte</button>
                    </form>
                </div>
        </div>
    </div>

    <script src='../backendWEB/supprimercompte.js'></script>

</body>
</html>
