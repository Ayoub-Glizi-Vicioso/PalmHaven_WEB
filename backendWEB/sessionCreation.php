<?php

    function createSession($key, $value) {

        // Démarre une session si elle n'est pas déjà démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Crée une variable de session avec la clé et la valeur fournies
        $_SESSION[$key] = $value;
    }
