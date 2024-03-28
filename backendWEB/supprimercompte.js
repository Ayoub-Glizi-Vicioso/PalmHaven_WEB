$(document).ready(function(){
    document.getElementById("form_supprimer").addEventListener("submit", function(event) {
        console.log('formulaire soumis!');
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        let email = document.getElementById('email').value;

        let mot_de_passe = document.getElementById('mot_de_passe').value;


        let url = '../backendWEB/supprimercompte.php'

        let params = 'email=' + email + '&mot_de_passe=' + mot_de_passe;

        let xhr = new XMLHttpRequest();
        xhr.open('DELETE' , url + '?' + params);

        xhr.onreadystatechange = function (){
            if (xhr.status === 200) {
                // Vous pouvez gérer la réponse en fonction de vos besoins  
                const data= JSON.parse(xhr.responseText);
                alert( data['message']);
                if(data['succes']=='true'){

                    window.location.href="../interfaceWEB/index.php";

                }
            } else {
                // Erreur lors de la requête
                console.error("Erreur lors de la requête : " + xhr.status);
            }
        }

        xhr.send();

    });

});