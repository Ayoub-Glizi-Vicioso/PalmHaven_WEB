

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
            height: 90%;
            position: relative;
            overflow-x: hidden;
            display: flex;
            border-radius: 5%;
        }

        #zone_text {
            width: 55%;
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
            justify-content: center;
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
            margin-bottom: 10px;
        }

        div #btn_effacer_compte{
            background-color: #021b57; 
            cursor: auto;

        }
    </style>
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
                    <form action="../backendWEB/supprimercompte.php" method="post" >
                        <label for="email"></label>
                        <input name="email" type="text" placeholder="email" required>
                        <br><br>
                        <label for="mot_de_passe"></label>
                        <input name="mot_de_passe" type="password" placeholder="mot de passe" required>
                        <br>
                        <button>Effacer Compte</button>
                    </form>
                </div>
        </div>
    </div>

</body>
</html>
