<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="export";

if(isset($_POST['submit'])){
	if($_POST['exptype']=='Inventory'){
		
		$filename = "inventory.txt";
		$file_handle = fopen($filename, "a");
		
		$sqlinv = "select * from hqinv";
		$resinv = mysql_query($sqlinv);
		
		while($rowinv = mysql_fetch_assoc($resinv)){
			//pdtname, category, manufacturer, barcode, cost, curstock, minstock, bundle
			$file_contents = $rowinv['pdtname'].':'.$rowinv['category'].':'.$rowinv['manufacturer'].':'.$rowinv['barcode'].':'.$rowinv['cost'].':'.$rowinv['curstock'].':'.$rowinv['minstock'].':'.$rowinv['bundle'].':0'."\n";
			fwrite($file_handle, $file_contents);
		}
		
		fclose($file_handle);
		
	}
	
	
	if($_POST['exptype']=='Transactions'){
		
		$filename = "transactions.txt";
		$file_handle = fopen($filename, "a");
		
		$sqltrans = "select * from hqtransactions where trnid between '474359' and '474361'";
		$restrans = mysql_query($sqltrans);
		
		while($rowtrans = mysql_fetch_assoc($restrans)){
			//trnid, barcode,shopid, qtysold, itemprice, timedate
			$file_contents = $rowtrans['trnid'].':'.$rowtrans['barcode'].':'.$rowtrans['shopid'].':'.$rowtrans['qtysold'].':'.$rowtrans['itemprice'].':'.$rowtrans['timedate'].':0'."\n";
			fwrite($file_handle, $file_contents);
		}
		
		fclose($file_handle);
		
	}
	
	
}


?><html>
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
		<title>Exporter | dexAC Point de Vente</title>
	</head>
	<body data-page="export">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">⬇ Export</h2>

				<div class="glass-card spotlight" style="padding:clamp(1.25rem,3vw,2rem)">
					<form class="form-inline" role="form" method="post" action="export.php" enctype="multipart/form-data">
						<div class="stat-grid" style="margin-bottom:1.25rem">
							<label class="stat-card" style="cursor:pointer; display:block">
								<input type="radio" name="exptype" id="exptype" value="Inventory" required style="margin-right:.5rem">
								<span class="stat-label">📦 Inventaire</span>
								<div style="margin-top:.3rem; font-size:.85rem; color:var(--text-soft)">Tous les produits du catalogue</div>
							</label>
							<label class="stat-card" style="cursor:pointer; display:block">
								<input type="radio" name="exptype" id="exptype" value="Transactions" style="margin-right:.5rem">
								<span class="stat-label">🧾 Transactions</span>
								<div style="margin-top:.3rem; font-size:.85rem; color:var(--text-soft)">Historique des ventes</div>
							</label>
						</div>							<button type="submit" class="btn btn-primary btn-large" name="submit" id="submit">⬇ Lancer l'export</button>
					</form>

					<?php
					 if(isset($_POST['submit'])){
						if($_POST['exptype']=='Inventory'){
							 if (file_exists($filename)) {
								echo "<div class='alert-ac alert-success' style='margin-top:1.25rem'>✅ Export prêt — <a href='inventory.txt' class='text-gradient' style='font-weight:600'>télécharger inventory.txt</a></div>";
							}
						}
					 }
							
					 if(isset($_POST['submit'])){
						if($_POST['exptype']=='Transactions'){
							 if (file_exists($filename)) {
								echo "<div class='alert-ac alert-success' style='margin-top:1.25rem'>✅ Export prêt — <a href='transactions.txt' class='text-gradient' style='font-weight:600'>télécharger transactions.txt</a></div>";
							}
						}
					 }
					?>
				</div>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
