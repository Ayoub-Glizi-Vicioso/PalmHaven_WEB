


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz@9..40&display=swap');
        /* Variables CSS */
        :root {
            --main-bg-color: #f4f4f4;
            --container-bg-color: #fff;
            --container-border-color: #ddd;
            --text-bg-color: #f0f0f0;
            --input-bg-color: #fafafa;
            --input-border-color: #ccc;
            --primary-color: #007bff; /* Couleur principale (bleu) */
        }

        /* Styles de base */
        body {
            font-family: "Montserrat", sans-serif;
            background-color: var(--main-bg-color);
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 20px auto;
            padding: 20px;
            background-color: var(--container-bg-color);
            border: 1px solid var(--container-border-color);
            border-radius: 5px;
            width: 70vw;

        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .content img {
            margin-right: 20px;
            border-radius: 5px;
            width: 40%;
            height: 40%;
        }

        div p {
            background-color: var(--text-bg-color);
            padding: 20px;
            border-radius: 5px;
            width: 140%;
            text-align: center;

        }

        h1, h2 {
            margin: 0;
            color: var(--primary-color);
        }


        th {
            background-color: var(--main-bg-color);
        }

        .total {
            text-align: right;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: var(--primary-color);
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Légère nuance de bleu au survol */
        }

        input[type="hidden"] {
            display: none; /* Cacher les inputs de type "hidden" */
        }

        #div-text{
        font-family: "Montserrat", sans-serif;
        font-size: 14px;
        text-align: center;
        font-style: italic;
        color: blue;
        }

        
    </style>
</head>
<body>
    <?php
    session_start();
        // Récupérer le numéro de réservation depuis l'URL
        $numero_reservation = $_GET['numero_reservation'];
        $_SESSION['numero_reservation']=$numero_reservation;
        
    ?>

    <form id="form_generer_facture" method="get">
        <label for="numero_reservation"></label>
        <input type="hidden" id="numero_reservation" name="numero_reservation" readonly value="<?php echo $numero_reservation; ?>" >
        <input type="submit"  value="Générer Facture">
    </form>

  
    <div class="container">
        <div class="header"><h1>Facture</h1></div>
        <div class="content">
            <img src="./images/img.png" alt="Image">
            <div class="facture_text">
                <p>CLIQUER SUR GÉNÉRER FACTURE</p>
            </div>
        </div>
        <div id="div-text">Veuillez régler le montant total avant la date d'arrivée
            prévue.
            Si vous avez des questions ou des demandes
            spéciales,
            n'hésitez pas à
            à nous contacter. Merci pour votre réservation
            et à bientôt !
        </div>
    </div>
    <script src="../backendWEB/AffichageFacture.js"></script>
</body>
</html>
