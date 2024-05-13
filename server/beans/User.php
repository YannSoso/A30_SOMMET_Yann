<?php
/**
 * Classe User
 *
 * Cette classe représente un utilisateur.
 *
 * @version 1.0
 * @author Yann Sommet
 */
class User implements JsonSerializable
{
    /**
     * Variable représentant le pk de l'utilisateur
     * @access private
     * @var integer
     */
    private $pk_user;

    /**
     * Variable représentant le nom d'utilisateur
     * @access private
     * @var string
     */
    private $username;

    /**
     * Variable représentant le mot de passe de l'utilisateur
     * @access private
     * @var string
     */
    private $pwd;

    /**
     * Variable représentant le statut d'administrateur de l'utilisateur
     * @access private
     * @var integer
     */
    private $estAdmin;

    /**
     * Constructeur de la classe User
     *
     * @param int $pk_user PK de l'utilisateur
     * @param string $username Nom d'utilisateur
     * @param string $pwd Mot de passe de l'utilisateur
     * @param int $estAdmin Statut d'administrateur de l'utilisateur
     */
    public function __construct($pk_user, $username, $pwd, $estAdmin)
    {
        $this->pk_user = $pk_user;
        $this->username = $username;
        $this->pwd = $pwd;
        $this->estAdmin = $estAdmin;
    }

    /**
     * Méthode redéfinie pour l'implémentation de l'interface JsonSerializable
     *
     * @return array Les données sérialisées au format JSON
     */
    public function jsonSerialize(): array
    {
        return [
            'pk_user' => $this->getPkUser(),
            'username' => $this->getUserName(),
            'pwd' => $this->getPwd(),
            'estAdmin' => $this->isAdmin()

        ];
    }

    /**
     * Fonction qui retourne le pk de l'utilisateur.
     *
     * @return int Le pk de l'utilisateur.
     */
    public function getPkUser()
    {
        return $this->pk_user;
    }

    /**
     * Fonction qui retourne le nom d'utilisateur.
     *
     * @return string Le nom d'utilisateur.
     */
    public function getUserName()
    {
        $return = $this->username;
        if(isset($return)){
         iconv(mb_detect_encoding($this->username), 'UTF-8', $this->username);
        }else{
            $return = null;
        }
        return $return;
    }

    /**
     * Fonction qui retourne le mot de passe de l'utilisateur.
     *
     * @return string Le mot de passe de l'utilisateur.
     */
    public function getPwd()
    {
        return iconv(mb_detect_encoding($this->pwd), 'UTF-8', $this->pwd);
    }

    /**
     * Fonction qui vérifie si l'utilisateur est administrateur.
     *
     * @return int Le statut d'administrateur de l'utilisateur (0 ou 1).
     */
    public function isAdmin()
    {
        return $this->estAdmin;
    }
}
?>
