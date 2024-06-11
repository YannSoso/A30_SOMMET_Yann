<?php
/**
 * Gestion des commentaires
 *
 * Ce script gère les opérations CRUD (Create, Read, Update, Delete) pour les commentaires.
 * Il prend en charge l'ajout, la récupération, la mise à jour et la suppression des commentaires dans la base de données.
 *
 * @version 1.0
 * @author Yann Sommet
 */

session_start();

require_once ('../workers/CommentaireDBManager.php');

// Définition des en-têtes CORS
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

// Création d'une instance de CommentaireDBManager
$wrkCommentaire = new CommentaireDBManager();

/**
 * Efface le commentaire si l'utilisateur est admin ou si le commentaire lui appartient
 */
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);

    if (isset($_DELETE['action']) && $_DELETE['action'] == "deleteCommentaire") {
        $reponse = json_encode(['success' => false]);
        if (isset($_DELETE['pkCommentaire'])) {
            $return = $wrkCommentaire->deleteCommentaire($_DELETE['pkCommentaire']);

            if ($return === 1) {
                http_response_code(200);
                echo json_encode(['success' => true]);
            } else {
                http_response_code(401);
                echo json_encode(['success' => false]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false]);
        }
        exit;
    }
}

/**
 * Renvoie tous les commentaires d'une eau
 */
if (isset($_GET['action']) && $_GET['action'] == "getAll") {
    if (isset($_GET["pfkEau"])) {
        $return = $wrkCommentaire->getAll($_GET["pfkEau"]);
        if ($return !== null) {
            http_response_code(200);
            echo $return;
        } else {
            http_response_code(404);
        }
    } else {
        http_response_code(400);
    }
    exit;
}

/**
 * Ajoute le commentaire à la base de données si la requête vient d'un utilisateur
 */
if (isset($_POST['action']) && $_POST['action'] == "addCommentaire") {
    if (isset($_POST['pfkEau'], $_SESSION['pkUser']) && isset($_POST['commentaire'])) {
        $return = $wrkCommentaire->addCommentaire($_POST['commentaire'], $_POST['pfkEau'], $_SESSION['pkUser']);
        if ($return !== null) {
            http_response_code(201);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false]);
        }
    } else {
        http_response_code(401);
        echo json_encode(['success' => false]);
    }
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == "addCommentaireVideo") {
    if (isset($_POST['pfkEau'], $_SESSION['pkUser']) && ((isset($_POST['commentaire']) && isset($_POST['video'])) || isset($_POST['video']))) {
        // Initialisation de la variable de retour
        $return = null;

        if (isset($_POST['video'])) {
            $return = $wrkCommentaire->addCommentaireVideo($_POST['video'], $_POST['pfkEau'], $_SESSION['pkUser']);
        }

        // Vérification du résultat des opérations d'ajout
        if ($return !== null) {
            http_response_code(201);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false]);
        }
    } else {
        http_response_code(401);
        echo json_encode(['success' => false]);
    }
    exit;
}

/**
 * Modifie le commentaire s'il appartient à l'utilisateur
 */
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);

    if (isset($_PUT['action']) && $_PUT['action'] == "updateCommentaire") {
        $reponse = json_encode(['success' => false]);

        if (isset($_PUT['commentaire']) && (isset($_PUT['pkCommentaire']) || isset($_PUT['video']))) {
            if (isset($_PUT['video'])) {
                $return = $wrkCommentaire->updateCommentaireVideo($_PUT['pkCommentaire'], $_PUT['video']);
            } else if (isset($_PUT['commentaire'])) {
                $return = $wrkCommentaire->updateCommentaire($_PUT['pkCommentaire'], $_PUT['commentaire']);
            } else if (isset($_PUT['commentaire']) && isset($_PUT['video'])) {
                $return = $wrkCommentaire->updateCommentaireVideo($_PUT['pkCommentaire'], $_PUT['video']);
                if ($return !== null) {
                    $return = $wrkCommentaire->updateCommentaire($_PUT['pkCommentaire'], $_PUT['commentaire']);
                }
            }
            if ($return !== null) {
                http_response_code(200);
                $reponse = json_encode(['success' => true]);
            } else {
                http_response_code(401);
            }
        } else {
            http_response_code(400);
        }
        echo $reponse;
        exit;
    }
}
?>