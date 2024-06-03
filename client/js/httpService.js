var BASE_URL = "http://localhost/A30_SOMMET_YANN/server/controllers/";
//var BASE_URL = "https://sommety.emf-informatique.ch/151/projet/server/controllers/";
/*
 *  Date :   16.06.2023 / V3.0
 * @author Jean-Claude Stritt / modif Yann Sommet
 * description : Couche de services HTTP (worker).
 */
class HttpService {

  constructor() { }



  getEau(successCallback) {
    $.ajax({
      type: "GET",
      dataType: "json",
      url: BASE_URL + "eauManager.php",
      data: "action=getAll",
      success: successCallback
    });
  }

  deleteEau(idEau, successCallback) {
    $.ajax({
      type: "DELETE",
      dataType: "json",
      url: BASE_URL + "eauManager.php",
      data: 'action=deleteEau&pkEau=' + idEau,
      success: successCallback
    });
  }

  addEau(nomEau, description, image, successCallback, errorCallback) {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: BASE_URL + "eauManager.php",
      data: 'action=addEau&nomEau=' + nomEau + '&description=' + description + '&image=' + image,
      success: successCallback,
      error: function(xhr, status, error) {
        if (xhr.status === 401) {
          errorCallback({ unauthorized: true });
        } else {
          errorCallback(xhr.responseJSON);
        }
      }
    });
  }

  checkLogin(user, pwd, successCallback, errorCallback) {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: BASE_URL + "loginManager.php",
      data: 'action=checkLogin&user=' + user + '&pwd=' + pwd,
      success: successCallback,
      error: errorCallback
    });
  }

  disconnect(successCallback) {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: BASE_URL + "loginManager.php",
      data: 'action=disconnect',
      success: successCallback,
      error: errorCallback
    });
  }

  getCommentaireByEau(idEau, successCallback) {
    $.ajax({
      type: "GET",
      dataType: "json",
      url: BASE_URL + "commentaireManager.php",
      data: 'action=getAll&pfkEau=' + idEau,
      success: successCallback,
    });
  }

  deleteCommentaire(pkCom, successCallback, errorCallback) {
    $.ajax({
      type: "DELETE",
      dataType: "json",
      url: BASE_URL + "commentaireManager.php",
      data: {
        action: "deleteCommentaire",
        pkCommentaire: pkCom
      },
      success: successCallback,
      error: function(xhr, status, error) {
        if (xhr.status === 401) {
          errorCallback({ unauthorized: true });
        } else {
          errorCallback(xhr.responseJSON);
        }
      }
    });
  }

  addCommentaire(pkEau, commentaire, video, successCallback, errorCallback) {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: BASE_URL + "commentaireManager.php",
      data: 'action=addCommentaire&commentaire=' + commentaire + '&pfkEau=' + pkEau+ '&video=' + video,
      success: successCallback,
      error: function(xhr, status, error) {
        if (xhr.status === 401) {
          errorCallback({ unauthorized: true });
        } else {
          errorCallback(xhr.responseJSON);
        }
      }
    });
  }

  updateCommentaire(pkCommentaire, commentaire, successCallback, errorCallback) {
    $.ajax({
      type: "PUT",
      dataType: "json",
      url: BASE_URL + "commentaireManager.php",
      data: 'action=updateCommentaire&commentaire=' + commentaire + '&pkCommentaire=' + pkCommentaire,
      success: successCallback,
      error: function(xhr, status, error) {
        if (xhr.status === 401) {
          errorCallback({ unauthorized: true });
        } else {
          errorCallback(xhr.responseJSON);
        }
      }
    });
  }


}