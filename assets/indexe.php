<?php

$host = 'localhost';
$dbname = 'tencobankdb';
$username = 'root';
$password = '';

if(isset($_POST['insert'])){

  try {
  // se connecter à mysql
  $pdo = new PDO("mysql:host=$host;dbname=$dbname","$username","$password");
  } catch (PDOException $exc) {
    echo $exc->getMessage();
    exit();
  }

  // récupérer les valeurs 
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];

  // Requête mysql pour insérer des données
  $sql = "INSERT INTO `users`(`firstname`, `lastname`) VALUES (:firstname,:lastname)";
  $res = $pdo->prepare($sql);
  $exec = $res->execute(array(":firstname"=>$firstname,":lastname"=>$lastname));

  // vérifier si la requête d'insertion a réussi
  if($exec){
    echo 'Données insérées';
  }else{
    echo "Échec de l'opération d'insertion";
  }
}
?>

<!DOCTYPE html>
 <html>
    <head>
        <title>Cours Complet Bootstrap 4</title>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Mon blog</title>
   <meta charset="utf-8">
   <!--   CSS FILES -->
    <link rel="stylesheet" type="text/css" href="./assets/style/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/style/style.css">
    <link rel="stylesheet" type="text/css" href="./assets/style/toastr.min.css">
     </head>
     <body>

         <div class="container">
             <h1>Inscrivez- vous ici!</h1>
             <form class="needs-validation" novalidate>

                  <div class="container-fluid">

                    <div class="col-md-4 mb-3">
                        <label for="civilté">M</label>
                        <input type="radio" name="civilte">
                         <label for="civilté">Mme</label>
                        <input type="radio" name="civilte"> 
                         <label for="civilté">Mlle</label>
                        <input type="radio" name="civilte">   
                  </div> 
                  </div>
             
                 <div class="container-fluid">
                     
                     <div class="col-md-4 mb-3">
                         <label for="nom">Nom de famille</label>
                         <input type="text" class="form-control" id="nom" placeholder="Giraud" required>
                         <div class="valid-feedback">Ok !</div>
                         <div class="invalid-feedback">Valeur incorrecte</div>
                     </div>
                     <div class="col-md-4 mb-3">
                         <label for="prenom">Prénom</label>
                         <input type="text" class="form-control" id="prenom" placeholder="Pierre" required>
                         <div class="valid-feedback">Ok !</div>
                         <div class="invalid-feedback">Valeur incorrecte</div>
                     </div>
                     <div class="col-md-4 mb-3">
                         <label for="pseudo">Pseudo</label>
                         <input type="text" class="form-control" id="pseudo" placeholder="PierreGird" required>
                         <div class="valid-feedback">Ok !</div>
                         <div class="invalid-feedback">Valeur incorrecte</div>
                     </div>
                 </div>
                 <div class="container-fluid">
                     <div class="col-md-6 mb-3">
                         <label for="ville">Ville</label>
                         <input type="text" class="form-control" id="ville" placeholder="Ville" required>
                         <div class="valid-feedback">Ok !</div>
                         <div class="invalid-feedback">Valeur incorrecte</div>
                     </div>
                     <div class="col-md-3 mb-3">
                         <label for="pays">Pays</label>
                         <input type="text" class="form-control" id="pays" placeholder="Pays" required>
                         <div class="valid-feedback">Ok !</div>
                         <div class="invalid-feedback">Valeur incorrecte</div>
                     </div>
                     <div class="col-md-3 mb-3">
                         <label for="cp">Code postal</label>
                         <input type="number" class="form-control" id="cp" placeholder="Code postal" required>
                         <div class="valid-feedback">Ok !</div>
                         <div class="invalid-feedback">Valeur incorrecte</div>
                     </div>
                 </div>
                 <div class="form-group">
                     <div class="form-check">
                       <input class="form-check-input" type="checkbox" value="" id="cgu" required>
                       <label class="form-check-label" for="cgu">J'accepte les conditions générales d'utilisation et de vente</label>
                       <div class="invalid-feedback">Vous devez accepter les CGU pour continuer</div>
                     </div>
                 </div>
                 <button class="btn btn-primary" type="submit">Envoyer</button>
                 <br><br><br>
             </form>
         </div>
         <script>
           /*La fonction principale de ce script est d'empêcher l'envoi du formulaire si un champ a été mal rempli
            *et d'appliquer les styles de validation aux différents éléments de formulaire*/
           (function() {
             'use strict';
             window.addEventListener('load', function() {
               let forms = document.getElementsByClassName('needs-validation');
               let validation = Array.prototype.filter.call(forms, function(form) {
                 form.addEventListener('submit', function(event) {
                   if (form.checkValidity() === false) {
                     event.preventDefault();
                     event.stopPropagation();
                   }
                   form.classList.add('was-validated');
                 }, false);
               });
             }, false);
           })();
         </script>
    </body>
</html>