<?php
/**
 * Classe Eau
 *
 * Cette classe représente une eau (marque).
 *
 * @version 1.0
 * @author Yann Sommet
 */
class Eau implements JsonSerializable
{
    /**
     * Variable représentant le pk de l'eau
     * @access private
     * @var integer
     */
    private $pk_eau;

    /**
     * Variable représentant le nom de l'eau
     * @access private
     * @var string
     */
    private $nom;

    /**
     * Variable représentant l'image de l'eau
     * @access private
     * @var string
     */
    private $image;

    /**
     * Variable représentant la description
     * @access private
     * @var string
     */
    private $description;

    /**
     * Constructeur de la classe eau
     *
     * @param int $pk_eau PK de l'eau
     * @param string $image Chemin vers l'image de la bouteille
     * @param string $nom Nom de la marque d'eau
     * @param string $description Description de l'eau
     */
    public function __construct($pk_eau, $image, $nom, $description)
    {
        $this->pk_eau = $pk_eau;
        $this->image = $image;
        $this->nom = $nom;
        $this->description = $description;

    }

    /**
     * Méthode redéfinie pour l'implémentation de l'interface JsonSerializable
     *
     * @return array Les données sérialisées au format JSON
     */
    public function jsonSerialize(): array
    {
        return [
            'pk_eau' => $this->getPkEau(),
            'image' => $this->getImage(),
            'description' => $this->getDescription(),
            'nom' => $this->getNom()

        ];
    }


    /**
     * Fonction qui retourne la description de l'eau.
     *
     * @return string La description de l'eau.
     */
    public function getDescription()
    {
        $return = $this->description;
        if(isset($return)){
         iconv(mb_detect_encoding($this->description), 'UTF-8', $this->description);
        }else{
            $return = null;
        }
        return $return;
    }

    /**
     * Fonction qui retourne la pk de l'eau.
     *
     * @return int La pk de l'eau.
     */
    public function getPkEau()
    {
        return $this->pk_eau;
    }

    /**
     * Fonction qui retourne l'image de l'eau.
     *
     * @return string Le chemin vers l'image de l'eau.
     */
    public function getImage()
    {
        $return = $this->image;
        if(isset($return)){
         $return = iconv(mb_detect_encoding($this->image), 'UTF-8', $this->image);
        }
        return $return;
    }

    /**
     * Fonction qui retourne le nom de l'eau.
     *
     * @return string Le nom de la marque d'eau.
     */
    public function getNom()
    {
        return iconv(mb_detect_encoding($this->nom), 'UTF-8', $this->nom);
    }
}
?>
