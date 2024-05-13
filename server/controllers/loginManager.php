<?php
/**
 * Gestion de l'authentification
 *
 * Ce script gère les opérations d'authentification des utilisateurs.
 * Il permet de vérifier les informations d'identification des utilisateurs et de les déconnecter de l'application.
 *
 * @version 1.0
 * @author Yann Sommet
 */

require_once('../workers/LoginDBManager.php');
require_once('SessionManager.php');

// Définition des en-têtes CORS
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

// Création d'une instance de LoginDBManager et SessionManager
$wrk = new LoginDBManager();
$sm = new SessionManager();

/**
 * Vérifier si l'utilisateur est valide
 */
if (isset($_POST['action'])) {
    if ($_POST['action'] == "checkLogin") {
        $username = $_POST["user"];
        $password = $_POST["pwd"];
    
        $return = $wrk->checkLogin($username, $password);
    
        ob_clean();
        
        // Définissez l'en-tête de type de contenu JSON avant d'envoyer le contenu JSON
        header('Content-Type: application/json');
        
        // Vérifiez si $return est défini et n'est pas égal à false
        if (isset($return) && $return !== false) {
            http_response_code(200); // OK
            echo json_encode(['success' => true]);
        } else {
            $sm->destroySession();
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false]);
        }
    
        exit;
    }
}

/**
 * Déconnecte l'utilisateur de l'application
 */
if (isset($_POST['action'])) {
    if ($_POST['action'] == "disconnect") {
        $sm->destroySession();
        http_response_code(200); // OK
        exit;
    }
}
?>
