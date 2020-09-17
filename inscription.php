<?php 
	
	if (!isset($_SESSION) && empty($_SESSION['connected']) && $_SESSION['connected'] == true) {
		header('Location: index.php');
	}

	session_start();
	include('utils/connexion.php');
	
	//On va vérifier si le POST existe et est différent de vide
	$valid =  true;
                
	if (!empty($_POST)) {

	//Si les données existent, on extrait le tableau
			//$valid = (boolean) true; //Juste pour des vérification et si cette variable est à false le traitement s'arrête là

			if (isset($_POST['Enregistrer'])){

				if (empty($_POST["genre"])) {
					$valid = false;
					$err_genre_utilisateur = "Veuillez choisir votre genre";
				}else{
					$genre_utilisateur = htmlspecialchars(trim($_POST["genre"]));
					$err_genre_utilisateur = "";
				}

				if (empty($_POST["nom"])){ 
					//On vérifie si le nom est vide on invite l'utilisateur à renseigner le champ
					$valid = false;
					$err_nom_utilisateur = "Nom d'utilisateur invalide !";
				}else {
					$nom_utilisateur = htmlspecialchars(trim($_POST["nom"]));
					$err_nom_utilisateur = "";
				}
				
				if (empty($_POST["password"]) && empty($_POST["confirmation_password"])){ 
					//On vérifie si le nom est vide on invite l'utilisateur à renseigner le champ
					$valid = false;
					$err_password = "Password invalide !";
					//On utilise alors notre fonction password_hash :
				}elseif($_POST["password"] != $_POST["confirmation_password"]){

            		$valid = false;
                	$err_password = "La confirmation du mot de passe ne correspond pas";
            	}else{
					$password_utilisateur = trim($_POST["password"]);
					$err_password = "";
					$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
				}

				if (empty($_POST["prenom"])){ 
				//On vérifie si le"Votre pseudo est déjà utilisé par un membre" prenom est vide on invite l'utilisateur à renseigner le champ
					$valid = false;
					$err_prenom_utilisateur = "Prénom de l'utilisateur invalide !";
				}else{
					$prenoms_utilisateur = htmlspecialchars(trim($_POST["prenom"]));
					 $err_prenom_utilisateur = "";
				}

				if (empty($_POST["date_de_naissance_utilisateur"])) {
					$valid = false;
					$err_date_de_naissance_utilisateur = "Veuillez renseigner le champ date de naissance";
				}else{
					$date_de_naissance_utilisateur = htmlspecialchars(trim($_POST["date_de_naissance_utilisateur"]));
					$err_date_de_naissance_utilisateur = "";
				}

				if (empty($_POST["pays"])) {
					$valid = false;
					$err_pays_de_naissance_utilisateur = "Veuillez renseigner le champ pays";
				}else{
					$pays_utilisateur = htmlspecialchars(trim($_POST["pays"]));
					$err_pays_de_naissance_utilisateur = "";
				}

				if (empty($_POST["ville"])) {
					$valid = false;
					$err_ville_de_naissance_utilisateur = "Veuillez renseigner le champ ville";
				}else{
					$ville_utilisateur = htmlspecialchars(trim($_POST["ville"]));
					$err_ville_de_naissance_utilisateur = "";
				}

				if (empty($_POST["telephone"])) {
					$valid = false;
					$err_telephone_utilisateur = "Veuillez renseigner le champ téléphone";
				}else{
					$numero_telephone_utilisateur = htmlspecialchars(trim($_POST["telephone"]));
					$err_telephone_utilisateur = "";
				}

				if(empty($_POST["email"])) {// Vérification du mail   ;  
				     $valid = false;
					 $err_email_utilisateur = "Le mail ne peut pas être vide";
					 // On vérifit que le mail est dans le bon format				           
				 }

				 elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $_POST["email"] )) {
					 $valid = false;
					 $err_email_utilisateur = "Email invalide !";
				     
				 } else { // On vérifit que le mail est disponible
					   $email_utilisateur =  $_POST["email"] ;
		    		   $req_email_utilisateur ="SELECT * FROM utilisateur WHERE email_utilisateur = ?";
				       $req= $bdd->prepare($req_email_utilisateur);
					   $req->execute(array($email_utilisateur));

					   if($donnees = $req->fetch()){
							$valid = false;
							$err_email_utilisateur = "Ce mail existe déjà";
				 		}
					}

					if ($valid) {

						$date_inscription = date('Y-m-d H:i:s');
		                $solde_compte_utilisateur = '0';
		                $c = '1234';
						$a = rand(); 
						$b = rand();
						$numero_compte_utilisateur = "$c $a $b";

					$query = $bdd->prepare("INSERT INTO utilisateur (genre_utilisateur, nom_utilisateur, prenoms_utilisateur, date_de_naissance_utilisateur, pays_utilisateur, ville_utilisateur, email_utilisateur, numero_telephone_utilisateur, password_utilisateur, numero_compte_utilisateur, solde_compte_utilisateur, date_inscription) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

					$query->bindParam(':genre_utilisateur', $_POST["genre"]);
					$query->bindParam(':nom_utilisateur', $_POST["nom"]);
					$query->bindParam(':prenoms_utilisateur', $_POST["prenom"]);
					$query->bindParam(':date_de_naissance_utilisateur', $_POST["date_de_naissance_utilisateur"]);
					$query->bindParam(':pays_utilisateur', $_POST["pays"]);
					$query->bindParam(':ville_utilisateur',$_POST["ville"]);
					$query->bindParam(':email_utilisateur',$_POST["email_utilisateur"]);
					$query->bindParam(':numero_telephone_utilisateur', $_POST["telephone"]);
					$query->bindParam(':password', $hash);
					$query->bindParam(':numero_compte_utilisateur', $numero_compte_utilisateur);
					$query->bindParam(':solde_compte_utilisateur', $solde_compte_utilisateur);
					$query->bindParam(':date_inscription', $date_inscription);
					$query->execute(array($genre_utilisateur, $nom_utilisateur, $prenoms_utilisateur, $date_de_naissance_utilisateur, $pays_utilisateur, $ville_utilisateur, $email_utilisateur, $numero_telephone_utilisateur, $hash, $numero_compte_utilisateur, $solde_compte_utilisateur, $date_inscription,));
					header('Location: index.php');
					exit();
				}
								
			}
	}	

 ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Sign up - Progressus Bootstrap template</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="assets/css/main.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="index.php"><img src="assets/images/logo.png" alt="Progressus HTML5 template"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="index.php">Home</a></li>
					<li><a href="about.php">About</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">More Pages <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="sidebar-left.php">Left Sidebar</a></li>
							<li><a href="sidebar-right.php">Right Sidebar</a></li>
						</ul>
					</li>
					<li><a href="contact.php">Contact</a></li>
					<li class="active"><a class="btn" href="deconnexion.php">Déconnexion</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->

	<header id="head" class="secondary"></header>

	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li class="active">Registration</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title">Registration</h1>
				</header>
				
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">Register a new account</h3>
							<p class="text-center text-muted">Lorem ipsum dolor sit amet, <a href="index.php">Login</a> adipisicing elit. Quo nulla quibusdam cum doloremque incidunt nemo sunt a tenetur omnis odio. </p>
							<hr>

							<form action="#" method="POST">
								<div class="top-margin">

									<?php 

										if (!empty($err_genre_utilisateur)) {
										 		
										 		echo "$err_genre_utilisateur" ;
										 }
								
									 ?> <br>
									 <label for="genre">Genre:</label>
									<input type="radio" name="genre" value="Homme"> un homme
			                        <input type="radio" name="genre" value="Femme"> une femme
			                        <input type="radio" name="genre"  value="mademoiselle"> Une demoiselle  
                    			</div> 

                    			<br/>

								<div class="top-margin">

									<?php 

										if (!empty($err_nom_utilisateur)) {
										 		
										 		echo "$err_nom_utilisateur" ;
										 } 

									 ?> <br>

									<label>Nom</label>
									<input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" minlength="2" maxlength="255">
								</div>

								<div class="top-margin">

									<?php 

										if (!empty($err_prenom_utilisateur)) {
										 		
										 		echo "$err_prenom_utilisateur" ;
										 } 

									 ?> <br>
									<label>Prénom</label>
									<input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre Prénom" minlength="2" maxlength="255">
								</div>

								<div class="top-margin">

									<?php 

										if (!empty($err_date_de_naissance_utilisateur)) {
										 		
										 		echo "$err_date_de_naissance_utilisateur" ;
										 } 

									 ?> <br>

									<label>Date de naissance</label>
									<input type="date" class="form-control" id="date_de_naissance_utilisateur" name="date_de_naissance_utilisateur">
								</div>


								<div class="top-margin">

									<?php 

										if (!empty($err_pays_de_naissance_utilisateur)) {
										 		
										 		echo "$err_pays_de_naissance_utilisateur" ;
										 } 

									 ?> <br>
									<label>Pays de naissance</label>
									<input type="text" class="form-control" id="pays" name="pays" placeholder="Votre pays de naissance" minlength="2" maxlength="255">
								</div>

								<div class="top-margin">

									<?php 

										if (!empty($err_ville_de_naissance_utilisateur)) {
										 		
										 		echo "$err_ville_de_naissance_utilisateur" ;
										 } 

									 ?> <br>
									<label>Ville de naissance</label>
									<input type="text" class="form-control" id="ville" name="ville" placeholder="Votre ville de naissance" minlength="2" maxlength="255">
								</div>

								<div class="top-margin">

									<?php 

										if (!empty($err_email_utilisateur)) {
										 		
										 		echo "$err_email_utilisateur" ;
										 } 

									 ?> <br>
									<label>Addresse Email <span class="text-danger">*</span></label>
									<input type="Email" class="form-control" id="email" name="email" placeholder="Votre email" minlength="2" maxlength="255">
								</div>

								<div class="top-margin">

									<?php 

										if (!empty($err_telephone_utilisateur)) {
										 		
										 		echo "$err_telephone_utilisateur" ;
										 } 

									 ?> <br>
									<label>Téléphone <span class="text-danger">*</span></label>
									<input type="number" class="form-control" id="telephone" name="telephone" placeholder="Votre numéro de téléphone" minlength="8" maxlength="8">
								</div>

								<div class="row top-margin">

									<?php 

										if (!empty($err_password)) {
										 		
										 		echo "$err_password" ;
										 } 

									 ?> <br>
									<div class="col-sm-6">
										<label>Mot de passe <span class="text-danger">*</span></label>
										<input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
									</div>

									<div class="col-sm-6">

										<?php 

										if (!empty($err_verify_password)) {

												echo "$err_password";
										 		
										 		echo "$err_verify_password" ;
										 } 

									    ?>
										<label>Confirmez votre mot de passe<span class="text-danger">*</span></label>
										<input type="Password" class="form-control" id="confirmation_password" name="confirmation_password" placeholder="Confirmez votre mot de passe">
									</div>
								</div>

								<hr>

								<div class="row">
									<div class="col-lg-8">

										<?php 
											$err_checkbox = "Veuillez accepter les termes et Conditions";
										if (!empty($err_checkbox)) {
										 		
										 		echo "$err_checkbox" ;
										 } 

									 ?> <br>
										<label class="checkbox">
											<input type="checkbox"> 
											Acceptez les <a href="page_terms.php">termes et Conditions</a>
										</label>                        
									</div>
									<div class="col-lg-4 text-right">
										<button class="btn btn-action" type="submit" name="Enregistrer" onclick="alerteur()">Enregistrer</button>
									</div>
								</div>
							</form>
						</div>
					</div>

				</div>
				
			</article>
			<!-- /Article -->

		</div>
	</div>	<!-- /container -->
	

	<footer id="footer" class="top-space">

		<div class="footer1">
			<div class="container">
				<div class="row">
					
					<div class="col-md-3 widget">
						<h3 class="widget-title">Contact</h3>
						<div class="widget-body">
							<p>+234 23 9873237<br>
								<a href="mailto:#">tenco2011@hotmail.fr</a><br>
								<br>
								234 Hidden Pond Road, Ashland City, TN 37015
							</p>	
						</div>
					</div>

					<div class="col-md-3 widget">
						<h3 class="widget-title">Follow me</h3>
						<div class="widget-body">
							<p class="follow-me-icons clearfix">
								<a href=""><i class="fa fa-twitter fa-2"></i></a>
								<a href=""><i class="fa fa-dribbble fa-2"></i></a>
								<a href=""><i class="fa fa-github fa-2"></i></a>
								<a href=""><i class="fa fa-facebook fa-2"></i></a>
							</p>	
						</div>
					</div>

					<div class="col-md-6 widget">
						<h3 class="widget-title">Text widget</h3>
						<div class="widget-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, dolores, quibusdam architecto voluptatem amet fugiat nesciunt placeat provident cumque accusamus itaque voluptate modi quidem dolore optio velit hic iusto vero praesentium repellat commodi ad id expedita cupiditate repellendus possimus unde?</p>
							<p>Eius consequatur nihil quibusdam! Laborum, rerum, quis, inventore ipsa autem repellat provident assumenda labore soluta minima alias temporibus facere distinctio quas adipisci nam sunt explicabo officia tenetur at ea quos doloribus dolorum voluptate reprehenderit architecto sint libero illo et hic.</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

		<div class="footer2">
			<div class="container">
				<div class="row">
					
					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="simplenav">
								<a href="#">Home</a> | 
								<a href="about.php">About</a> |
								<a href="sidebar-right.php">Sidebar</a> |
								<a href="contact.php">Contact</a> |
								<b><a href="inscription.php">Sign up</a></b>
							</p>
						</div>
					</div>

					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2014, Your name. Designed by <a href="http://gettemplate.com/" rel="designer">gettemplate</a> 
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>
	</footer>	
		
	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="assets/js/headroom.min.js"></script>
	<script src="assets/js/jQuery.headroom.min.js"></script>
	<script src="assets/js/template.js"></script>
</body>

	<script>
	
	function alerteur() {

		toastr.options = {
		  "closeButton": true,
		  "debug": false,
		  "newestOnTop": false,
		  "progressBar": true,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": false,
		  "onclick": null,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "60000",
		  "extendedTimeOut": "60000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		  "hideMethod": "fadeOut"
	};

</script>
	
<?php 

if($valid == true && isset($_POST['Enregistrer'])) {
	echo '<script>toastr.success("utilisateur enregistrer avec succès");</script>';
}else if ($valid == false && isset($_POST['Enregistrer'])){
	echo '<script>toastr.error("Une erreur s\'est produite");</script>';
}

?>


</html>