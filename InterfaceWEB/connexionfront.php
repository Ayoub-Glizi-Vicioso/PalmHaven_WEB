<?php 
/*Cette en-tête en php permet de mettre en place la connexion à la base de données
sans cette en-tête, il n'y pas de lien avec le formulaire de connexion*/
session_start();
    // Supprimer toute session existante
    unset($_SESSION['email']);
  
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Inclure le fichier de connexion
        require '../backendWEB/connexion.php';
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se Connecter</title>
    <link rel="stylesheet" href="css/pourCONNEXION/styleCONNEXION.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
  

    <div class="container">
        <div class="container-form">
          <div class="form-connexion">
            <form id="form_connexion" method="POST" action="../backendWEB/connexion.php">
              <h2 id="connexiontxt">Connexion</h2>
              <br>
              <!--<label for="email"></label>-->
              <input name="email" type="email" placeholder="Adresse courriel" required />
               <!--<label for="mot_de_passe"></label>-->
              <input name="mot_de_passe" type="password" placeholder="Mot de passe" required />
              <br>
              <button>Connexion</button>
              <br>
              <button id="btn-inscription-cache" onclick="window.location.href='inscriptionfront.php'">Pas de compte? Inscrivez-vous.</button>
              
              
            </form>
          </div>
        </div>
        <div class="Salutation-container">
          <div class="text">
            <div class="Salutation">
              <h2>Content de vous revoir!</h2>
              <br>
              <br>
              <p id="msgbienvenue">
                De retour!? Nous sommes content de vous revoir ici. Nous espérons que vous avez eu un endroit sécuritaire où vous reposer.
             </p>
             <br>
              <br>
              <button id="btn-inscription" onclick="window.location.href='inscriptionfront.php'">Pas de compte? Inscrivez-vous.</button>
            </div>
            <br>
            <br>
            <br>
            <p>© 2024 <a href="index.php">[HOTEL RESERVATION]</a>, Inc. Tous droits réservés.</p>
          </div>
        </div>
      </div>

      <script src='../backendWEB/connexion.js'></script>
</body>
</html>

