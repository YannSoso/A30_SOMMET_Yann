/*
  Auteur : Yann Sommet
  Date :   16.06.2023 / V2.0
  Description : Crontroleur principal de l'application
*/

//Fonction ready de jQuery qui va être appelée lorsque la page est chargée
$().ready(function () {

    // service et indexCtrl sont des variables globales qui doivent être accessible depuis partout => pas de mot clé devant ou window.xxx
    http = new HttpService();
    indexCtrl = new IndexCtrl();  // ctrl principal

    // affichage de la date avec une petite surpirse le 1er du mois
    let date = new Date();
    let jour = date.getDate();
    if (jour === 1) {
        $("#date").text("Wake up, it's the first of the month");
    } else {
        let mois = date.getMonth() + 1;
        let annee = date.getFullYear();
        let dateActuelle = jour + "." + mois + "." + annee;
        $("#date").text(dateActuelle);
    }
});

//class de l'index controlleur
class IndexCtrl {
    //Constructeur de la classe, il va initialiser le service vue et va appeler la fonction loadAccueil
    constructor() {
        this.vue = new VueService();
        this.loadAccueil();
    }

    // appel de la vue accueil
    loadAccueil() {
        this.vue.chargerVue("accueil", () => new AccueilCtrl());
    }

    // appel de la vue de l'eau
    loadEau(idEau, image, nom, description) {
        this.vue.chargerVue("detailEau", function () {
            new DetailEau(idEau, image, nom, description);
        });
    }

    // appel de la vue login
    loadLogin() {
        this.vue.chargerVue("login", function () {
            new LoginCtrl();
        });
    }

}