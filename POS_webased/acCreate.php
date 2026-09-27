<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="register";
if(isset($_POST['submit'])){
		$fname = stripslashes($_POST['fname']);
		$lname = stripslashes($_POST['lname']);
		$emailid = stripslashes($_POST['emailid']);
		$password = stripslashes($_POST['password']);
		$repassword = stripslashes($_POST['repassword']);
		$city = stripslashes($_POST['city']);
		$shopid = stripslashes($_POST['shopid']);

		

		//echo "shop id = ".$shopid;
		$sqlrec = "select * from users where emailid = '".$emailid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		if($nrec > 0){		
			$errmsg = "Cet e-mail est déjà utilisé, veuillez en choisir un autre.";
		}elseif($password != $repassword){
			$errmsg = "Les mots de passe ne correspondent pas";
		}elseif($errmsg == ""){		
		
			$query = "insert into users (`fname`, `lname`, `emailid`, `password`, `city`, `shopid`)
			           values ('".$fname."','".$lname."','".$emailid."','".$password."','".$city."','".$shopid."')";
			//echo $query;
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Compte créé avec succès';
			}
			else{
				$errmsg = "Échec de la création du compte";			
			}
		}

		
	}					
?>


<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="bootstrap_ac/bootstrap.ac.install.css" rel="stylesheet">
		<link href="bootstrap_ac/bootstrap.ac.css" rel="stylesheet">
		<link href="bootstrap_ac/ac-design.css" rel="stylesheet">
		<link href="bootstrap_ac/ac-theme-light.css" rel="stylesheet">
		<script src="js.ac/jquery-1.10.2.ac.js"></script>
		<script src="js.ac/bootstrap.ac.js"></script>
		<script src="js.ac/ac-ui.js" defer></script>
		<link rel="shortcut icon" href="goodlACk.gif">
		<title>Créer un compte | dexAC Point de Vente</title>
	</head>
	<body data-page="register">
		<?php include('pageheader.php'); ?>
		<div class="login-wrap">
			<div class="login-card spotlight" style="max-width:560px; width:100%">
				<h1 class="login-title">Créer un compte ✨</h1>
				<p class="login-sub">Rejoignez votre boutique et commencez à vendre en quelques secondes.</p>

				<?php if($errmsg!=""){ ?>
					<div class="alert-ac alert-danger">⚠️ <?php echo $errmsg; ?></div>
				<?php } elseif($mesg!=""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<form class="form-horizontal" role="form" method="post" action="acCreate.php" name="test">
					<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:0 1.1rem">
						<div class="form-group">
							<label for="fname" class="control-label">Prénom</label>
							<input type="text" id="fname" name="fname" maxlength="50" class="form-control" placeholder="Prénom" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>" required>
						</div>
						<div class="form-group">
							<label for="lname" class="control-label">Nom</label>
							<input type="text" id="lname" name="lname" maxlength="50" class="form-control" placeholder="Nom" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<label for="emailid" class="control-label">Adresse e-mail</label>
						<input type="email" id="emailid" name="emailid" maxlength="50" class="form-control" placeholder="vous@exemple.com" value="<?php echo isset($_POST['emailid']) ? $_POST['emailid'] : ''; ?>" required>
					</div>

					<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:0 1.1rem">
						<div class="form-group">
							<label for="password" class="control-label">Mot de passe</label>
							<input type="password" id="password" name="password" maxlength="20" class="form-control" placeholder="••••••••" required>
						</div>
						<div class="form-group">
							<label for="repassword" class="control-label">Confirmer le mot de passe</label>
							<input type="password" id="repassword" name="repassword" class="form-control" placeholder="••••••••" required>
						</div>
					</div>

					<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:0 1.1rem">
						<div class="form-group">
							<label for="city" class="control-label">Ville</label>
							<input type="text" id="city" name="city" maxlength="40" class="form-control" placeholder="Ville" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>" required>
						</div>
						<div class="form-group">
							<label for="shopid" class="control-label">N° de boutique</label>
							<input type="number" id="shopid" name="shopid" class="form-control" placeholder="N° de boutique" value="<?php echo isset($_POST['shopid']) ? $_POST['shopid'] : ''; ?>" required>
						</div>
					</div>

					<div class="form-group" style="margin-top:1.4rem">
						<button type="submit" class="btn btn-primary btn-large" style="width:100%" name="submit" id="submit">
							Créer mon compte →
						</button>
					</div>
				</form>

				<p style="text-align:center; margin:1.25rem 0 0; font-size:.9rem; color:var(--text-soft)">
					Déjà inscrit ?
					<a href="login.php" class="text-gradient" style="font-weight:600">Se connecter</a>
				</p>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
