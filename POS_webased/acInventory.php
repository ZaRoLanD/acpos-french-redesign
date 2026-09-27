<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="inventory";
$delinv = $_GET['del'];
if($delinv != ""){
	$sqldelinv = "delete from HQinv where barcode = '".$delinv."'";
	$resdelinv = mysql_query($sqldelinv);
}

$edtinv = $_GET['edt'];
if($edtinv != ""){
	$sqledtinv = "select * from HQinv where barcode = '".$edtinv."'";
	$resedtinv = mysql_query($sqledtinv);
	$rowedtinv = mysql_fetch_assoc($resedtinv);
}



	if(isset($_POST['submit'])){
		$itemname = stripslashes($_POST['itemname']);
		$category = stripslashes($_POST['cat']);
		$manuf = stripslashes($_POST['man']);
		$barcode = stripslashes($_POST['bar']);
		$currentStock = stripslashes($_POST['cstock']);
		$costprice = stripslashes($_POST['price']);
		$minStock = stripslashes($_POST['mstock']);
		$bundleunit = stripslashes($_POST['bundleunit']);

		
		$sqlrec = "select * from HQinv where barcode = '".$barcode."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into HQinv (pdtname, category, manufacturer, barcode, cost, curstock, bundle, minstock ) values ('".$itemname."', '".$category."','".$manuf."', '".$barcode."','".$costprice."','".$currentStock."','".$bundleunit."','".$minStock."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Produit ajouté à l\'inventaire avec succès';
			}
			else{
				$mesg = "Échec de la création du produit";			
			}
		}elseif($nrec > 0){		
		
			$query = "update HQinv set 
						pdtname = '".$itemname."', 
						category  = '".$category."',
						manufacturer  = '".$manuf."',
						barcode = '".$barcode."',
						cost = '".$costprice."',
						curstock = '".$currentStock."',
						bundle = '".$bundleunit."',
						minstock = '".$minStock."'
					 where barcode = '".$barcode."'";
			
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Produit mis à jour avec succès';
			}
			else{
				$mesg = "Échec de la mise à jour du produit";			
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
		<title>Inventaire | dexAC Point de Vente</title>
	</head>
	<body data-page="inventory">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">📦 Inventaire</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:clamp(1.25rem,3vw,2rem)">
					<form class="form-horizontal" role="form" method="post" action="acInventory.php" name="test">
						<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:0 1.25rem">
							<div class="form-group">
								<label for="itemname" class="control-label">Nom du produit</label>
								<input type="text" id="itemname" name="itemname" maxlength="50" class="form-control" placeholder="Nom du produit" value="<?php if ($edtinv!=''){echo $rowedtinv['pdtname']; }?>">
							</div>
							<div class="form-group">
								<label for="cat" class="control-label">Catégorie</label>
								<input type="text" id="cat" maxlength="50" name="cat" class="form-control" placeholder="Catégorie" value="<?php if ($edtinv!=''){echo $rowedtinv['category']; }?>">
							</div>
							<div class="form-group">
								<label for="man" class="control-label">Fabricant</label>
								<input type="text" id="man" name="man" maxlength="50" class="form-control" placeholder="Fabricant" value="<?php if ($edtinv!=''){echo $rowedtinv['manufacturer']; }?>">
							</div>
							<div class="form-group">
								<label for="bar" class="control-label">Code-barres</label>
								<input type="number" id="bar" name="bar" minlength="8" maxlength="8" class="form-control" placeholder="Code-barres" value="<?php if ($edtinv!=''){echo $rowedtinv['barcode']; }?>">
							</div>
							<div class="form-group">
								<label for="price" class="control-label">Prix d'achat</label>
								<input type="number" id="price" name="price" min="1" max="99.99" step="0.01" class="form-control" placeholder="Prix d'achat" value="<?php if ($edtinv!=''){echo $rowedtinv['cost']; }?>">
							</div>
							<div class="form-group">
								<label for="cstock" class="control-label">Stock actuel</label>
								<input type="number" id="cstock" name="cstock" class="form-control" placeholder="Stock actuel" value="<?php if ($edtinv!=''){echo $rowedtinv['curstock']; }?>">
							</div>
							<div class="form-group">
								<label for="mstock" class="control-label">Stock minimum</label>
								<input type="number" id="mstock" name="mstock" class="form-control" placeholder="Stock minimum" value="<?php if ($edtinv!=''){echo $rowedtinv['minstock']; }?>">
							</div>
							<div class="form-group">
								<label for="bundleunit" class="control-label">Unité de regroupement</label>
								<input type="text" id="bundleunit" name="bundleunit" class="form-control" placeholder="Unité de regroupement" value="<?php if ($edtinv!=''){echo $rowedtinv['bundle']; }?>">
							</div>
						</div>

						<div style="margin-top:.5rem">
							<button type="submit" class="btn btn-primary btn-large" name="submit" id="submit">
								<?php echo ($edtinv!='') ? '💾 Enregistrer les modifications' : '＋ Ajouter le produit'; ?>
							</button>
						</div>
					</form>
				</div>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
