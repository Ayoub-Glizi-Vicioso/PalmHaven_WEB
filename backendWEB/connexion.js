document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("form_connexion").addEventListener("submit", function(event) {
        console.log('Formulaire soumis!');
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        // Récupérer les valeurs des champs du formulaire
        let email = document.querySelector("input[name='email']").value;

        let mot_de_passe = document.querySelector("input[name='mot_de_passe']").value;
  

        // Construire les données à envoyer
        let data = {
            email: email,
            mot_de_passe: mot_de_passe
        };

        // Convertir les données en format JSON
        let jsonData = JSON.stringify(data);



        // Configurer la requête XMLHttpRequest
        let xhr = new XMLHttpRequest();
        let url = "../backendWEB/connexion.php";
        xhr.open("POST", url); // Utiliser une requête asynchrone
        xhr.setRequestHeader("Content-Type", "application/json");

        // Gérer la réponse de la requête
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    

                    const data= JSON.parse(xhr.responseText);
                    alert( data['message']);

                    if(data['succes']=='true'){

                        window.location.href="../interfaceWEB/index.php";

                    }
                    

                   
                } else {
                    // Afficher un message d'erreur dans la console
                    console.error('Erreur de requête :', xhr.status);
                    alert("Erreur lors de la connexion. Veuillez réessayer.");
                }
            }
        };

        // Envoyer les données JSON à la page de connexion
        xhr.send(jsonData);
    });
});
