<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if(isset($_SESSION['email'])) {
    // Utilisateur connecté : inclure la barre de navigation pour les utilisateurs connectés
    include 'nav_connected.php';
} else {
    // Utilisateur non connecté : inclure la barre de navigation pour les utilisateurs non connectés
    include 'nav_not_connected.php';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Politique</title>
    <link rel="stylesheet" href="css/pourPOLITIQUE/stylePOLITIQUE.css">
  </head>
  <body>
   



    
    <br>
    <br>
    <hr class="barre-horizontale">

    <div class="container">
      <div class="ligne-horizontale"></div>
      <div class="empty-div"></div>
      <div class="content">
        <h1>Politique de l'hôtel</h1>
        <span class="hotel-name">Palm Haven</span>
        <br>
        <br>

        <p>
          <em>Nous sommes heureux de vous accueillir à </em>
          <span class="hotel-name-p">Palm Haven</span>. <em>Notre objectif est de vous
          offrir une expérience de séjour agréable et mémorable. Pour assurer le
          confort et la sécurité de tous nos clients, nous avons établi les
          politiques suivantes : </em>
        </p>
        

        <h2>Réservations:</h2>
        <ul>
          <li>
            Toutes les réservations sont soumises à disponibilité et doivent
            être confirmées par l'hôtel.
          </li>
          <li>
            Les tarifs des chambres sont sujets à changement en fonction de la
            saison, de la durée du séjour et de la demande.
          </li>
        </ul>

        <h2>Enregistrement et départ:</h2>
        <ul>
          <li>
            L'heure d'arrivée standard est à partir de 14h00, et l'heure de
            départ est à 12h00.
          </li>
          <li>
            Les arrivées anticipées et les départs tardifs sont soumis à
            disponibilité et peuvent être soumis à des frais supplémentaires.
          </li>
        </ul>

        <h2>Politique d'annulation:</h2>
        <ul>
          <li>
            Les annulations doivent être effectuées au moins 24 heures avant la
            date d'arrivée prévue pour éviter des frais d'annulation.
          </li>
          <li>
            Les réservations non honorées seront soumises à des frais
            correspondant à une nuitée.
          </li>
        </ul>

        <h2>Enfants et lits supplémentaires:</h2>
        <ul>
          <li>
            Les enfants de moins de 12 ans séjournent gratuitement dans la
            chambre des parents s'ils utilisent les lits existants.
          </li>
          <li>
            Des lits supplémentaires peuvent être fournis sur demande et sont
            soumis à disponibilité.
          </li>
        </ul>

        <h2>Politique de paiement:</h2>
        <ul>
          <li>
            Le paiement intégral est requis au moment de la réservation, sauf
            indication contraire.
          </li>
          <li>
            Nous acceptons les principales cartes de crédit et espèces comme
            moyen de paiement.
          </li>
        </ul>

        <h2>Animaux domestiques:</h2>
        <ul>
          <li>
            Les animaux de compagnie sont les bienvenus dans certaines chambres,
            sous réserve d'approbation préalable et de frais supplémentaires.
          </li>
          <li>
            Les propriétaires d'animaux sont tenus de respecter les règles de
            l'hôtel concernant les animaux de compagnie.
          </li>
        </ul>

        <h2>Comportement des clients:</h2>
        <ul>
          <li>
            Nous attendons de nos clients qu'ils respectent les autres clients
            et le personnel de l'hôtel en adoptant un comportement respectueux
            et civilisé.
          </li>
          <li>
            Tout comportement perturbateur ou irrespectueux pourra entraîner
            l'expulsion de l'hôtel sans remboursement.
          </li>
        </ul>

        <h2>Services et équipements:</h2>
        <ul>
          <li>
            Les services et équipements de l'hôtel sont réservés aux clients
            enregistrés.
          </li>
          <li>
            Certains services peuvent être soumis à des frais supplémentaires.
          </li>
        </ul>

        <h2>Responsabilité:</h2>
        <ul>
          <li>
            L'hôtel n'est pas responsable des biens perdus, volés ou endommagés
            pendant votre séjour.
          </li>
          <li>
            Nous recommandons à nos clients de souscrire une assurance voyage
            pour couvrir tout incident imprévu.
          </li>
        </ul>

        <p>
          En acceptant de séjourner dans notre établissement, vous reconnaissez
          avoir lu, compris et accepté notre politique. Nous sommes ravis de
          vous accueillir et nous nous efforcerons de rendre votre séjour aussi
          agréable que possible.
        </p>

        <p>
          Pour toute question ou préoccupation supplémentaire, n'hésitez pas à
          contacter notre équipe à tout moment.
        </p>
      </div>
      <div class="empty-div"></div>
    </div>

    <footer>
      <p>
        [] est représenté au Québec par nous (Canada) Inc., une licence
        québécoise. [], Inc. n'est pas responsable du contenu des sites Web
        externes.
      </p>
      <p>© 2024 [], Inc. Tous droits réservés.</p>
    </footer>
  </body>
</html>
