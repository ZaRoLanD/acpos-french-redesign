<?php
//for more info fb.com/ijsamp
?>
<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="transaction";
$loginshopid = $_SESSION['shopid'];

$act = $_GET['act'];
if($act!="" && $act=='del'){
	$sqldelstock = "delete from temptrans where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resdelstock = mysql_query($sqldelstock);
	
}else if ($act!="" && $act=='edt'){
	$sqledtstock = "select * from temptrans where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resedtstock = mysql_query($sqledtstock);
	$rowedtstock = mysql_fetch_assoc($resedtstock);

}


if(isset($_POST['save'])){
	$sqltransmaster = "insert into hqtrnmaster (shopid)
							values ('".$loginshopid."')";
	//echo $sqltransmaster;
	$restransmaster = mysql_query($sqltransmaster);
	$mastertransid = mysql_insert_id();
	if($restransmaster){
		$sqltrans = "insert into hqtransactions (`trnid`, `barcode`, `shopid`, `qtysold`, `itemprice`)
						select ".$mastertransid.", barcode, shopid, qtysold, itemprice 
						from temptrans 
						where shopid  = '".$loginshopid."'";
		//echo $sqltrans;
		$restrans = mysql_query($sqltrans);
		if($restrans){
			$sqldeltemp = "delete from temptrans where shopid = '".$loginshopid."'";
			//echo $sqldeltemp;
			$resdeltemp = mysql_query($sqldeltemp);
		}
	}
}


if(isset($_POST['submit'])){
		$shopid = stripslashes($_POST['shopid']);
		$barcode = stripslashes($_POST['barcode']);
		$itemprice = stripslashes($_POST['itemprice']);
		$qtysold = stripslashes($_POST['qtysold']);

/*		$currentStock = $_POST['cstock'];
		$costprice = $_POST['price'];
		$minStock = $_POST['mstock'];
		$bundleunit = $_POST['bundleunit'];
*/
		
		$sqlrec = "select * from temptrans where barcode = '".$barcode."' and shopid = '".$shopid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into temptrans (shopid, barcode, itemprice, qtysold) values ('".$shopid."', '".$barcode."','".$itemprice."', '".$qtysold."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Article ajouté au panier avec succès';
			}
			else{
				$mesg = "Échec de l'ajout de l'article";			
			}
		}elseif($nrec > 0){		
		
			$query = "update temptrans set 
						shopid = '".$shopid."', 
						barcode  = '".$barcode."',
						itemprice  = '".$itemprice."',
						qtysold = '".$qtysold."'
					 where barcode = '".$barcode."' and shopid = '".$shopid."'";
			
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Article mis à jour avec succès';
			}
			else{
				$mesg = "Échec de la mise à jour de l'article";			
			}
		}

		
	}?>

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
		<title>Caisse | dexAC Point de Vente</title>
	</head>
	<body data-page="transaction">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">🧾 Caisse — Nouvelle vente</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:clamp(1.25rem,3vw,2rem)">
					<form class="form-horizontal" role="form" method="post" action="transaction.php" name="test">
						<div class="scan-field" style="margin-bottom:1.15rem">
							<svg class="scan-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 5v14"/><path d="M8 5v14"/><path d="M12 5v14"/><path d="M16 5v14"/><path d="M21 5v14"/></svg>
							<input type="number" id="barcode" name="barcode" minlength="8" maxlength="8" class="form-control" placeholder="Scanner ou saisir le code-barres…" value="<?php if ($act=='edt'){echo $rowedtstock['barcode']; }?>" data-scan-field autofocus>
						</div>

						<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem">
							<div class="form-group">
								<label for="shopid" class="control-label">N° de boutique</label>
								<input type="number" id="shopid" name="shopid" class="form-control" placeholder="N° de boutique" value="<?php if ($act=='edt'){echo $rowedtstock['shopid']; } else { echo $loginshopid; } ?>">
							</div>
							<div class="form-group">
								<label for="itemprice" class="control-label">Prix unitaire</label>
								<input type="number" id="itemprice" name="itemprice" min="1" max="99.99" step="0.01" class="form-control" placeholder="Prix unitaire" value="<?php if ($act=='edt'){echo $rowedtstock['itemprice']; }?>">
							</div>
							<div class="form-group">
								<label for="qtysold" class="control-label">Quantité</label>
								<input type="number" id="qtysold" name="qtysold" min="1" class="form-control" placeholder="Quantité" value="<?php if ($act=='edt'){echo $rowedtstock['qtysold']; } else { echo 1; } ?>">
							</div>
						</div>

						<div style="display:flex; gap:.8rem; flex-wrap:wrap; margin-top:.5rem">
							<button type="submit" class="btn btn-primary btn-large" name="submit" id="submit">＋ Ajouter au panier</button>
							<button type="submit" class="btn btn-success btn-large" name="save" id="save">💾 Encaisser &amp; imprimer</button>
						</div>
					</form>
				</div>
                    
                    <?php 	$query = "SELECT * FROM temptrans order by timedate desc"; //ERE barcode='".$barcode."' ";
							$result = mysql_query($query);
						if(mysql_num_rows($result)>0){

							echo '<div class="glass-card" style="margin-top:1.5rem; padding:1rem">';
							echo '<h3 style="margin:.25rem .25rem 1rem; font-size:1.05rem; letter-spacing:.02em">🛒 Panier en cours</h3>';
							echo '<div style="overflow-x:auto">';
							echo '<table class="table">';
							echo "<thead><tr><th>Code-barres</th><th>Article</th><th>Prix unitaire</th><th>Quantité</th><th>Total</th><th>Actions</th></tr></thead><tbody>";
							$invtotal = 0;
							while($row = mysql_fetch_array($result)) 
							{
								$sqlitem = "SELECT `barcode`, pdtname
											FROM hqinv
											WHERE  barcode = '".$row['barcode']."'";
								//echo $sqlitem;
								$resitem = mysql_query($sqlitem);
								$rowitem = mysql_fetch_assoc($resitem);

								$invtotal += $row['itemprice']*$row['qtysold'];
								
								echo "<tr>";
								echo "<td data-label='Code-barres'>".$row['barcode']."</td>";
								echo "<td data-label='Article'>".$rowitem['pdtname']."</td>";
								echo "<td data-label='Prix unitaire'>".$row['itemprice']."</td>";
								echo "<td data-label='Quantité'>".$row['qtysold']."</td>";
								echo "<td data-label='Total'>".$row['itemprice']*$row['qtysold']."</td>";
								
								echo "<td data-label='Actions'><a class='btn btn-danger' style='padding:.3rem .7rem; font-size:.78rem' href='transaction.php?act=del&barcode=".$row['barcode']."&shopid=".$row['shopid']."'>Retirer</a> 
								<a class='btn' style='padding:.3rem .7rem; font-size:.78rem' href='transaction.php?act=edt&barcode=".$row['barcode']."&shopid=".$row['shopid']."'>Modifier</a>
								</td>";
								echo "</tr>";
							}
							echo "</tbody></table></div>";
							echo "<div class='total-bar'><span>Total à payer</span><span class='total-amount' data-count='".$invtotal."'>".$invtotal."</span></div>";
							echo "</div>";
						}
					?>
				</main>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>