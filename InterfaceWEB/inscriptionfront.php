
<?php
/*Cette en-tête en php permet de mettre en place la connexion à la base de données
sans cette en-tête, il n'y pas de lien avec le formulaire d'inscription*/

error_reporting(E_ALL); ini_set('display_errors', 1);
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
    <link rel="stylesheet" href="css/pourINSCRIP/styleINSCRIP.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <p>© 2024 <a href="index.php">[HOTEL RESERVATION]</a>, Inc. Tous droits réservés.</p>
      </div>
    </div>
    <div class="container-form">
          <div class="form-inscription">
          <form id="form_inscription" action="../backendWEB/inscription.php" method="post">
              <h2>Inscription</h2>
              <label for="prenom"></label>
              <input name="prenom" type="text" placeholder="prénom" required />
              <label for="nom"></label>
              <input name="nom" type="text" placeholder="nom" required />
              <label for="email"></label>
              <input name="email" type="mailto" placeholder="courriel" required />
              <label for="mot_de_passe"></label>
              <div class="tooltip">
                <input name="mot_de_passe" id="mot_de_passe" type="password" placeholder="Mot de passe" onkeyup="updatePasswordStrength()" required />
                <span class="tooltiptext">8 caractères minimum, une minuscule, une majuscule, un chiffre, un caractère spécial</span>
              </div>
              <div id="passwordStrengthMeter"></div>
              <button type='submit'>S'inscrire</button>
              <br>
              <button onclick="window.location.href='connexionfront.php'"id="btn-connexion-cache">Retour page de connexion</button>
            </form> 
          </div>
        </div>
      </div>

      <script>
      function getPasswordStrength(mot_de_passe) {
        // Vérifier la longueur du mot de passe
        let lengthScore = mot_de_passe.length >= 8 ? 20 : 0;
    
        // Vérifier la présence d'au moins une minuscule, une majuscule, un chiffre et un symbole
        let lowerCaseRegex = /[a-z]/;
        let upperCaseRegex = /[A-Z]/;
        let digitRegex = /[0-9]/;
        let symbolRegex = /[^a-zA-Z0-9]/;
        let characterScore = 0;
    
        if (lowerCaseRegex.test(mot_de_passe)) {
            characterScore += 20;
        }
    
        if (upperCaseRegex.test(mot_de_passe)) {
            characterScore += 20;
        }
    
        if (digitRegex.test(mot_de_passe)) {
            characterScore += 20;
        }
    
        if (symbolRegex.test(mot_de_passe)) {
            characterScore += 20;
        }
    
        // Calculer le score total
        let totalScore = Math.min((lengthScore + characterScore), 100);
    
        return totalScore;
       }
      
      function updatePasswordStrength() {
          const passwordInput = document.getElementById('mot_de_passe');
          const passwordStrengthMeter = document.getElementById('passwordStrengthMeter');
          const passwordStrength = getPasswordStrength(passwordInput.value);
      
          passwordStrengthMeter.style.width = passwordStrength + '%';
      
          // Supprimez toutes les classes existantes
          passwordStrengthMeter.classList.remove('weak', 'medium', 'strong');
      
          // Ajoutez la classe appropriée en fonction de la force du mot de passe
          if (passwordStrength < 50) {
              passwordStrengthMeter.classList.add('weak');
          } else if (passwordStrength < 100) {
              passwordStrengthMeter.classList.add('medium');
          } else {
              passwordStrengthMeter.classList.add('strong');
          }
      }
    </script>
    <script src="../backendWEB/inscription.js"></script>
</body>
</html>
