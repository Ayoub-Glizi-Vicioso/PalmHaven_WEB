$(document).ready(function(){
    $('#form_generer_facture').on('submit', function(event){
        // Empêcher le formulaire de se soumettre normalement
        event.preventDefault();

        // Récupérer le numéro de réservation du champ de formulaire
        let numero_reservation = $('#numero_reservation').val();

        // Configuration de la requête HTTP GET vers une URL avec le numéro de réservation
        let requeteGet = new XMLHttpRequest();
        requeteGet.open('GET', '../backendWEB/AffichageFacture.php?numero_reservation=' + numero_reservation, true);

        // Définition de la fonction à exécuter une fois la requête terminée
        requeteGet.onreadystatechange = function () {
            // Vérification si la requête est terminée (readyState === 4)
            // et si le statut de la réponse est 200 - OK
            if (requeteGet.readyState === 4 && requeteGet.status === 200) {
                // Effacer le contenu précédent de la section affichage-annonce
                $('.facture_text').empty();

                try{
                // Traitement de la réponse reçue du serveur
                const valeur = JSON.parse(requeteGet.responseText);
                
                

                // Accès à la première (et seule) entrée dans le tableau
                const objet = valeur[0];

                // Récupération des valeurs à partir de l'objet
                const numeroReservation = objet.numero_reservation;
                const nomClient = objet.nom;
                const typeChambre = objet.type_chambre;
                const dateDebut = objet.date_debut;
                const dateFin = objet.date_fin;
                const prixParNuit = objet.prix;

                // Calculs
                const prixTotal = nombreJoursEntreDeuxDates(dateDebut, dateFin) * prixParNuit;
                const taxe = calculerTaxe(prixTotal);
                const total = coutTotal(prixTotal, taxe);

               
                                    
                
               // Construire le contenu de la facture
                let factureText = 'Facture pour la réservation de <span style="color:#16b0c4;"><strong>' + nomClient + '</strong></span> :<br><br>' +
                'Numéro de réservation : ' + numeroReservation + '<br><br>' +
                'Nom du client : ' + '<span style="color:#16b0c4;"><strong>' + nomClient + '</strong></span>' + '<br><br>' +
                'Type de chambre : ' + typeChambre + '<br><br>' +
                'Dates de séjour : du ' + dateDebut + ' au ' + dateFin + '<br><br>' +
                'Prix par nuit : ' + prixParNuit + '$<br><br>' +
                'Prix total : ' + prixTotal + '$<br><br>' +
                'Taxe : ' + taxe + '$<br><br>' +
                'Total : ' + total + '$';

                
                // Remplir l'élément p avec le contenu de la facture
                let p = document.createElement('p');
                p.innerHTML = factureText;
                $('.facture_text').append(p);

            } catch (error) {
                console.error("Erreur lors de l'analyse de la réponse JSON:", error);
            }
            }
        };

        // Envoi de la requête GET
        requeteGet.send();
    });
});

// Fonction pour calculer le nombre de jours entre deux dates
function nombreJoursEntreDeuxDates(date1, date2) {
    // Convertir les dates en objets Date
    let date1Obj = new Date(date1);
    let date2Obj = new Date(date2);

    if(date1 === date2){
        return 1;

    }
    // Calculer la différence en jours entre les deux dates
    // ceil arrond à l'entier supérieur.
    let differenceEnJours = Math.ceil((date2Obj - date1Obj) / (1000 * 60 * 60 * 24));

    return differenceEnJours;
}

// Fonction pour calculer les Taxes 
function calculerTaxe(prix) {
    return prix * 0.15;
}

// Fonction pour calculer le cout Total 
function coutTotal(prixSansTaxe, taxe) {
    return prixSansTaxe + taxe;
}
