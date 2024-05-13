<?php
/**
 * Gestion de session
 *
 * Cette classe gère l'ouverture et la destruction des sessions utilisateur.
 * Elle permet d'initialiser une session avec les informations d'utilisateur fournies et de la détruire lorsque nécessaire.
 *
 * @version 1.0
 * @author Yann Sommet
 */

session_start();

class SessionManager{

    /**
     * Détruit la session de l'utilisateur
     */
    public function destroySession(){
        unset($_SESSION['user']);
        unset($_SESSION['pkUser']);
        unset($_SESSION['estAdmin']);
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    /**
     * Ouvre une nouvelle session utilisateur
     *
     * @param string $username Le nom d'utilisateur à associer à la session
     * @param int $pkUser La clé primaire de l'utilisateur à associer à la session
     * @param int $estAdmin Indique si l'utilisateur est un administrateur (1 pour vrai, 0 pour faux)
     */
    public function openSession($username, $pkUser, $estAdmin){
        $_SESSION['user'] = $username;
        $_SESSION['pkUser'] = $pkUser;
        $_SESSION['estAdmin'] = $estAdmin;
    }

}
?>
