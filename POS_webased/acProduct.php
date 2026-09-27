<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="shop";
$delshop = $_GET['del'];
if($delshop != ""){
	$sqldelshop = "delete from shopslist where shopid = '".$delshop."'";
	$resdelshop = mysql_query($sqldelshop);
}

$edtshop = $_GET['edt'];
if($edtshop != ""){
	$sqledtshop = "select * from shopslist where shopid = '".$edtshop."'";
	$resedtshop = mysql_query($sqledtshop);
	$rowedtshop = mysql_fetch_assoc($resedtshop);
}



	if(isset($_POST['submit'])){
		$shopname = stripslashes($_POST['shopname']);
		$city = stripslashes($_POST['city']);
		$shopid = stripslashes($_POST['shopid']);
		//echo "shop id = ".$shopid;
		$sqlrec = "select * from shopslist where shopid = '".$shopid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into shopslist (shopname, city) values ('".$shopname."', '".$city."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Boutique ajoutée avec succès';
			}
			else{
				$mesg = "Échec de l'ajout de la boutique";			
			}
		}elseif($nrec > 0){		
		
			$query = "update shopslist set 
						shopname = '".$shopname."', 
						city  = '".$city."'
					 where shopid = '".$shopid."'";
			
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Boutique mise à jour avec succès';
			}
			else{
				$mesg = "Échec de la mise à jour de la boutique";			
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
		<title>Boutiques | dexAC Point de Vente</title>
	</head>
	<body data-page="shop">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">🏬 Boutiques</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:clamp(1.25rem,3vw,2rem)">
					<form class="form-horizontal" role="form" method="post" action="acProduct.php" name="test">
						<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:0 1.25rem">
							<div class="form-group">
								<label for="shopid" class="control-label">N° de boutique</label>
								<input type="number" id="shopid" name="shopid" class="form-control" placeholder="N° de boutique" value="<?php if ($edtshop!=''){echo $rowedtshop['shopid']; }?>">
							</div>
							<div class="form-group">
								<label for="shopname" class="control-label">Nom de la boutique</label>
								<input type="text" id="shopname" name="shopname" maxlength="50" class="form-control" placeholder="Nom de la boutique" value="<?php if ($edtshop!=''){echo $rowedtshop['shopname']; }?>">
							</div>
							<div class="form-group">
								<label for="city" class="control-label">Ville</label>
								<input type="text" id="city" name="city" maxlength="50" class="form-control" placeholder="Ville" value="<?php if ($edtshop!=''){echo $rowedtshop['city']; }?>">
							</div>
						</div>

						<div style="margin-top:.5rem">
							<button type="submit" class="btn btn-primary btn-large" name="submit" id="submit">💾 Enregistrer</button>
						</div>
					</form>
				</div>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
