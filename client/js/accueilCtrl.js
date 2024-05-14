/*     
  Auteur : Yann Sommet
  Date :   16.06.2023 / V1.0
  Description : Controleur de la page d'accueil
*/

//Classe permettant de gérer l'affichage de la page d'accueil
class AccueilCtrl {
  //Le constructeur va initialiser le service http et va appeler la fonction afficherAccueil. Il va également ajouter un écouteur d'événement sur le click du logo.
  constructor() {
    this.wrk = new HttpService();
    this.wrk.getEau(this.afficherAccueil.bind(this));
    $("#login").click(() => {
      indexCtrl.loadLogin();
    });

    $("#fileChooser").on("change", this.readFiles.bind(this));

    $("#ajouterEau").click(() => {
      var nomEau = document.getElementById('nomAjouter').value;
      var description = document.getElementById('descriptionAjouter').value;
      this.wrk = new HttpService();
      this.wrk.addEau(nomEau, description, this.ajouterEau.bind(this), (error) => {
        if (error.unauthorized === true) {
          alert("Vous n'avez pas les droits pour ajouter une eau");
        } else {
          alert("Une erreur s'est produite lors de la mise à jour du commentaire : " + error.message);
        }
      });
    });


  }

  readFiles() {
    var files = document.getElementById('fileChooser').files;
    var target = document.getElementById('target');
    target.innerHTML = '';

    if (files.length > 0) {
        var item = document.createElement('div');
        item.setAttribute('data-idx', 0); // Utiliser 0 pour la première image
        var file = files[0]; // Utiliser le premier fichier sélectionné

        var reader = new FileReader();
        reader.addEventListener('load', this.getReadFile(reader, 0, file).bind(this));
        reader.readAsDataURL(file);

        target.appendChild(item);
    }
}

getReadFile(reader, index, file) {
    return function () {
        var div = document.querySelector('[data-idx="' + index + '"]');

        if (file.type === 'image/png') {
            var img = document.createElement('img');
            img.src = reader.result;
            div.appendChild(img);
        }
    }
}


  afficherAccueil(data) {
    // Assure-toi que le conteneurEau est vide avant d'ajouter de nouveaux éléments
    $("#containerEau").empty();

    // Crée les conteneurs pour les eaux à gauche et à droite


    data.forEach(eau => {
      var containerEauMarque = $("<div class='containerEauMarque'></div>");
      // Crée un div pour chaque eau avec la classe "eauDiv"
      var eauDiv = $("<div class='eauDiv'></div>");

      if (eau.image != null) {
        // Ajoute l'image à l'élément div
        eauDiv.append('<div><img class="imgEau" src="data:image/jpeg;base64,' + eau.image + '" alt="image-eau"></div>');
      } else {
        eauDiv.append('<div><img class="imgEau" src="img/lodibidon.png" alt="image-eau"></div>')
      }
      // Ajoute un événement de clic à l'élément div
      eauDiv.click(function () {
        // Toggle la classe "agrandi" pour agrandir ou réduire le div
        $(this).toggleClass("agrandi");

        // Si le div est agrandi, affiche le nom de l'eau
        if ($(this).hasClass("agrandi")) {
          $(this).append("<p class='EcritureEau' id='" + eau.pk_eau + "'>" + eau.nom + "</p>");
          $("#" + eau.pk_eau).click(function () {

            indexCtrl.loadEau(eau.pk_eau, eau.image, eau.nom, eau.description);
          });
        } else {
          // Si le div est réduit, retire le paragraphe avec le nom
          $(this).find("p").remove();
        }
      });

      // Ajoute l'élément div au conteneurEauGauche ou conteneurEauDroite en alternance
      containerEauMarque.append(eauDiv);
      $("#containerEau").append(containerEauMarque);

    });

  }

  ajouterEau(resultat) {
    if (resultat.success === true) {
      alert("L'eau est ajouté");
      location.reload();
    } else {
      alert("L'eau n'a pas pu etre ajouté");
    }
  }

}