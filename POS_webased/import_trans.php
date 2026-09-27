<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="import_trans";
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
		<title>Importer les transactions | dexAC Point de Vente</title>
	</head>
	<body data-page="import_trans">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">⬆ Import en masse (Transactions)</h2>

				<div class="glass-card spotlight" style="padding:clamp(1.25rem,3vw,2rem)">
					<form class="form-inline" role="form" method="post" action="import_trans.php" enctype="multipart/form-data">
						<div class="form-group">
							<label for="datatxtfile" class="control-label">Fichier CSV / TXT</label>
							<input type="file" name="datatxtfile" id="datatxtfile" class="form-control" accept=".txt,.csv">
						</div>
						<div style="display:flex; gap:.8rem; flex-wrap:wrap; margin-top:.5rem">
							<button type="submit" class="btn btn-primary btn-large">⬆ Importer</button>
							<a href="acTransaction_record.php" class="btn btn-large">Annuler</a>
						</div>
					</form>

					<p style="margin:1.25rem 0 0; font-size:.85rem; color:var(--text-soft)">
						Format attendu (une ligne par transaction, séparateur <code>:</code>) :<br>
						<code>n°_transaction:n°_vendeur:nom_produit:code-barres:montant:date</code>
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
						$file = fopen( $filename, "r" ) or die ("Error in opening File");
						$filesize = filesize( $filename );
						$filetext = fread( $file, $filesize );
						fclose( $file );

						// Splitting up the Delimiter \n
						$content= explode("\n", $filetext);
					echo "<div class='alert-ac alert-success'>✅ Fichier importé avec succès !</div>";

						foreach($content as $line)
						{
							list($transactionid, $cashierid, $productName, $barcode, $amt, $date) = explode(":", $line);
							$query = "insert into HQtransactions (trnid, barcode,shopid, qtysold, itemprice, timedate)
										values ('".$transactionid."', '".$barcode."', '".$cashierid."', ".$amt.",".rand(1,99).",'".$date."')";
							$result = mysql_query($query);
						}

						$query = "Select * From hqtransactions";
						$result = mysql_query($query);
						echo '<div class="glass-card" style="padding:1rem; margin-top:1.25rem"><div style="overflow-x:auto">';
						echo '<table class="table">';
					echo "<thead><tr><th>N° transaction</th><th>N° boutique</th><th>Code-barres</th><th>Quantité</th><th>Prix unitaire</th><th>Date</th></tr></thead><tbody>";

						while ($row = mysql_fetch_array($result))
						{
							echo "<tr>";
					echo "<td data-label='N° transaction'>".$row['trnid']."</td>";
					echo "<td data-label='N° boutique'>".$row['shopid']."</td>";
					echo "<td data-label='Code-barres'>".$row['barcode']."</td>";
					echo "<td data-label='Quantité'>".$row['qtysold']."</td>";
					echo "<td data-label='Prix unitaire'>".$row['itemprice']."</td>";
					echo "<td data-label='Date'>".$row['timedate']."</td>";
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
