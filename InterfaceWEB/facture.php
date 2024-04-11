


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/pourFACTURE/styleFACTURE.css">
</head>
<body>
    <?php
    session_start();
        // Récupérer le numéro de réservation depuis l'URL
        $numero_reservation = $_GET['numero_reservation'];
        $_SESSION['numero_reservation']=$numero_reservation;
    ?>


  
    <div class="container">
        <div class="header"><h1>Facture</h1></div>
        <div class="content">
            <img src="./images/img.png" alt="Image">
            <div class="facture_text">
                <p>appuyer sur le boutton ci-dessous</p>
            </div>
        </div>

        <br>
        <form id="form_generer_facture" method="get">
            <label for="numero_reservation"></label>
            <input type="hidden" id="numero_reservation" name="numero_reservation" readonly value="<?php echo $numero_reservation; ?>" >
            <input type="submit"  value=" ==> CLIQUER ICI !!! <==">
        </form>
        <br>
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
