<?php
/**
 * Gestion de l'authentification des utilisateurs
 *
 * Cette classe contient les méthodes pour vérifier les informations de connexion des utilisateurs et ouvrir une session si les informations sont correctes.
 *
 * @version 1.0
 * @author Yann Sommet
 */

include_once("connexion.php");
include_once("../beans/User.php");
include_once("../controllers/SessionManager.php");

class LoginDBManager{

    /**
     * Vérifie si le nom d'utilisateur et le mot de passe sont corrects, puis ouvre une session si les informations sont valides.
     *
     * @param string $user Le nom d'utilisateur
     * @param string $password Le mot de passe
     * @return bool Retourne true si les informations de connexion sont correctes, sinon false
     */
    public function checkLogin($user,$password){
        $return = false;
        $query = connexion::getInstance()->selectQuery("SELECT * FROM t_user", null);

        foreach ($query as $row) {

            if ($row["username"] == $user) {
                if (password_verify($password ,$row["password"])) {
                    $return = true;
                    $ses = new SessionManager();
                    $ses->openSession($user, $row['PK_user'], $row['estAdmin']);
                }
            }
        }
        return $return;
    }

    /*
     public function getUser($username,$password){
        $return = null;
        $query = connexion::getInstance()->SelectQuery("SELECT * FROM t_user", null);
        foreach ($query as $row) {
            if ($row["username"] == $username) {
                if ($row["password"] == $password) {
                    $user = new User($row["PK_user"], $row["username"], $row["password"], $row['estAdmin']);
                    $ses = new SessionManager();
                    $ses->openSession($username, $row['PK_user'], $row['estAdmin']);
                    $return = json_encode($user);
                }
            }
        }
        return $return;
    }
    */
}
?>
