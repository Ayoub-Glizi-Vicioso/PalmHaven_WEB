$(document).ready(function(){
    // Configuration de la requête HTTP GET vers une URL
    var requeteGet = new XMLHttpRequest();
    requeteGet.open('GET', '../backendWEB/AffichageReservation.php', true);
            
    // Définition de la fonction à exécuter une fois la requête terminée
    requeteGet.onreadystatechange = function () {
        // Vérification si la requête est terminée (readyState === 4)
        // et si le statut de la réponse est 200 - OK
        if (requeteGet.readyState === 4 && requeteGet.status === 200) {
            // Effacer le contenu précédent de la section affichage-annonce
            $('#reservationProfil').empty();

            // Traitement de la réponse reçue du serveur
            const valeur = JSON.parse(requeteGet.responseText);
            
            // Créer un fragment de document pour stocker les nouvelles lignes de la table
            var fragment = document.createDocumentFragment();

            // Créer la première ligne avec les titres des colonnes
            let trHeader = document.createElement('tr');
            trHeader.innerHTML = '<td rowspan="2">Numéro de la réservation</td>' +
                                 '<td colspan="2">Date de la réservation</td>' +
                                 '<td rowspan="2">Annulation</td>' +
                                 '<td rowspan="2">Modification</td>' +
                                 '<td rowspan="2">Consulter les factures</td>';

            // Ajouter la première ligne à la table
            fragment.appendChild(trHeader);
            
            // Créer la deuxième ligne
            let trDate = document.createElement('tr');
            trDate.innerHTML = '<td>Date de début</td><td>Date de fin</td>';

            // Ajouter la deuxième ligne à la table
            fragment.appendChild(trDate);

            if (valeur.length === 0) {
                // Si aucune réservation n'est renvoyée, afficher un message
                $('<h2>Il n\'y a pas de réservation</h2>').appendTo('#reservationProfil');
            } else {
                for (let i = 0; i < valeur.length; i++) {
                    // Créer une nouvelle ligne de table
                    var tr = document.createElement('tr');
                    
                    // Ajouter les cellules à la ligne de table
                    tr.innerHTML = '<td class="donnee" id="num_reserv"><form><button><u>' + valeur[i]['numero_reservation']+ '</u></button></form></td>' +
                                    '<td class="donnee" id="debut">' + valeur[i]['date_debut']+ '</td>' +
                                    '<td class="donnee" id="fin">' + valeur[i]['date_fin']+ '</td>' +
                                    '<td class="donnee" id="annuler"><form><button class="btn_annuler">Annuler</button></form></td>' +
                                    '<td class="donnee" id="modifier"><form><button class="btn_modifier">Modifier</button></form></td>' +
                                    '<td class="donnee" id="facture"><form><button class="btn_facture">Facture</button></form></td>';
    
                    // Ajouter la ligne de table au fragment
                    fragment.appendChild(tr);
                }
            }


            // Ajouter le fragment contenant toutes les nouvelles lignes à la table
            document.getElementById('reservationProfil').appendChild(fragment);
        }
    };
       
    // Envoi de la requête
    requeteGet.send();
});
