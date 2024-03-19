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

    // Vérifier si le paramètre de suppression réussie est présent dans l'URL
if (isset($_GET['inscrip_success']) && $_GET['inscrip_success'] === 'true') {
  echo "<script> alert('Création de compte réussie!');</script>";

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz@9..40&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
    
  body {
    font-family: "Montserrat", sans-serif;
  font-optical-sizing: auto;
  font-weight: 300;
  font-style: normal;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: url(./images/beach.png) no-repeat center/cover;
    font-size: 14px;
  }
  
  .container {
    background-color: #fff;
    width: 100%;
    max-width: 65%;
    height: 75%;
    position: relative;
    overflow-x: hidden;
    display: flex;
    border-radius: 5%;
  }
  
  .container-form {
    width: 50%;
    text-align: center;
  }
  
 
  .form-connexion {
    position: relative;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    height: 100%;
    transition: all 0.5s ease-in;
  }
  
  
  .form-connexion form {
    margin: 0 30px;
    font-family: "Montserrat";
  }
  
  
  .form-connexion input {
    margin: 10px 0;
    border: none;
    padding: 15px;
    background-color: #efefef;
    border-radius: 5px;
    letter-spacing: .1rem;
    font-family: "Montserrat";
  }
  
  
  .form-connexion button {
    border: none;
    padding: 20px;
    margin-top: 5px;
    background-color: #16b0c4;
    border-radius: 12px;
    color: #fff;
    cursor: pointer;
    font-family: "Montserrat";
    font-size: larger;
    letter-spacing: .2rem;
  }
  

  .form-connexion button:hover {
    background-color: #021b57;
  }
  
  .Salutation-container {
    width: 50%;
    text-align: center;
    background-color: rgb(242, 238, 238) ;
  }
  
  .text {
    position: relative;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    height: 100%;
    transition: all 0.5s ease-in;
  }
  
  .Salutation {
    margin: 0 30px;
  }
  
  .Salutation button {
    border: none;
    padding: 15px 30px;
    background-color: #16b0c4;
    border-radius: 50px;
    color: #fff;
    margin: 10px 0;
    cursor: pointer;
    font-family: "Montserrat";
    letter-spacing: .2rem;
  }
  
  .Salutation button:focus,
  .Salutation button:hover {
    background-color: #021b57;
  }
  
  /* Ajout de l'effet de saut de ligne pour chaque élément du formulaire */

  .form-connexion input,
  .form-connexion button {
    display: block;
    width: 100%;
  }
  #msgbienvenue{
    font-family: "Montserrat";
    line-height: 25px;
  }

  #connexiontxt
  {
    font-size: 30px;
    letter-spacing: .3rem;
  }

  
  
    </style>
</head>
<body>

    <div class="container">
        <div class="container-form">
          <div class="form-connexion">
            <form method="POST" action="">
              <h2 id="connexiontxt">Connexion</h2>
              <br>
              <label for="email"></label>
              <input name="email" type="email" placeholder="Adresse courriel" required />
              <label for="mot_de_passe"></label>
              <input name="mot_de_passe" type="password" placeholder="Mot de passe" required />
              <br>
              <button>Connexion</button>
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
            <p>© 2024 <a href="index.html">[HOTEL RESERVATION]</a>, Inc. Tous droits réservés.</p>
          </div>
        </div>
      </div>
</body>
</html>

