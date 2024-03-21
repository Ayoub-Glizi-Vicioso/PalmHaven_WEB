


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            height: 85vh;
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
            margin-right: 10px;
            background-color: red;
            height: 50%;
            width: 50%;
        }

        .content p {
            background-color: lightgray;
            height: 70vh;
            width: 60vw;
        }

        h1, h2 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .total {
            text-align: right;
        }

        
        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            margin-top: 10px;
            margin-left: 10px;
            width: 200px;
            font-size: 16px; 
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
        <input type="text" id="numero_reservation" name="numero_reservation" readonly value="<?php echo $numero_reservation; ?>" >
        <input type="submit"  value="Générer Facture">
    </form>

  
    <div class="container">
        <div class="header"><h1>Facture</h1></div>
        <div class="content">
            <img src="" alt="Image">
            <div class="facture_text">
                <p>Votre texte ici...</p>
            </div>
        </div>
    </div>
    <script src="../backendWEB/AffichageFacture.js"></script>
</body>
</html>
