document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".form_deconnexion").addEventListener("submit", function(event) {
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        // Récupérer le formulaire
        let form = event.target;

        // Créer une nouvelle requête XMLHttpRequest
        let xhr = new XMLHttpRequest();
        xhr.open(form.method, form.action, true);

        // Gérer la réponse de la requête
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Redirection vers la page de connexion en cas de succès
                    window.location.href = "../interfaceWEB/index.php";
                } else {
                    // Afficher un message d'erreur dans la console
                    console.error('Erreur de requête :', xhr.status);
                    alert("Erreur lors de la déconnexion. Veuillez réessayer.");
                }
            }
        };

        // Envoyer le formulaire
        xhr.send(new FormData(form));
    });
});
