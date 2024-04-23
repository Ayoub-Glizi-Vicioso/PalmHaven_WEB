$(document).ready(function(){
    // Lorsque le document est prêt, exécute cette fonction
    document.getElementById("form_supprimer").addEventListener("submit", function(event) {
       
        console.log('formulaire soumis!'); // Affiche un message dans la console

        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        // Récupère la valeur de l'email et du mot de passe depuis le formulaire
        let email = document.getElementById('email').value;
        let mot_de_passe = document.getElementById('mot_de_passe').value;

        // Définit l'URL vers laquelle la requête sera envoyée
        let url = '../backendWEB/supprimercompte.php'

        // Construit les paramètres à envoyer dans la requête DELETE
        let params = 'email=' + email + '&mot_de_passe=' + mot_de_passe;

        // Initialise une nouvelle requête XMLHttpRequest
        let xhr = new XMLHttpRequest();
        
        // Configure la requête DELETE avec l'URL et les paramètres
        xhr.open('DELETE' , url + '?' + params);

        // Définit une fonction à exécuter lorsque l'état de la requête change
        xhr.onreadystatechange = function (){
            // Vérifie si la requête a abouti avec succès (statut 200)
            if (xhr.status === 200) {
                // Vous pouvez gérer la réponse en fonction de vos besoins  
                const data= JSON.parse(xhr.responseText);
                alert( data['message']); // Affiche un message basé sur la réponse du serveur
                // Redirige vers une autre page si la suppression du compte réussit
               // if(data['succes']=='true'){
              //      window.location.href="../interfaceWEB/index.php";
               // }
            } else {
                // Erreur lors de la requête
                console.error("Erreur lors de la requête : " + xhr.status);
            }
        }

        // Envoie la requête 
        xhr.send();
    });
});
