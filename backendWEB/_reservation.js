$(document).ready(function () {
    document.getElementById("reservationForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        var form = this;
        var formData = new FormData(form); // Créer un objet FormData avec les données du formulaire

        var xhr = new XMLHttpRequest();
        xhr.open("POST", form.action, true); // Ouvrir une requête POST vers l'action du formulaire
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // Définir l'en-tête X-Requested-With pour indiquer une requête AJAX

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Succès de la requête
                var response = xhr.responseText;
                console.log(response); // Afficher la réponse du serveur (peut-être une redirection)
                // Vous pouvez gérer la réponse en fonction de vos besoins
            } else {
                // Erreur lors de la requête
                console.error("Erreur lors de la requête : " + xhr.status);
            }
        };

        xhr.onerror = function() {
            // Gérer les erreurs de connexion
            console.error("Erreur de connexion lors de la requête.");
        };

        xhr.send(formData); // Envoyer les données du formulaire au serveur
    });
});