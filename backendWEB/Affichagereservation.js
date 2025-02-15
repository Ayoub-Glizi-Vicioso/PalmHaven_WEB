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
            
            if (valeur.length === 0) {
                // Si aucune réservation n'est renvoyée, afficher un message
                $('<h2>Il n\'y a pas de réservation</h2>').appendTo('#reservationProfil');
            } else {
            // Créer un fragment de document pour stocker les nouvelles lignes de la table
            var fragment = document.createDocumentFragment();

            // Créer la première ligne avec les titres des colonnes
            let trHeader = document.createElement('tr');
            trHeader.innerHTML = '<td rowspan="2">Numéro de la réservation</td>' +
                                 '<td colspan="2">Date de la réservation</td>' +
                                 '<td class="input" rowspan="2">Annulation</td>' +
                                 '<td class="input" rowspan="2">Modification</td>' +
                                 '<td class="input" rowspan="2">Consulter les factures</td>';

            // Ajouter la première ligne à la table
            fragment.appendChild(trHeader);
            
            // Créer la deuxième ligne
            let trDate = document.createElement('tr');
            trDate.innerHTML = '<td>Date de début</td><td>Date de fin</td>';

            // Ajouter la deuxième ligne à la table
            fragment.appendChild(trDate);

                // Parcourir les données reçues et créer les éléments HTML correspondants
                for (let i = 0; i < valeur.length; i++) {
                    // Créer une nouvelle ligne de table
                    var tr = document.createElement('tr');
                    
                    // Ajouter les cellules à la ligne de table
                    tr.innerHTML = '<td class="donnee" id="num_reserv"><a href="' + getReservationLink(valeur[i]['type_chambre'], valeur[i]['numero_reservation']) + '">' + valeur[i]['numero_reservation'] + '</a></td>' +
                    '<td class="donnee" id="debut">' + valeur[i]['date_debut'] + '</td>' +
                    '<td class="donnee" id="fin">' + valeur[i]['date_fin'] + '</td>' +
                    '<td class="donnee" id="annuler"><form><input class="btn_annuler" readonly value="Annuler"></form></td>' +
                    '<td class="donnee" id="modifier"><form><input class="btn_modifier" readonly value="Modifier"></form></td>' +
                    '<td class="donnee" id="facture"><form><a href="facture.php?numero_reservation=' + valeur[i]['numero_reservation'] + '" target="_blank" class="btn_facture" readonly>Facture</a></form></td>';
                    
                    // Ajouter la ligne de table au fragment
                    fragment.appendChild(tr);
                    // Récupérer le bouton d'annulation dans la ligne créée
                

                    //obtenir les bouttons et ajouter des ecouteurs d'événement afin d'afficher la fenètre de modification et d'annulation
                    let cancelBtn = tr.querySelector(".btn_annuler");
                    cancelBtn.addEventListener("click", openAnulation);

                    let modifBtn = tr.querySelector(".btn_modifier");
                    modifBtn.addEventListener("click" , openModification);
                }
            }


            // Ajouter le fragment contenant toutes les nouvelles lignes à la table
            document.getElementById('reservationProfil').appendChild(fragment);
        }
    };
       
    // Envoi de la requête
    requeteGet.send();



    // Fonction pour obtenir le lien de réservation en fonction du type de chambre et du numéro de réservation
    function getReservationLink(typeChambre, numeroReservation) {
    
        switch (typeChambre) {
            case 'standard': // cas standard 
                return '../interfaceWEB/chambresDetailsBungalow.php?numero=' + numeroReservation;
                break;
            case 'familiale': // cas familiale
                return '../interfaceWEB/chambreDetailFamiliale.php?numero=' + numeroReservation;
                break;
            case 'lune-de-miel': // cas lune-de-miel
                return '../interfaceWEB/chambreDetailsLune.php?numero=' + numeroReservation ; 
                break;
            default: //gestion d'erreur
                console.log("Erreur: le type de la chambre ne correspond pas à des valeur attendu")
            
        }
    }


  
      
    function openAnulation() {
        // afficher la fenêtre d'annulation
        let annulation = document.getElementById("annulation");
        annulation.style.display = "block";
    
       
        // obtenir le boutton annuler
        let cancelButton = annulation.querySelector("#cancelBtn"); 
    
        // Ajouter un événement de clic pour rendre la fenêtre hidden
        cancelButton.addEventListener("click", function(event) {
          
            annulation.style.display = "none";
        });
    
        // Ajouter un événement de clic pour empêcher la fermeture automatique
        annulation.addEventListener("click", function(event) {
            // Empêcher la propagation de l'événement pour éviter la fermeture automatique
            event.stopPropagation();
        });
    
        // Empêcher l'action par défaut du formulaire
        let form = annulation.getElementById("form_annuler");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
        });
    }
    
            
    function openModification() {
        // afficher la fenêtre d'annulation
        let modification = document.getElementById("modification");
        modification.style.display = "block";
    
          // obtenir le boutton annuler
        let modifButton = modification.querySelector("#modifBtn");
    
        // Ajouter un événement de clic pour rendre la fenêtre hidden
        modifButton.addEventListener("click", function(event) {
            modification.style.display = "none";
        });
    
        // Ajouter un événement de clic pour empêcher la fermeture automatique
        modification.addEventListener("click", function(event) {
            // Empêcher la propagation de l'événement pour éviter la fermeture automatique
            event.stopPropagation();
        });
    
        // Empêcher l'action par défaut du formulaire
        let form = modification.getElementById("form_modifier");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
        });
    }
    

});
