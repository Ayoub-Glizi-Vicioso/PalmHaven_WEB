$(document).ready(function(){
    document.getElementById("form_supprimer").addEventListener("submit", function(event) {
        console.log('formulaire soumis!');
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        let email = document.getElementById('email').value;
        console.log(email);
        let mot_de_passe = document.getElementById('mot_de_passe').value;
        console.log(mot_de_passe);

        let url = '../backendWEB/supprimercompte.php'

        let params = 'email=' + email + '&mot_de_passe=' + mot_de_passe;

        let xhr = new XMLHttpRequest();
        xhr.open('DELETE' , url + '?' + params);

        xhr.onreadystatechange = function (){
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    window.location.href = '../interfaceWEB/index.php?delete_success=true';
                }
            }else{
                console.error('Erreur de requête :' , xhr.status);
            }
        }

        xhr.send();

    });

});