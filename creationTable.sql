-- creation des tables 


CREATE TABLE utilisateurs (
    id_utilisateur INT(11) PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(100),
    mot_de_passe VARCHAR(255)
);


CREATE TABLE avis (
    id_message INT(11) PRIMARY KEY AUTO_INCREMENT,
    Contenu TEXT NULL,
    Date_Systeme TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    Etoiles INT(11) NULL,
    id_utilisateur INT(11),
    Titre VARCHAR(255) NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);


CREATE TABLE chambre (
    type_chambre VARCHAR(250),
    img LONGBLOB NULL,
    statut VARCHAR(255),
    numero INT(10) PRIMARY KEY,
    prix INT(10)
);


CREATE TABLE reservation (
    numero_reservation INT(11) PRIMARY KEY AUTO_INCREMENT,
    numero_chambre INT(10),
    date_debut DATE,
    date_fin DATE,
    id_utilisateur INT(10),
    FOREIGN KEY (numero_chambre) REFERENCES chambre(numero),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);
