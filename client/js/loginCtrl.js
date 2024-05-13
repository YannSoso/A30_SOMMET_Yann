/*
  Auteur : Yann Sommet
  Date :   16.06.2023 / V2.0
  Description : Contrôleur de la page de connexion
*/

// Classe permettant de gérer la page de connexion
class LoginCtrl {
    // Le constructeur initialise le service HTTP et appelle la fonction pour vérifier la connexion.
    // Il ajoute également un écouteur d'événement sur le clic du bouton de connexion.
    constructor() {
        this.wrk = new HttpService();
        $("#login").click(() => {
            var username = $("#username").val();
            var password = $("#password").val();

            if (username && password) {
                this.wrk.checkLogin(username, password, this.checkConnect.bind(this), this.errorLogin.bind(this));
            } else {
                alert("Veuillez saisir votre nom d'utilisateur et votre mot de passe.");
            }
        });

        $("#home2").click(() => {
            indexCtrl.loadAccueil();
        });
    }

    // Fonction de rappel en cas de succès de la connexion
    checkConnect(resultat) {
        var username = $("#username").val();
        if (resultat.success) {
            alert("Vous êtes connecté en tant que " + username);
            indexCtrl.loadAccueil();
        } else {
            alert("Mauvais identifiants !");
        }
    }

    // Fonction de rappel en cas d'erreur de connexion
    errorLogin() {
        alert("Mauvais identifiants !");
    }
}
