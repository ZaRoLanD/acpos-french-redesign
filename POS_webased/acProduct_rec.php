<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="stock_list";
$act = $_GET['act'];
if($act!="" && $act=='del'){
	$sqldelstock = "delete from hqstock where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resdelstock = mysql_query($sqldelstock);
	
}else if ($act!="" && $act=='edt'){
	$sqledtstock = "select * from hqstock where barcode = '".$_GET['barcode']."' and shopid = '".$_GET['shopid']."'";
	$resedtstock = mysql_query($sqledtstock);
	$rowedtstock = mysql_fetch_assoc($resedtstock);

}



/*if(isset($_POST['submit'])){
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
				$mesg = 'New Record Successfully Added to stock';
			}
			else{
				$mesg = "New Record Insertion Failed";			
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
				$mesg = 'Record Is Updated Successfully';
			}
			else{
				$mesg = "Record Updation Failed";			
			}
		}

		
	}					*/
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
		<title>Registre des stocks | dexAC Point de Vente</title>
	</head>
	<body data-page="stock_list">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">📋 Registre des stocks</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:1rem 1.25rem; margin-bottom:1.5rem">
					<form name="search" id="search" method="POST" action="acProduct_rec.php">
						<div style="display:flex; gap:.8rem; flex-wrap:wrap; align-items:flex-end">
							<div class="form-group" style="flex:1; min-width:220px; margin-bottom:0">
								<label for="search" class="control-label">Recherche</label>
								<input type="text" id="search" name="search" class="form-control" placeholder="🔍 N° de boutique…">
							</div>
							<button type="submit" class="btn btn-primary" name="searchbtn" id="searchbtn">Rechercher</button>
						</div>
					</form>
				</div>

				<?php
					if(isset($_POST['search'])){
						$query = "SELECT * FROM hqstock  where shopid = '".stripslashes($_POST['search'])."' order by shopid desc"; ;
					}else {
						$query = "SELECT * FROM hqstock order by recdate desc";
					}
					$result = mysql_query($query);
					if(mysql_num_rows($result)>0){
						echo '<div class="glass-card" style="padding:1rem"><div style="overflow-x:auto">';
						echo '<table class="table">';
						echo "<thead><tr><th>N° boutique</th><th>Code-barres</th><th>Stock actuel</th><th>Dernier prix</th><th>Actions</th></tr></thead><tbody>";
						while($row = mysql_fetch_array($result))
						{
							echo "<tr>";
						echo "<td data-label='N° boutique'>".$row['shopid']."</td>";
						echo "<td data-label='Code-barres'>".$row['barcode']."</td>";
						echo "<td data-label='Stock actuel'>".($row['citycurstock'] !== null && $row['citycurstock'] <= 5 ? "<span class='badge badge-danger'>⚠ Stock bas : ".$row['citycurstock']."</span>" : "<span class='badge badge-success'>".$row['citycurstock']."</span>")."</td>";
						echo "<td data-label='Dernier prix'>".$row['citylastprice']."</td>";
						echo "<td data-label='Actions'><a class='btn btn-danger' style='padding:.3rem .7rem; font-size:.78rem' href='acProduct_rec.php?act=del&barcode=".$row['barcode']."&shopid=".$row['shopid']."'>Supprimer</a>
						<a class='btn' style='padding:.3rem .7rem; font-size:.78rem' href='stock.php?act=edt&barcode=".$row['barcode']."&shopid=".$row['shopid']."'>Modifier</a>
							</td>";
							echo "</tr>";
						}
						echo "</tbody></table></div></div>";
					} else {
						echo "<div class='alert-ac'>📭 Aucun enregistrement de stock.</div>";
					}
				?>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
