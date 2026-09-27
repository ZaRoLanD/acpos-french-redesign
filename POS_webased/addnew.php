<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$errmsg="";
$_SESSION['curpage']="product";

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
		$itemname = $_POST['itemname'];
		$category = $_POST['cat'];
		$manuf = $_POST['man'];
		$barcode = $_POST['bar'];
		$currentStock = $_POST['cstock'];
		$costprice = $_POST['price'];
		$minStock = $_POST['mstock'];
		$bundleunit = $_POST['bundleunit'];

		$query = "insert into HQinv (pdtname, category, manufacturer, barcode, cost, curstock, minstock, bundle) values ('".$itemname."', '".$category."','".$manuf."', '".$barcode."','".$costprice."','".$currentStock."','".$minStock."','".$bundleunit."')";
		$result = mysql_query($query);

		if($result)
		{
			//header("Location: http://-/page/addnew.php");
			$mesg = 'Produit ajouté à l\'inventaire avec succès';
			
		}
		else
			echo "Échec de la création du produit";			
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
		<title>Nouveau produit | dexAC Point de Vente</title>
	</head>
	<body data-page="product">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">📦 Inventory</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:clamp(1.25rem,3vw,2rem)">
					<form class="form-horizontal" role="form" method="post" action="addnew.php" enctype="multipart/form-data" name="test">
						<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:0 1.25rem">
							<div class="form-group">
								<label for="itemname" class="control-label">Nom du produit</label>
								<input type="text" id="itemname" name="itemname" class="form-control" placeholder="Nom du produit" value="<?php if ($edtinv!=''){echo $rowedtinv['pdtname']; }?>">
							</div>
							<div class="form-group">
								<label for="cat" class="control-label">Catégorie</label>
								<input type="text" id="cat" name="cat" class="form-control" placeholder="Catégorie" value="<?php if ($edtinv!=''){echo $rowedtinv['category']; }?>">
							</div>
							<div class="form-group">
								<label for="man" class="control-label">Fabricant</label>
								<input type="text" id="man" name="man" class="form-control" placeholder="Fabricant" value="<?php if ($edtinv!=''){echo $rowedtinv['manufacturer']; }?>">
							</div>
							<div class="form-group">
								<label for="bar" class="control-label">Code-barres</label>
								<input type="text" id="bar" name="bar" maxlength="8" class="form-control" placeholder="Code-barres" value="<?php if ($edtinv!=''){echo $rowedtinv['barcode']; }?>">
							</div>
							<div class="form-group">
								<label for="price" class="control-label">Prix d'achat</label>
								<input type="number" id="price" name="price" step="0.01" class="form-control" placeholder="Prix d'achat" value="<?php if ($edtinv!=''){echo $rowedtinv['cost']; }?>">
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
							<button type="submit" class="btn btn-primary btn-large" name="submit" id="submit">＋ Ajouter le produit</button>
						</div>
					</form>
				</div>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
