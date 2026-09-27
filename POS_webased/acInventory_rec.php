<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="inventory_list";
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
		<title>Voir l'inventaire | dexAC Point de Vente</title>
	</head>
	<body data-page="inventory_list">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">🗂 Voir l'inventaire</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:1rem 1.25rem; margin-bottom:1.5rem">
					<form name="search" id="search" method="POST" action="acInventory_rec.php">
						<div style="display:flex; gap:.8rem; flex-wrap:wrap; align-items:flex-end">
							<div class="form-group" style="flex:1; min-width:220px; margin-bottom:0">
								<label for="search" class="control-label">Recherche</label>
								<input type="text" id="search" name="search" class="form-control" placeholder="🔍 Code-barres…">
							</div>
							<button type="submit" class="btn btn-primary" name="searchbtn" id="searchbtn">Rechercher</button>
						</div>
					</form>
				</div>

				<?php
					if(isset($_POST['search'])){
						$query = "SELECT * FROM HQinv  where barcode = '".stripslashes($_POST['search'])."' order by recdate desc"; ;
					}else {
						$query = "SELECT * FROM HQinv order by recdate desc";
					}

					$result = mysql_query($query);
					if(mysql_num_rows($result)>0){
						echo '<div class="glass-card" style="padding:1rem"><div style="overflow-x:auto">';
						echo '<table class="table">';
					echo "<thead><tr><th>Produit</th><th>Catégorie</th><th>Fabricant</th><th>Code-barres</th><th>Prix d'achat</th><th>Stock actuel</th><th>Stock minimum</th><th>Regroupement</th><th>Actions</th></tr></thead><tbody>";
						while($row = mysql_fetch_array($result))
						{
							$lowstock = ($row['curstock'] !== null && $row['minstock'] !== null && $row['curstock'] <= $row['minstock']);
							echo "<tr>";
							echo "<td data-label='Produit'><strong>".$row['pdtname']."</strong></td>";
							echo "<td data-label='Catégorie'><span class='badge badge-accent'>".$row['category']."</span></td>";
							echo "<td data-label='Fabricant'>".$row['manufacturer']."</td>";
							echo "<td data-label='Code-barres'>".$row['barcode']."</td>";
							echo "<td data-label='Prix dachat'>".$row['cost']."</td>";
							echo "<td data-label='Stock actuel'>".($lowstock ? "<span class='badge badge-danger'>⚠ Stock bas : ".$row['curstock']."</span>" : "<span class='badge badge-success'>".$row['curstock']."</span>")."</td>";
							echo "<td data-label='Stock minimum'>".$row['minstock']."</td>";
							echo "<td data-label='Regroupement'>".$row['bundle']."</td>";
							echo "<td data-label='Actions'><a class='btn btn-danger' style='padding:.3rem .7rem; font-size:.78rem' href='acInventory_rec.php?del=".$row['barcode']."'>Supprimer</a>
							<a class='btn' style='padding:.3rem .7rem; font-size:.78rem' href='acInventory.php?edt=".$row['barcode']."'>Modifier</a>
							</td>";
							echo "</tr>";
						}
						echo "</tbody></table></div></div>";
					} else {
						echo "<div class='alert-ac'>📭 Aucun produit dans l'inventaire.</div>";
					}
				?>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
