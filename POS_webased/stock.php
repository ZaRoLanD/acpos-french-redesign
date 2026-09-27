<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="stock";
$act = $_GET['act'];
if($act!="" && $act=='del'){
	$sqldelstock = "delete from hqstock where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resdelstock = mysql_query($sqldelstock);
	
}else if ($act!="" && $act=='edt'){
	$sqledtstock = "select * from hqstock where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resedtstock = mysql_query($sqledtstock);
	$rowedtstock = mysql_fetch_assoc($resedtstock);

}



if(isset($_POST['submit'])){
		$shopid = stripslashes($_POST['shopid']);
		$barcode = stripslashes($_POST['barcode']);
		$citycurstock = stripslashes($_POST['citycurstock']);
		$citylastprice = stripslashes($_POST['citylastprice']);

		$sqlrec = "select * from hqstock where barcode = '".$barcode."' and shopid = '".$shopid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into hqstock (shopid, barcode, citycurstock, citylastprice) values ('".$shopid."', '".$barcode."','".$citycurstock."', '".$citylastprice."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Stock ajouté avec succès';
			}
			else{
				$mesg = "Échec de l'ajout du stock";			
			}
		}elseif($nrec > 0){		
		
			$query = "update hqstock set 
						shopid = '".$shopid."', 
						barcode  = '".$barcode."',
						citycurstock  = '".$citycurstock."',
						citylastprice = '".$citylastprice."'
					 where barcode = '".$barcode."' and shopid = '".$shopid."'";
			
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Stock mis à jour avec succès';
			}
			else{
				$mesg = "Échec de la mise à jour du stock";			
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
		<title>Stock boutique | dexAC Point de Vente</title>
	</head>
	<body data-page="stock">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">🏬 Stock boutique</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:clamp(1.25rem,3vw,2rem)">
					<form class="form-horizontal" role="form" method="post" action="stock.php" enctype="multipart/form-data" name="test">
						<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:0 1.25rem">
							<div class="form-group">
								<label for="shopid" class="control-label">N° de boutique</label>
								<input type="number" id="shopid" name="shopid" maxlength="4" class="form-control" placeholder="N° de boutique" value="<?php if ($act=='edt'){echo $rowedtstock['shopid']; }?>">
							</div>
							<div class="form-group">
								<label for="barcode" class="control-label">Code-barres</label>
								<input type="number" id="barcode" name="barcode" maxlength="8" minlength="8" class="form-control" placeholder="Code-barres" value="<?php if ($act=='edt'){echo $rowedtstock['barcode']; }?>">
							</div>
							<div class="form-group">
								<label for="citycurstock" class="control-label">Stock actuel</label>
								<input type="number" id="citycurstock" name="citycurstock" class="form-control" placeholder="Stock actuel" value="<?php if ($act=='edt'){echo $rowedtstock['citycurstock']; }?>">
							</div>
							<div class="form-group">
								<label for="citylastprice" class="control-label">Dernier prix</label>
								<input type="number" id="citylastprice" name="citylastprice" min="1" max="99.99" step="0.01" class="form-control" placeholder="Dernier prix" value="<?php if ($act=='edt'){echo $rowedtstock['citylastprice']; }?>">
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
