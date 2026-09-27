<?php //for more info fb.com/ijsamp
?>
<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="editprofile";


if(isset($_POST['submit'])){
		$fname = stripslashes($_POST['fname']);
		$lname = stripslashes($_POST['lname']);
		$emailid = stripslashes($_POST['emailid']);
		$password = stripslashes($_POST['password']);
		$city = stripslashes($_POST['city']);
		$shopid = stripslashes($_POST['shopid']);

		

		//echo "shop id = ".$shopid;
		$sqlrec = "select * from users where emailid = '".$emailid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		if($nrec == 0){		
			$errmsg = "Cet e-mail n'existe pas dans la base.";
		}elseif($errmsg == ""){		
		
			$query = "update users set 
				`fname`= '".$fname."',
				`lname`= '".$lname."',
				`password` = '".$password."',
				`city` = '".$city."',
				`shopid` = '".$shopid."'
				where emailid = ".$emailid."' ";

			//echo $query;
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Profil mis à jour avec succès';
			}
			else{
				$errmsg = "Échec de la mise à jour du profil";			
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
		<title>Mon profil | dexAC Point de Vente</title>
	</head>
	<body data-page="editprofile">
		<?php include('pageheader.php'); ?>
		<div class="login-wrap">
			<div class="login-card spotlight" style="max-width:560px; width:100%">
				<h1 class="login-title">Mon profil 👤</h1>
				<p class="login-sub">Mettez à jour vos informations personnelles.</p>

				<?php
					$sqlusr = "select * from users where emailid = '".$_SESSION['emailid']."'";
					$resusr = mysql_query($sqlusr);
					$rowusr = mysql_fetch_assoc($resusr);
				?>

				<?php if($errmsg!=""){ ?>
					<div class="alert-ac alert-danger">⚠️ <?php echo $errmsg; ?></div>
				<?php } elseif($mesg!=""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<form class="form-horizontal" role="form" method="post" action="myInformation_edition.php" name="test">
					<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:0 1.1rem">
						<div class="form-group">
							<label for="fname" class="control-label">Prénom</label>
							<input type="text" id="fname" name="fname" maxlength="50" class="form-control" placeholder="Prénom" value="<?php echo $rowusr['fname']; ?>" required>
						</div>
						<div class="form-group">
							<label for="lname" class="control-label">Nom</label>
							<input type="text" id="lname" name="lname" maxlength="50" class="form-control" placeholder="Nom" value="<?php echo $rowusr['lname']; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<label for="emailid" class="control-label">Adresse e-mail</label>
						<input type="email" id="emailid" name="emailid" maxlength="50" disabled class="form-control" value="<?php echo $rowusr['emailid']; ?>">
					</div>

					<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:0 1.1rem">
						<div class="form-group">
							<label for="password" class="control-label">Mot de passe</label>
							<input type="password" id="password" name="password" maxlength="20" class="form-control" placeholder="••••••••" required>
						</div>
						<div class="form-group">
							<label for="city" class="control-label">Ville</label>
							<input type="text" id="city" name="city" maxlength="40" class="form-control" placeholder="Ville" value="<?php echo $rowusr['city']; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<label for="shopid" class="control-label">N° de boutique</label>
						<input type="number" id="shopid" name="shopid" class="form-control" placeholder="N° de boutique" value="<?php echo $rowusr['shopid']; ?>" required>
					</div>

					<div class="form-group" style="margin-top:1.4rem">
						<button type="submit" class="btn btn-primary btn-large" style="width:100%" name="submit" id="submit">
							💾 Enregistrer
						</button>
					</div>
				</form>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
