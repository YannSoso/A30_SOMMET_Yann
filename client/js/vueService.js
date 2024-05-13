/*
 * Service de gestion des vues
 * @author Jean-Claude Stritt / modif Yann Sommet (rien n'a été modifié)
 */
class VueService {
    constructor() {}
  
      chargerVue(vue, callback) {
  
      // charger la vue demandee
      $("#view").load("views/" + vue + ".html", function () {
  
        // si une fonction de callback est spécifiée, on l'appelle ici
        if (typeof callback !== "undefined") {
          callback();
        }
  
      });
    }
  
  }
  