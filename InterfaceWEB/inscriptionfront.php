
<?php
/*Cette en-tête en php permet de mettre en place la connexion à la base de données
sans cette en-tête, il n'y pas de lien avec le formulaire d'inscription*/
  session_start(); 
    // Supprimer toute session existante
    unset($_SESSION['email']);
   
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Inclure le fichier de connexion
        require '../backendWEB/inscription.php';
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

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Montserrat", sans-serif;
    font-weight: 300;
    font-style: normal;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: url(./images/photoInscription.png) no-repeat center/cover;
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

.form-inscription {
    position: relative;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    height: 100%;
    transition: all 0.5s ease-in;
}

.form-inscription form {
    margin: 0 30px;
}

.form-inscription input {
    margin: 10px 0;
    border: none;
    padding: 15px;
    background-color: #efefef;
    border-radius: 5px;
    letter-spacing: .1rem;
}

.form-inscription button {
    border: none;
    padding: 20px;
    margin-top: 5px;
    background-color: #16b0c4;
    border-radius: 12px;
    color: #fff;
    cursor: pointer;
    font-size: larger;
    letter-spacing: .2rem;
}

.form-inscription button:hover {
    background-color: #021b57;
}

.Bienvenue-container {
    width: 50%;
    text-align: center;
    background-color: rgb(242, 238, 238);
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

.Bienvenue {
    margin: 0 30px;
}

.Bienvenue button {
    border: none;
    padding: 15px 30px;
    background-color: #16b0c4;
    border-radius: 50px;
    color: #fff;
    margin: 10px 0;
    cursor: pointer;
    letter-spacing: .2rem;
}

.Bienvenue button:focus,
.Bienvenue button:hover {
    background-color: #021b57;
}

/* Ajout de l'effet de saut de ligne pour chaque élément du formulaire */
.form-inscription input,
.form-inscription button {
    display: block;
    width: 100%;
    font-family: "Montserrat";
}
#btn-connection{
  margin-top: 20px;
    background-color: #16b0c4;
    border-radius: 12px;
    color: #fff;
    cursor: pointer;
    font-family: "Montserrat";
    letter-spacing: .2rem;
}
#btn-connection:hover{
  background-color: #021b57;
}
p{
    font-family: "Montserrat";
    line-height: 25px;
}

h2 {
  font-family: "Montserrat";
    font-size: 30px;
    margin-bottom: 30px;

}

</style>
</head>
<body>
  <div class="container">
    <div class="Bienvenue-container">
      <div class="text">
        <div class="Bienvenue">
          <h2>Bienvenue!</h2>
          <br>
          <p>
            Nous sommes ravis de vous accueillir et de vous offrir une expérience exceptionnelle.  N'hésitez pas à parcourir notre site et à découvrir tout ce que nous avons à vous offrir.
          </p>
          <br>
          <button onclick="window.location.href='connexionfront.php'"id="btn-connection">Retour page de connexion</button>
        </div>
        <br>
        <br>
        <p>© 2024 <a href="politique.html">[HOTEL RESERVATION]</a>, Inc. Tous droits réservés.</p>
      </div>
    </div>
    <div class="container-form">
          <div class="form-inscription">
          <form method="POST">
              <h2>Inscription</h2>
              <label for="prenom"></label>
              <input name="prenom" type="text" placeholder="prénom" required />
              <label for="nom"></label>
              <input name="nom" type="text" placeholder="nom" required />
              <label for="email"></label>
              <input name="email" type="mailto" placeholder="courriel" required />
              <label for="mot_de_passe"></label>
              <input name="mot_de_passe" type="password" placeholder="mot de passe" required />
              <button>S'inscrire</button>
            </form>
          </div>
        </div>
      </div>
</body>
</html>
