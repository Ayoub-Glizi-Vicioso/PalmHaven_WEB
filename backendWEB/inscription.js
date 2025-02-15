document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("form_inscription").addEventListener("submit", function(event) {
        console.log('formulaire soumis!');
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        // Récupérer les valeurs des champs du formulaire
        let nom = document.querySelector("input[name='nom']").value;

        let prenom = document.querySelector("input[name='prenom']").value;

        let email = document.querySelector("input[name='email']").value;

        let mot_de_passe = document.querySelector("input[name='mot_de_passe']").value;
      

        // Construire les données à envoyer
        let data = {
            nom: nom,
            prenom: prenom,
            email: email,
            mot_de_passe: mot_de_passe
        };

        // Convertir les données en format JSON
        let jsonData = JSON.stringify(data);

    

        // Configurer la requête XMLHttpRequest
        let xhr = new XMLHttpRequest();
        let url = "../backendWEB/inscription.php";
        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");

        // Gérer la réponse de la requête
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    //récupérer le message de l'api et l'afficher
                     const data= JSON.parse(xhr.responseText);
                     alert( data['message']);
                 } else {
                     // Erreur lors de la requête
                     console.error("Erreur lors de la requête : " + xhr.status);
                 }
            }
        };

        // Envoyer les données JSON à la page d'inscription
        xhr.send(jsonData);
    });
});
