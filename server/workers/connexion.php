<?php
/**
 * Gestion de la connexion à la base de données
 *
 * Cette classe implémente le modèle singleton pour gérer la connexion à la base de données.
 * Elle fournit des méthodes pour exécuter des requêtes SQL et récupérer les résultats.
 *
 * @version 1.0
 * @author Yann Sommet
 */

include_once("configConnexion.php");

class connexion
{
    /**
     * Instance de la connexion à la base de données (singleton)
     *
     * @var connexion
     */
    private static $connexion;

    /**
     * Objet PDO représentant la connexion à la base de données
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Constructeur privé pour empêcher l'instanciation directe de la classe
     */
    private function __construct() {
        try {
            // Initialisation de la connexion PDO avec les paramètres de configuration
            $this->pdo = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_PERSISTENT => true
            ));
        } catch (PDOException $e) {
            // En cas d'erreur lors de la connexion, affichage du message d'erreur et arrêt du script
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * Méthode statique pour obtenir l'instance unique de la connexion à la base de données
     *
     * @return connexion Instance de la connexion à la base de données
     */
    public static function getInstance(){

        if(!isset(self::$connexion)){
            self::$connexion = new connexion();
        }
        return self::$connexion;
    }

    /**
     * Exécute une requête SQL avec des paramètres donnés et retourne le nombre de lignes affectées
     *
     * @param string $query La requête SQL à exécuter
     * @param array $params Les paramètres de la requête sous forme de tableau associatif
     * @return int Le nombre de lignes affectées par la requête
     */
    public function executeQuery($query, $params){
        try {
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->execute($params);
            return $queryPrepared->rowCount();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * Exécute une requête de sélection SQL avec des paramètres donnés et retourne les résultats sous forme de tableau
     *
     * @param string $query La requête SQL de sélection à exécuter
     * @param array $params Les paramètres de la requête sous forme de tableau associatif
     * @return array|null Les résultats de la requête sous forme de tableau ou null en cas d'erreur
     */
    public function selectQuery($query, $params){
        try {
            $queryPrepared = $this->pdo->prepare($query);       
            $queryPrepared->execute($params);
            return $queryPrepared->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}
?>
