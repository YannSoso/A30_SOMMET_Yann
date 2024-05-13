<?php
require_once('workers/configConnexion.php');
//AJOUTER LES INCLUDES NECESSAIRES AUX TEST DES FONCTIONS WORKER
require_once('workers/CommentaireDBManager.php');
require_once('workers/EauDBManager.php');
require_once('workers/LoginDBManager.php');
//require_once('workers/connexion.php');
/*
require_once('controllers/commentaireManager.php');
require_once('controllers/eauManager.php');
require_once('controllers/loginManager.php');
require_once('controllers/SessionManager.php');

require_once('beans/Commentaire.php');
require_once('beans/Eau.php');
*/

//----------------------------------TESTS CONNEXION Server MySQL et DB---------------------------------------
echo "<h1> TESTS CONNEXION Server MySQL et DB </h1>";
echo "<hr>";
$_SESSION['pkUser'] = 1;
$_SESSION['admins'] = "admins";
$_SESSION['estAdmin'] = 2;
try {
    /*
       $pdo = new PDO(
           'mysql:host=localhost:3306;dbname=hockey_stats;charset=utf8',
           'root',            
           ''  
           );
       */
    //avec les constantes définies dans le fichier configConnexion
    $pdo = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_PERSISTENT => true
    )
    );
    echo "Connexion successfull <br>";
} catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
 
$attributes = array(
    "CLIENT_VERSION",
    "CONNECTION_STATUS",
    "SERVER_VERSION"
);
foreach ($attributes as $val) {
    echo "PDO::ATTR_$val: ";
    echo $pdo->getAttribute(constant("PDO::ATTR_$val")) . "<br>";
}
 
//----------------------------------------------------TESTS Database---------------------------------------
echo '<h1> TEST Database ' . DB_NAME . '</h1>';
echo "<hr>";
//VALUES TO CHANGE
//VALUES TO CHANGE
$tableName = "t_eau";
$columnName = "nom";
 
echo "<h4>Query simple sur table $tableName</h4>";
$statement = $pdo->query("SELECT * FROM $tableName");
 
while (($row = $statement->fetch())) {
    echo $row[$columnName] . '<br>';
}
;
 
$tableName = "t_user";
$columnName = "username";
 
echo "<h4>Query simple sur table $tableName</h4>";
$statement = $pdo->query("SELECT * FROM $tableName");
 
while (($row = $statement->fetch())) {
    echo $row[$columnName] . '<br>';
}
;
$pdo = NULL;
 
$query = connexion::getInstance()->SelectQuery("SELECT * FROM t_eau", null);
foreach ($query as $row) {
    var_dump($row['PK_eau']);
    echo $row['PK_eau'];
}
 
//----------------------------------------------------TESTS Fonction worker commentaire---------------------------------------
echo '<h1> TEST Fonctions Worker commentaire</h1>';
echo "<hr>";
 /*
$wrk = new CommentaireDBManager();
//METHODE TO CHANGE
//$results = $wrk->addCommentaire("Excellent", 2);
//echo "Resultat ajout commentaire =>" . $results . "<br>";
 
$results = $wrk->deleteCommentaire(181);
echo "resultat delete : " . $results . "<br>";
 
echo $wrk->getAll(1);
   
 
 
 
$result = $wrk->updateCommentaire(66, "Olalal");
echo "resultat modif = " . $result . "<br>";
//----------------------------------------------------TESTS Fonction worker eau---------------------------------------
echo '<h1> TEST Fonctions Worker eau</h1>';
echo "<hr>";
 
$wrk = new EauDBManager();
//METHODE TO CHANGE
//$results = $wrk->addEau("Test", "Mekebion");
echo "Resultat ajout eau =>" . $results . "<br>";
 
 
echo $wrk->getAll();
 
//$results = $wrk->deleteEau(7);
echo "<br>";
echo "resultat delete : " . $results . "<br>";

//----------------------------------------------------TESTS Fonction worker login---------------------------------------
echo '<h1> TEST Fonctions Worker login</h1>';
echo "<hr>";

$wrk = new LoginDBManager();
//METHODE TO CHANGE

$results = $wrk->checkLogin("Yannou", "C'estLeMdp-.");
echo "Resultat check login =>" . $results . "<br>";

$results = $wrk->checkLogin("Yannousss", "C'estLeMdp-.");
echo "Resultat check login =>" . $results . "<br>";
*/
echo '<h1> TEST HACHAGE </h1>';
echo password_hash("Emf123", PASSWORD_DEFAULT);
echo "<br>";
echo password_hash("C'estLeMdp-.", PASSWORD_DEFAULT);
echo "<br>";
echo password_hash("Simon joseMourihnoL'OG", PASSWORD_DEFAULT);
echo "<br>";
echo password_hash("Pour être fier, il faut.", PASSWORD_DEFAULT);
echo "<br>";
?>