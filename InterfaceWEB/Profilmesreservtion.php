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
            margin-bottom: 10px;
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
                   <table>
                    <tr>
                        <td rowspan="2">Numéro de la réservation</td>
                        <td colspan="2">Date de la réservation</td>
                        <td rowspan="2">Annulation</td>
                        <td rowspan="2">Modification</td>
                        <td rowspan="2">Consulter les factures</td>
                    </tr>
                    <tr>
                        <td>Date de début</td>
                        <td>Date de fin </td>
                    </tr>
                    <tr id="reservationProfil">
                        <td class="donnee" id="num_reserv">
                                <form action="">
                                    <button id="Reservation">exemple</button>
                                </form>
                        </td>



                        <td class="donnee" id="debut">exemple</td>
                        <td class="donnee" id="fin">exemple</td>

                        <td class="donnee" id="annuler">
                                <form action="">
                                    <button id="btn_annuler">annuler</button>
                                </form>
                        </td>

                        <td class="donnee" id="modifier">
                            <form action="">
                                <button id="btn_modifier">modifier</button>
                            </form>
                        </td>

                        <td class="donnee" id="facture">
                            <form action="">
                                <button id="btn_facture">facture</button>
                            </form>
                        </td>
                    </tr>

                   </table>

                </div>
        </div>
    </div>

</body>
</html>
