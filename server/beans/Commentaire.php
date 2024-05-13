<?php
/**
 * Classe Commentaire
 *
 * Cette classe représente un commentaire.
 *
 * @version 1.0
 * @author Yann Sommet
 */
class Commentaire implements JsonSerializable
{
  /**
   * Variable représentant le pk du commentaire
   * @access private
   * @var integer
   */
  private $pk_commentaire;
  
  /**
   * Variable représentant la pfk de l'eau
   * @access private
   * @var integer
   */
  private $pfk_eau;

  /**
   * Variable représentant la pfk de l'utilisateur
   * @access private
   * @var integer
   */
  private $pfk_user;

  /**
   * Variable représentant le commentaire
   * @access private
   * @var string
   */
  private $commentaire;

  /**
   * Constructeur de la classe Commentaire
   *
   * @param int $pk_Commentaire PK du Commentaire
   * @param int $pfk_eau PFK de l'eau
   * @param int $pfk_user PFK de l'utilisateur
   * @param string $commentaire commentaire
   */
  public function __construct($pk_Commentaire, $pfk_eau, $pfk_user, $commentaire)
  {
    $this->pk_commentaire = $pk_Commentaire;
    $this->pfk_eau = $pfk_eau;
    $this->pfk_user = $pfk_user;
    $this->commentaire = $commentaire;
  }

  /**
   * Méthode redéfinie pour l'implémentation de l'interface JsonSerializable
   *
   * @return array Les données sérialisées au format JSON
   */
  public function jsonSerialize(): array
  {
    return [
      'pk_Commentaire' => $this->getPkCommentaire(),
      'pfk_eau' => $this->getPfkEau(),
      'pfk_user' => $this->getPfkUser(),
      'commentaire' => $this->getCommentaire()

    ];
  }


  /**
   * Fonction qui retourne le commentaire.
   *
   * @return string Le commentaire choisi.
   */
  public function getCommentaire()
  {
    return iconv(mb_detect_encoding($this->commentaire), 'UTF-8', $this->commentaire);
  }

  /**
   * Fonction qui retourne la pk du commentaire.
   *
   * @return int La pk du commentaire.
   */
  public function getPkCommentaire()
  {
    return $this->pk_commentaire;
  }

  /**
   * Fonction qui retourne la pfk de l'eau.
   *
   * @return int La pfk de l'eau.
   */
  public function getPfkEau()
  {
    return $this->pfk_eau;
  }

  /**
   * Fonction qui retourne la pfk de l'utilisateur.
   *
   * @return int La pfk de l'utilisateur.
   */
  public function getPfkUser()
  {
    return $this->pfk_user;
  }
}
?>
