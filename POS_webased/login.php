<?php //for more info fb.com/ijsamp
?>
<?php  session_start(); ob_start();

include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="login";
if(isset($_POST['submit'])){
		$emailid = stripslashes($_POST['emailid']);
		$password = stripslashes($_POST['password']);


		//echo "shop id = ".$shopid;
		$sqlrec = "select * from users where emailid = '".$emailid."' and password = '".$password."'";
		$resrec = mysql_query($sqlrec);		$rowuser = mysql_fetch_assoc($resrec);


		if($rowuser['emailid'] == ""){
			$errmsg = "Email ou mot de passe invalide";
		}elseif($rowuser['shopid'] != ""  && $errmsg == ""){

			$_SESSION['shopid'] = $rowuser['shopid'];
			$_SESSION['emailid'] = $rowuser['emailid'];
			header('location:transaction.php?success/id=#');

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
		<title>Connexion | dexAC Point de Vente</title>
	</head>
	<body data-page="login">
		<?php include('pageheader.php'); ?>
		<div class="login-wrap">
			<div class="login-card spotlight">
				<h1 class="login-title">Bienvenue 👋</h1>
				<p class="login-sub">Connectez-vous pour accéder à votre caisse et votre inventaire.</p>

				<?php if($errmsg!=""){ ?>
					<div class="alert-ac alert-danger">⚠️ <?php echo $errmsg; ?></div>
				<?php } elseif($mesg!=""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<form class="form-horizontal" role="form" method="post" action="login.php" name="test">
					<div class="form-group">
						<label for="emailid" class="control-label">Adresse e-mail</label>
						<input type="email" id="emailid" name="emailid" maxlength="50" class="form-control" placeholder="vous@exemple.com" value="<?php echo isset($_POST['emailid']) ? $_POST['emailid'] : ''; ?>" required autofocus>
					</div>

					<div class="form-group">
						<label for="password" class="control-label">Mot de passe</label>
						<input type="password" id="password" name="password" maxlength="20" class="form-control" placeholder="••••••••" required>
					</div>

					<div class="form-group" style="margin-top:1.5rem">
						<button type="submit" class="btn btn-primary btn-large" style="width:100%" name="submit" id="submit">
							Se connecter →
						</button>
					</div>
				</form>

				<p style="text-align:center; margin:1.25rem 0 0; font-size:.9rem; color:var(--text-soft)">
					Pas encore de compte ?
					<a href="acCreate.php" class="text-gradient" style="font-weight:600">Créer un compte</a>
				</p>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
