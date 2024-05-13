/*
  Auteur : Yann Sommet
  Date :   16.06.2023 / V2.0
  Description : Controleur de la page des equipages
*/

//Classe du controleur de la page des equipages
class DetailEau {
    constructor(idEau, image, nom, description) {
        $("html, body").scrollTop(0);
        this.wrk = new HttpService();
        this.wrk.getCommentaireByEau(idEau, this.afficherCommentaire.bind(this));
        $("#home1").click(() => {
            indexCtrl.loadAccueil();
        });

        $("#ajoutCommentaireBtn").click(() => {
            var $valeurCom = document.getElementById('ajoutCommentaire').value;
            if (($valeurCom !== null) && ($valeurCom !== "")) {
                this.wrk.addCommentaire(idEau, $valeurCom, this.ajouterCommentaire.bind(this), (error) => {
                    if (error.unauthorized === true) {
                        alert("Vous devez être connecté pour accéder à cette option");
                    } else {
                        alert("Une erreur s'est produite lors de la mise à jour du commentaire : " + error.message);
                    }
                });
            } else {
                alert("Entré une valeur");
            }
        });

        // Afficher l'image dans la balise imgEau
        if (image !== null) {
            $("#imgEau").attr('src', 'data:image/jpeg;base64,' + image);
        } else {
            $("#imgEau").attr('src', "img/lodibidon.png")
        }

        // Afficher le nom dans la balise nomEau
        $("#nomEau").text(nom);

        // Créer le div containerInfosEau et afficher la description dedans
        const containerInfosEau = $("#containerInfosEau");
        if (description != null) {
            containerInfosEau.append("<p>Description : " + description + "</p>");
        } else {
            containerInfosEau.append("<p>Description : Pas encore de description</p>");
        }
    }

    afficherCommentaire(data) {
        const containerCommentaireEau = $("#commentaireEau");

        if (data && data.length > 0) {
            data.forEach(commentaire => {
                const idCommentaire = commentaire.pk_Commentaire;
                const commentaireDiv = $("<div class='commentaireEau' id='" + idCommentaire + "Commentaire'>" +
                    "<p class='clicParagraphe'>" + commentaire.commentaire + "</p>" +
                    "<input type='text' class='commentaireInput hidden' id='" + idCommentaire + "Input' value='" + commentaire.commentaire + "'/>" +
                    "<button class='modifierBtn hidden' id='" + idCommentaire + "BtnModifier'>Modifier Commentaire</button>" +
                    "<button class='effacerBtn hidden' id='" + idCommentaire + "BtnEffacer' data-commentaire-id='" + idCommentaire + "'>Effacer Commentaire</button>" +
                    "</div>");

                containerCommentaireEau.append(commentaireDiv);

                commentaireDiv.find('.clicParagraphe').click(() => {
                    const idBtnEffacer = '#' + idCommentaire + 'BtnEffacer';
                    const idBtnModifier = '#' + idCommentaire + 'BtnModifier';
                    const idInputCommentaire = '#' + idCommentaire + 'Input';

                    $(idBtnEffacer).toggleClass('hidden');
                    $(idBtnModifier).toggleClass('hidden');
                    $(idInputCommentaire).toggleClass('hidden');
                });

                commentaireDiv.on('click', '.effacerBtn', function (event) {
                    event.stopPropagation();
                    this.wrk = new HttpService();
                    const idCommentaireASupprimer = $(this).data('commentaire-id');
                    this.wrk.deleteCommentaire(
                        idCommentaireASupprimer,
                        (resultat) => {
                            if (resultat.success === true) {
                                alert("Le commentaire a été effacé");
                                location.reload();
                            } else {
                                alert("Le commentaire n'a pas pu être effacé");
                            }
                        },
                        (error) => {
                            if (error.unauthorized === true) {
                                alert("Vous n'avez pas les droits pour effacer ce commentaire");
                            } else {
                                alert("Une erreur s'est produite lors de la mise à jour du commentaire : " + error.message);
                            }
                        }
                    );
                });

                commentaireDiv.on('click', '.modifierBtn', function (event) {
                    event.stopPropagation();
                    const nouveauCommentaire = $('#' + idCommentaire + 'Input').val();
                    this.wrk = new HttpService();
                    if (commentaire.commentaire != nouveauCommentaire) {
                        this.wrk.updateCommentaire(
                            idCommentaire,
                            nouveauCommentaire,
                            (resultat) => {
                                if (resultat.success === true) {
                                    alert("Le commentaire a été modifié");
                                    location.reload();
                                } else {
                                    alert("Le commentaire n'a pas pu être modifié");
                                }
                            },
                            (error) => {
                                if (error.unauthorized === true) {
                                    alert("Vous n'avez pas les droits pour modifier ce commentaire");
                                } else {
                                    alert("Une erreur s'est produite lors de la mise à jour du commentaire : " + error.message);
                                }
                            }
                        );
                    } else {
                        alert("Le commentaire doit d'abord être modifier !!");
                    }
                });
            });



        } else {
            containerCommentaireEau.append("<div class='commentaireEau'><p>Pas de Commentaire</p></div>");
        }
    }

    ajouterCommentaire(resultat) {
        if (resultat.success === true) {
            alert("Le commentaire a été ajouté");
            location.reload();
            indexCtrl.loadEau(idEau, image, nom, description);
        } else {
            alert("Le commentaire n'a pas pu etre ajouté");
        }
    }

}
