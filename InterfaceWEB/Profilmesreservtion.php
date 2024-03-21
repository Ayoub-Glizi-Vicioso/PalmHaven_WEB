
<?php
// Vérifier si le paramètre de suppression réussie est présent dans l'URL
if (isset($_GET['annulation_success']) && $_GET['annulation_success'] === 'true') {
  echo "<script> alert('Annulation réussie!');</script>";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            height: 70%;
            position: relative;
            overflow-x: hidden;
            overflow-y: hidden;
            display: flex;
            border-radius: 5%;
        }

        #zone_text {
            width: 80%;
            text-align: center;
            padding: 20px;
        }

        #Barre_nav {
            display: flex;
            width: 40%;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            background-color: rgb(242, 238, 238);
            padding: 20px;
            border-radius: 5%;
        }
        #Barre_nav button {
    border: none;
    padding: 10px 20px;
    margin: 5px;
    background-color: #16b0c4;
    border-radius: 12px;
    color: #fff;
    cursor: pointer;
    font-size: larger;
    letter-spacing: .2rem;
}

#Barre_nav button:hover {
    background-color: #021b57;
}
input{
            border: none;
            padding: 10px;
            width: 100%;
            margin-top: 5px;
            background-color: #16b0c4;
            border-radius: 12px;
            color: #fff;
            cursor: pointer;
            font-size: 10px;
            letter-spacing: .2rem;
            text-align: center;
        }

        input:hover {
            background-color: #021b57;
        }



        button {
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

        button:hover {
            background-color: #021b57;
        }

        .text {
            display: flex;
            flex-direction: column;
            margin-top: 120px;
            align-items: center;
            height: 100%;
            font-size: 13px;
        }

        p {
            font-family: "Montserrat";
            line-height: 20px;
        }
        img{
            height: 100px;
            width: 100px
        }

        h2 {
            font-family: "Montserrat";
            font-size: 24px;
            margin-top: 10px;
            margin-bottom: 10px;
            border: 0px;
        }

        div #btn_reservations{
            background-color: #021b57; 
            cursor: auto;

        }

        table , td , th , tr{
            border:1px solid lightgray;
            border-collapse:collapse;
            padding: 10px;
        }

        .donnee{
            background-color: lightgray;
            color: #16b0c4;
        }

    form button{
        background-color: lightgrey;
        color:#16b0c4;
        font-size: 13px;
        font-family: "Montserrat";
        line-height: 20px;
        margin-bottom: 5px;
        font-weight: bolder;

    }

    form button:hover{
        color: white;
        background-color: lightgray;
        
    }

    #debut , #fin {
        color: white;
        font-size: 10px;
    }

/* Styles pour la fenêtre modale */
.annulation , .modification{
    display: none; /* Par défaut, la fenêtre modale est cachée */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
    overflow: auto;
}

.annulation-content, .modification-content {
    background-color: white;
    margin: 2% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
    text-align: center;
}


.input{
    width: 15%;
}

#id_reservation , #email , #Ddebut , #Dfin{
    background-color: white;
    border: 1px solid lightgray;
    color: black;
}


    </style>
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

    <!-- Structure de la fenêtre modale -->
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


  <!-- Structure de la fenêtre modale -->
  <div id="modification" class="modification">
    <div class="modification-content">
        <p>Êtes-vous sûr de vouloir modifier cette réservation ?</p>
        <p>si c'est le cas, afin de confirmer la modificationn saisissait le numero de la reservation, votre email ainsi que les modification à apporter</p>
        <p><em><u>NOTE: il est possible que votre demande de modifcation soit refusé, en raison que la chambre est réservé par un autre client pour les dates saisies</u></em></p>
        
        <form id="form_modifier" action="" method="post">
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
