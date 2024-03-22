document.addEventListener("DOMContentLoaded", function() {



    
    // Code à exécuter une fois que le document est complètement chargé
    document.getElementById("form_modifier").addEventListener("submit", function(event) {


        // Récupérer les valeurs des champs de date
        let startDate = $('#Ddebut').val();
        let endDate = $('#Dfin').val();
        console.log("Formulaire soumis !");

        // Vérifier si les champs de date sont vides
        if (!startDate || !endDate ) {
            event.preventDefault(); // Empêcher le (rechargement de la page)
            // Afficher l'alerte si les champs de date sont vides
            alert("Saisissez une date de début et de fin");
            return; // Arrêter l'exécution de la fonction si les champs sont vides
        }

        // Vérifier si le champs startDate est supérieur à EnDate
        if(startDate>endDate){
            event.preventDefault();
            
            alert("La date de début de la réservation doit être inférieur à la date de fin de réservation");
            return;
            
        }

        // Récupérer la date actuelle du système
        /* let dateActuelle = new Date();

        // Convertir les en objet Date
        let startDateObj = new Date(startDate.toString());
        let endDateObj = new Date(endDate.toString());


        if (startDateObj < dateActuelle || endDateObj < dateActuelle) {
            
            event.preventDefault();
            alert("La date de début et/ou de fin de la réservation doit être supérieure à celle d'aujourd'hui");
            return;
        }*/









        event.preventDefault(); // Empêche le formulaire de se soumettre normalement
        

        let nouveau_debut = document.getElementById("Ddebut").value;
        let nouveau_fin = document.getElementById("Dfin").value;
        let id_reservation = document.getElementById("numero_reservation").value;
        let email = document.getElementById("courriel").value;
        
        let url = '../backendWEB/modificationReservation.php';
        let requeteJson = JSON.stringify({
            nouv_debut: nouveau_debut,
            nouv_fin: nouveau_fin,
            id_reservation: id_reservation,
            email: email
        });

        let xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Content-type', 'application/json');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Redirection vers la page de profil après la modification de la réservation
                    window.location.href = '../interfaceWEB/Profilmesreservtion.php?modif_success=true';
                } else {
                    // Gérer les erreurs
                    console.error('Erreur de requête :', xhr.status);
                }
            }
        };

        xhr.send(requeteJson);
    });
});
