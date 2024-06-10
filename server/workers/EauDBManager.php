<?php
/**
 * Gestion des opérations sur les eaux en base de données
 *
 * Cette classe contient les méthodes pour ajouter, supprimer et récupérer des informations sur les eaux dans la base de données.
 *
 * @version 1.0
 * @author Yann Sommet
 */

include_once ("../beans/Eau.php");
include_once ("connexion.php");

class EauDBManager
{

    /**
     * Ajoute une eau dans la base de données (sans image).
     *
     * @param string $nom Le nom de la marque d'eau à ajouter
     * @param string $description La description de l'eau à ajouter
     * @return int|false Le nombre de lignes affectées par la requête ou false en cas d'erreur
     */
    public function addEau($nom, $description, $image)
    {
        $imageEncode = base64_encode($image);
        $query = "INSERT INTO t_eau (PK_eau, nom, description, image) values(NULL, :eau, :descr, :image)";
        $params = array('eau' => htmlspecialchars($nom), 'descr' => htmlspecialchars($description), 'image' => $imageEncode);
        $res = connexion::getInstance()->ExecuteQuery($query, $params);
        return $res;

    }

    /**
     * Supprime une eau de la base de données.
     *
     * @param int $pkEau La clé primaire de l'eau à supprimer
     * @return int|false Le nombre de lignes affectées par la requête ou false en cas d'erreur
     */
    public function deleteEau($pkEau)
    {
        $query = "DELETE from t_eau where PK_eau = :pkEau";
        $params = array('pkEau' => htmlspecialchars($pkEau));
        $res = connexion::getInstance()->ExecuteQuery($query, $params);
        return $res;
    }

    /**
     * Récupère toutes les eaux de la base de données.
     *
     * @return string|null La liste des eaux au format JSON ou null en cas d'erreur
     */
    public function getAll()
    {
        $liste = array();

        $query = connexion::getInstance()->SelectQuery("SELECT * FROM t_eau", null);
        foreach ($query as $row) {
            /*             if (isset($row["image"])) {
                            $imageBase64 = base64_encode($row['image']);
                        } else {
                            $imageBase64 = null;
                        } */

            // Créer l'objet Eau en incluant l'image convertie
            $eau = new Eau($row['PK_eau'], $row['image'], $row['nom'], $row['description']);
            array_push($liste, $eau);
        }
        $listeJSON = json_encode($liste);
        return $listeJSON;
    }
}
?>