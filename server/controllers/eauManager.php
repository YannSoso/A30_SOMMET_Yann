<?php
/**
 * Gestion des eaux
 *
 * Ce script gère les opérations CRUD (Create, Read, Update, Delete) pour les eaux.
 * Il prend en charge l'ajout et la récupération des eaux dans la base de données.
 *
 * @version 1.0
 * @author Yann Sommet
 */

session_start();

require_once('../workers/EauDBManager.php');

// Définition des en-têtes CORS
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

// Création d'une instance de EauDBManager
$wrk = new EauDBManager();

/**
 * Renvoie toutes les eaux
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == "getAll") {
    $return = $wrk->getAll();
    if ($return !== null) {
        http_response_code(200);
        echo $return;
    } else {
        http_response_code(404);
        echo json_encode(['success' => false]);
    }
    exit;
}

/**
 * Ajoute l'eau à la base de données si la requête vient d'un admin
 */
if (isset($_POST["action"]) && $_POST['action'] == "addEau") {
    
    $reponse = json_encode(['success' => false]);

    if (isset($_POST['nomEau'], $_SESSION['estAdmin'])) {
        if ($_SESSION['estAdmin'] == 1) {
            $return = $wrk->addEau($_POST['nomEau'], $_POST['description']);
            if ($return !== null) {
                http_response_code(201);
                $reponse = json_encode(['success' => true]);
            } else {
                http_response_code(404);
            }
        }
    } else {
        http_response_code(401);
    }
    echo $reponse;
    exit;
}
?>
