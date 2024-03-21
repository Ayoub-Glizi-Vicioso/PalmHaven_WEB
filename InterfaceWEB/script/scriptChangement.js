// Script pour le changement d'image

// Sélectionne l'élément HTML qui contient l'image à changer
var change_image = document.querySelector('.changement-image');

// Un tableau contenant les noms des fichiers images
var images1 = ['Suite_Bungalow.png', 'bungalow2.png', 'bungalow3.png', 'bungalow4.png'];
var images2 = ['Club_Familiale_Suite.png', 'familiale2.png'];
var images3 = ['Lune_de_miel_Suite.png','lune2.jpeg', 'lune3.jpeg', 'lune4.jpeg', 'lune5.jpeg' ];
var i = 0;  // Image courrante

// Fonction pour passer à l'image précédente
function avant(x){
    if(x == 1){
        var images = images1;
        var source = './images/bungalow/';
    }
    else if(x==2){
        var images = images2;
        var source = './images/familiale/';
    }
    else if(x==3){
        var images = images3;
        var source = './images/lunedemiel/';
    }

    if(i<=0) i = images.length;
    i--;
    source += images[i];

    // Appelle la fonction pour changer l'image
    changeImage(source);
}

// Fonction pour passer à l'image suivante
function suivant(x){
    if(x == 1){
        var images = images1;
        var source = './images/bungalow/';
    }
    else if(x==2){
        var images = images2;
        var source = './images/familiale/';
    }
    else if(x==3){
        var images = images3;
        var source = './images/lunedemiel/';
    }

    if(i>=images.length-1) i = -1;
    i++;
    source += images[i];

    changeImage(source);
}

// Fonction pour changer l'image en fonction de l'indice actuel
function changeImage(source){
    change_image.setAttribute('src', source);
}
