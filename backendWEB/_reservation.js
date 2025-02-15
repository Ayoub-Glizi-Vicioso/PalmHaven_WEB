$(document).ready(function () {
    // Sélectionnez le formulaire de réservation
    const reservationForm = document.getElementById("reservationForm");

    // Ajoutez un écouteur d'événements sur la soumission du formulaire
    reservationForm.addEventListener("submit", function(event) {
        // Empêchez le formulaire de se soumettre normalement
        event.preventDefault();

        // Récupérez la valeur du champ "numero_chambre"
        const numero_chambre = document.querySelector("input[name='numero_chambre']").value;

        // Créez un objet avec les données du formulaire
        const formData = {
            numero_chambre: numero_chambre
        };

        // Convertissez l'objet en chaîne JSON
        const jsonData = JSON.stringify(formData);
    

        //Requete http
        var xhr = new XMLHttpRequest();
        //post vers le api _reservation.php
        xhr.open("POST", "../backendWEB/_reservation.php", true);
       
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    //recupérer la réponse de l'api et l'afficher
                    const data= JSON.parse(xhr.responseText);
                    alert( data['message']);
                } else {
                    // Erreur lors de la requête
                    console.error("Erreur lors de la requête : " + xhr.status);
                }
            }
        };

        xhr.onerror = function() {
            // Gérer les erreurs de connexion
            console.error("Erreur de connexion lors de la requête.");
        };

        xhr.send(jsonData); // Envoyer les données du formulaire au serveur
    });
});
