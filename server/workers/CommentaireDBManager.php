<?php
/**
 * Gestion des commentaires dans la base de données
 *
 * Cette classe gère les opérations CRUD (Create, Read, Update, Delete) pour les commentaires dans la base de données.
 * Elle permet d'ajouter, de récupérer, de supprimer et de mettre à jour les commentaires associés à une eau.
 *
 * @version 1.0
 * @author Yann Sommet
 */

include_once("connexion.php");
include_once("../beans/Commentaire.php");

class CommentaireDBManager
{

    /**
     * Ajoute un nouveau commentaire dans la base de données
     *
     * @param string $commentaire Le contenu du commentaire
     * @param int $pfkEau La clé étrangère de l'eau associée au commentaire
     * @param int $pfkUser La clé étrangère de l'utilisateur qui a posté le commentaire
     * @return bool Retourne true si l'ajout est réussi, sinon false
     */
    public function addCommentaire($commentaire, $pfkEau, $pfkUser)
    {
        $query = "INSERT INTO tr_eau_user (PK_commentaire, PFK_eau, PFK_user, commentaire) VALUES (NULL, :PFK_eau, :PFK_user, :com)";
        $params = array('PFK_eau' => htmlspecialchars($pfkEau), 'PFK_user' => htmlspecialchars($pfkUser), 'com' => htmlspecialchars($commentaire));
        $res = connexion::getInstance()->executeQuery($query, $params);
        return $res;
    }

    /**
     * Supprime un commentaire de la base de données si l'utilisateur a les autorisations nécessaires
     *
     * @param int $pkCommentaire La clé primaire du commentaire à supprimer
     * @return bool Retourne true si la suppression est réussie, sinon false
     */
    public function deleteCommentaire($pkCommentaire)
    {
        $res = false;

        if ($this->checkModifOK($pkCommentaire) == true){
            $query = "DELETE FROM tr_eau_user WHERE PK_commentaire = :pkCommentaire";
            $params = array('pkCommentaire' => htmlspecialchars($pkCommentaire));
            $res = connexion::getInstance()->executeQuery($query, $params);
        }
        return $res;
    }

    /**
     * Récupère tous les commentaires associés à une eau donnée depuis la base de données
     *
     * @param int $pfkEau La clé étrangère de l'eau pour laquelle récupérer les commentaires
     * @return string|null Retourne une chaîne JSON contenant les commentaires récupérés ou null si aucune donnée n'est trouvée
     */
    public function getAll($pfkEau)
    {
        $liste = array();

        $query = connexion::getInstance()->selectQuery("SELECT * FROM tr_eau_user WHERE PFK_eau = :pfk_eau", array('pfk_eau' => htmlspecialchars($pfkEau)));
        foreach ($query as $row) {
            $commentaire = new Commentaire($row['PK_commentaire'], $row['PFK_eau'], $row['PFK_user'], $row['commentaire']);
            array_push($liste, $commentaire);
        }

        $listeJSON = json_encode($liste);
        return $listeJSON;
    }

    /**
     * Met à jour le contenu d'un commentaire dans la base de données si l'utilisateur a les autorisations nécessaires
     *
     * @param int $pkCommentaire La clé primaire du commentaire à mettre à jour
     * @param string $commentaire Le nouveau contenu du commentaire
     * @return bool|null Retourne true si la mise à jour est réussie, sinon null
     */
    public function updateCommentaire($pkCommentaire, $commentaire)
    {
        $res = null;
        if ($this->checkModifOK($pkCommentaire) == true) {
            $query = "UPDATE tr_eau_user SET commentaire = :com WHERE PK_commentaire = :pk";
            $params = array('com' => htmlspecialchars($commentaire), 'pk' => htmlspecialchars($pkCommentaire));
            $res = connexion::getInstance()->executeQuery($query, $params);
        }
        return $res;
    }

    /**
     * Vérifie si l'utilisateur a les autorisations nécessaires pour modifier ou supprimer un commentaire
     *
     * @param int $pkCommentaire La clé primaire du commentaire à vérifier
     * @return bool Retourne true si l'utilisateur a les autorisations, sinon false
     */
    public function checkModifOK($pkCommentaire)
    {
        $return = false;
        $query0 = connexion::getInstance()->selectQuery("SELECT PFK_user FROM tr_eau_user WHERE PK_commentaire = :com", array('com' => $pkCommentaire));
        if (isset($_SESSION['pkUser']) && isset($query0[0]['PFK_user'])) {
            if ($query0[0]['PFK_user'] == $_SESSION['pkUser'] || $_SESSION['estAdmin'] == true) {
                $return = true;
            }
        }
        return $return;  
    }
}
?>
