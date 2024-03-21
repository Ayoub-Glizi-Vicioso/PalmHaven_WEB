
<?php
// Vérifier si le paramètre de suppression réussie est présent dans l'URL
if (isset($_GET['annulation_success']) && $_GET['annulation_success'] === 'true') {
  echo "<script> alert('Annulation réussie!');</script>";

}
// Vérifier si le paramètre de suppression réussie est présent dans l'URL
if (isset($_GET['modif_success']) && $_GET['modif_success'] === 'true') {
    echo "<script> alert('Modification réussie!');</script>";
  
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/pourMESRESERVATION/styleMESRESERVATION.css">
</head>
<body>
    <div class="container">
        <div id="Barre_nav">
            <!--<img src="./images/profil.JPG" ></a>--> 
            <button onclick="window.location.href='ProfilSupprimer.php'" id="btn_reservations">Mes réservations</button>
            
            <a href="ProfilSupprimer.php"><button  id="btn_effacer_compte">Supprimer mon compte</button></a>
            <form action="../backendWEB/deconnexion.php">
                <button  id="btn_decon">Deconnexion</button>
            </form>
        </div>
        <div id="zone_text">
            <div id="btn_retour">
                <button onclick="window.location.href='index.php'">Retour à la page d’accueil</button>
            </div>
            <div class="text">
                <h2>MES RÉSERVATION:</h2>
                
                <div id="table">
                   <table id='reservationProfil'>
                    

                   </table>

                </div>
        </div>
    </div>

    <!-- Structure de la fenêtre annulation -->
<div id="annulation" class="annulation">
    <div class="annulation-content">
        <p>Êtes-vous sûr de vouloir annuler cette réservation ?</p>
        <p>si c'est le cas, afin de confirmer l'annulation saisissait le numero de la reservation et votre email</p>
        
        <form id="form_annuler" action="../backendWEB/annulerReservation.php" method="post">
            <label for="id_reservation"></label>
            <input id="id_reservation" type="number" name="id_reservation" placeholder="saisissez le numero de la reservation"required>
            
            <label for="email"></label>
            <input id="email" type="email"  name="email" placeholder="saisissez votre email"required>
            
            <br>
            
            <input id="confirmBtn" type="submit" readonly value="Confirmer">
        </form >
        <form >
        <input id="cancelBtn" type="submit" readonly value="Annuler">
        </form>
    </div>

</div>


  <!-- Structure de la fenêtre modification -->
  <div id="modification" class="modification">
    <div class="modification-content">
        <p>Êtes-vous sûr de vouloir modifier cette réservation ?</p>
        <p>si c'est le cas, afin de confirmer la modificationn saisissait le numero de la reservation, votre email ainsi que les modification à apporter</p>
        <p><em><u>NOTE: il est possible que votre demande de modifcation soit refusé, en raison que la chambre est réservé par un autre client pour les dates saisies</u></em></p>
        
        <form id="form_modifier" action="../backendWEB/modificationReservation.php" method="post">
            <label for="nouv_debut"><strong>Saisissait la nouvelle date de début de reservation:</strong></label>
            <input id="Ddebut" type="date" name="nouv_debut" required>

            <label for="nouv_fin"><strong>Saisissait la nouvelle date de fin de réservation:</strong></label>
            <input id="Dfin" type="date" name="nouv_fin" required>
            
            <label for="id_reservation"></label>
            <input id="id_reservation" type="number"  name="id_reservation" placeholder="saisissez le numero de la reservation"required>
            
            <label for="email"></label>
            <input id="email" type="email"  name="email" placeholder="saisissez votre email"required>
            
            <input id="confirmBtn" type="submit" readonly value="Confirmer">
        </form>
        <form >
        <input id="modifBtn" type="submit" readonly value="Annuler">
        </form>
    </div>

</div>


    <script src="../backendWEB/Affichagereservation.js"></script>

</body>
</html>
