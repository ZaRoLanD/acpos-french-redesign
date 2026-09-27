<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="import_inv";
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
		<title>Importer l'inventaire | dexAC Point de Vente</title>
	</head>
	<body data-page="import_inv">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">⬆ Import en masse (Inventaire)</h2>

				<div class="glass-card spotlight" style="padding:clamp(1.25rem,3vw,2rem)">
					<form class="form-inline" role="form" method="post" action="import_inv.php" enctype="multipart/form-data">
						<div class="form-group">
							<label for="datatxtfile" class="control-label">Fichier CSV / TXT</label>
							<input type="file" name="datatxtfile" id="datatxtfile" class="form-control" accept=".txt,.csv">
						</div>
						<div style="display:flex; gap:.8rem; flex-wrap:wrap; margin-top:.5rem">
							<button type="submit" class="btn btn-primary btn-large">⬆ Importer</button>
							<a href="acInventory.php" class="btn btn-large">Annuler</a>
						</div>
					</form>

					<p style="margin:1.25rem 0 0; font-size:.85rem; color:var(--text-soft)">
						Format attendu (une ligne par produit, séparateur <code>:</code>) :<br>
						<code>nom:catégorie:fabricant:code-barres:prix_d'achat:stock_actuel:stock_mini:regroupement</code>
					</p>
				</div>

				<?php
					if(isset($_FILES['datatxtfile']))
					{
						$allowedExts = array("txt", "csv");
						$extension = end(explode(".", $_FILES["datatxtfile"]["name"]));
						if(in_array($extension, $allowedExts))
						{
							if ($_FILES["datatxtfile"]["error"] > 0)
								echo "<div class='alert-ac alert-danger'>⚠️ Erreur : " . $_FILES["datatxtfile"]["error"] . "</div>";
							else
								uploadTxtData($_FILES["datatxtfile"]["tmp_name"]);
						}
						else
							echo "<div class='alert-ac alert-danger'>⚠️ Fichier invalide — utilisez un fichier .txt ou .csv</div>";
					}

					function uploadTxtData($filename)
					{
						$file = fopen( $filename, "r" ) or die ('ERROR: fopen()');
						$filesize = filesize( $filename );
						$filetext = fread( $file, $filesize );
						fclose( $file );
						$content = explode("\n", $filetext);
						echo "<div class='alert-ac alert-success'>✅ Fichier importé avec succès !</div>";

						foreach($content as $line)
						{
							list($name, $category, $manuf, $barcode, $costprice,
							$currentStock, $minStock, $bundleunit) = explode(":",$line);
							$query = "insert into HQinv (pdtname, category, manufacturer, barcode, cost, curstock, minstock, bundle) values ('".$name."','".$category."','".$manuf."','".$barcode."','".$costprice."','".$currentStock."','".$minStock."','".$bundleunit."')";
							$result = mysql_query($query);
						}

						$query = "Select * From HQinv";
						$result = mysql_query($query);
						echo '<div class="glass-card" style="padding:1rem; margin-top:1.25rem"><div style="overflow-x:auto">';
						echo '<table class="table">';
						echo "<thead><tr><th>Produit</th><th>Catégorie</th><th>Fabricant</th><th>Code-barres</th><th>Prix d'achat</th><th>Stock actuel</th><th>Stock minimum</th><th>Regroupement</th></tr></thead><tbody>";

						while($row = mysql_fetch_array($result))
						{
							echo "<tr>";
						echo "<td data-label='Produit'><strong>".$row['pdtname']."</strong></td>";
						echo "<td data-label='Catégorie'>".$row['category']."</td>";
						echo "<td data-label='Fabricant'>".$row['manufacturer']."</td>";
						echo "<td data-label='Code-barres'>".$row['barcode']."</td>";
						echo "<td data-label='Prix dachat'>".$row['cost']."</td>";
						echo "<td data-label='Stock actuel'>".$row['curstock']."</td>";
						echo "<td data-label='Stock minimum'>".$row['minstock']."</td>";
						echo "<td data-label='Regroupement'>".$row['bundle']."</td>";
							echo "</tr>";
						}

						echo "</tbody></table></div></div>";
					}
				?>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
