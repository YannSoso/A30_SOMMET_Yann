<?php
//require_once('workers/configConnexion.php');
//AJOUTER LES INCLUDES NECESSAIRES AUX TEST DES FONCTIONS WORKER
//require_once('workers/CommentaireDBManager.php');
require_once('workers/EauDBManager.php');
//require_once('workers/LoginDBManager.php');
//require_once('workers/connexion.php');
/*
require_once('controllers/commentaireManager.php');
require_once('controllers/eauManager.php');
require_once('controllers/loginManager.php');
require_once('controllers/SessionManager.php');

require_once('beans/Commentaire.php');
require_once('beans/Eau.php');
*/
/*
echo '<h1> TEST Fonctions Commentaire</h1>';
$wrk = new CommentaireDBManager();

$imagePath = "../client/img/home.png";
$imageContent = file_get_contents($imagePath);

//$results = $wrk->addCommentaireVideo($encodedImage, 1, 1);

//echo "Resultat addCommentaireVideo =>" . $results . "<br>";

$results = $wrk->updateCommentaire(12,"C'est un commentaire de test");
echo "Resultat updateCommentaireVideo =>" . $results . "<br>";
*/
echo '<h1> TEST Fonctions Eau</h1>';
$wrk = new EauDBManager();

$imagePath = "../client/img/home.png";
$imageContent = file_get_contents($imagePath);

$results = $wrk->addEau("Evian", "C'est une eau de source", $imageContent);

echo "Resultat addEau =>" . $results . "<br>";  

/*
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