<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="transaction_hist";
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


/*if(isset($_POST['save'])){
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
*/

if(isset($_POST['submit'])){
		$shopid = stripslashes($_POST['shopid']);

/*		$barcode = $_POST['barcode'];
		$itemprice = $_POST['itemprice'];
		$qtysold = $_POST['qtysold'];

		$currentStock = $_POST['cstock'];
		$costprice = $_POST['price'];
		$minStock = $_POST['mstock'];
		$bundleunit = $_POST['bundleunit'];

		
		$sqlrec = "select * from temptrans where barcode = '".$barcode."' and shopid = '".$shopid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into temptrans (shopid, barcode, itemprice, qtysold) values ('".$shopid."', '".$barcode."','".$itemprice."', '".$qtysold."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'New Record Successfully Added to stock';
			}
			else{
				$mesg = "New Record Insertion Failed";			
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
				$mesg = 'Record Is Updated Successfully';
			}
			else{
				$mesg = "Record Updation Failed";			
			}
		}
		*/

		
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
		<title>Transactions boutique | dexAC Point de Vente</title>
	</head>
	<body data-page="transaction_hist">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">📊 Transactions boutique</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:1rem 1.25rem; margin-bottom:1.5rem">
					<form class="form-horizontal" role="form" method="post" action="acTransaction_record.php" enctype="multipart/form-data" name="test">
						<div style="display:flex; gap:.8rem; flex-wrap:wrap; align-items:flex-end">
							<div class="form-group" style="flex:1; min-width:220px; margin-bottom:0">
								<label for="shopid" class="control-label">N° de boutique</label>
								<input type="text" id="shopid" name="shopid" class="form-control" placeholder="N° de boutique" value="<?php if ($act=='edt'){echo $rowedtstock['shopid']; }?>">
							</div>
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Afficher</button>
						</div>
					</form>
				</div>

<?php 	if(isset($_POST['shopid']) && $_POST['shopid'] != ""){
						$query = "SELECT * FROM hqtransactions where shopid = '".$_POST['shopid']."' order by timedate desc";
						$result = mysql_query($query);
					if(mysql_num_rows($result)>0){

						echo '<div class="glass-card" style="padding:1rem"><div style="overflow-x:auto">';
						echo '<table class="table">';
					echo "<thead><tr><th>Code-barres</th><th>Article</th><th>Prix unitaire</th><th>Quantité</th><th>Total</th></tr></thead><tbody>";
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
							echo "</tr>";
						}
						echo "</tbody></table></div>";
					echo "<div class='total-bar'><span>Total des ventes</span><span class='total-amount' data-count='".$invtotal."'>".$invtotal."</span></div>";
						echo "</div>";
					} else {
					echo "<div class='alert-ac'>📭 Aucune transaction pour cette boutique.</div>";
					}
				} else {
					echo "<div class='alert-ac'>🔎 Saisissez un n° de boutique pour afficher ses transactions.</div>";
				}
				?>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
