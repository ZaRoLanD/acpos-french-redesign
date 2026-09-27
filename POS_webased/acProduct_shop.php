<?php   session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="stock_shopwise";
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
		<title>Stock par boutique | dexAC Point de Vente</title>
	</head>
	<body data-page="stock_shopwise">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">🛍 Stock par boutique</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:1rem 1.25rem; margin-bottom:1.5rem">
					<form class="form-horizontal" role="form" method="post" action="acProduct_shop.php" enctype="multipart/form-data" name="test">
						<div style="display:flex; gap:.8rem; flex-wrap:wrap; align-items:flex-end">
							<div class="form-group" style="flex:1; min-width:220px; margin-bottom:0">
								<label for="shopid" class="control-label">N° de boutique</label>
								<input type="text" id="shopid" name="shopid" class="form-control" placeholder="N° de boutique" value="<?php if ($act=='edt'){echo $rowedtstock['shopid']; }?>">
							</div>
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Rechercher</button>
						</div>
					</form>
				</div>

<?php 	if(isset($_POST['shopid']) && $_POST['shopid'] != ""){
						$query = "SELECT hqstock.shopid, shopslist.shopname, shopslist.city, hqstock.barcode, 
											hqstock.citycurstock, hqstock.citylastprice, hqstock.recdate 
										FROM hqstock , shopslist
										WHERE hqstock.shopid = shopslist.shopid 
										and shopslist.shopid = '".$_POST['shopid']."' 
										order by hqstock.recdate desc";
								//echo $query;
						$result = mysql_query($query);
					if(mysql_num_rows($result)>0){

						echo '<div class="glass-card" style="padding:1rem"><div style="overflow-x:auto">';
						echo '<table class="table">';
					echo "<thead><tr><th>N°</th><th>Boutique</th><th>Ville</th><th>Code-barres</th><th>Produit</th><th>Stock actuel</th><th>Dernier prix</th><th>Date</th></tr></thead><tbody>";
						while($row = mysql_fetch_array($result)) 
						{
							$sqlitem = "SELECT `barcode`, pdtname
										FROM hqinv
										WHERE  barcode = '".$row['barcode']."'";
							//echo $sqlitem;
							$resitem = mysql_query($sqlitem);
							$rowitem = mysql_fetch_assoc($resitem);

							echo "<tr>";
						echo "<td data-label='N°'>".$row['shopid']."</td>";
						echo "<td data-label='Boutique'>".$row['shopname']."</td>";
						echo "<td data-label='Ville'>".$row['city']."</td>";
						echo "<td data-label='Code-barres'>".$row['barcode']."</td>";
						echo "<td data-label='Produit'>".$rowitem['pdtname']."</td>";
						echo "<td data-label='Stock actuel'>".($row['citycurstock'] !== null && $row['citycurstock'] <= 5 ? "<span class='badge badge-danger'>⚠ Stock bas : ".$row['citycurstock']."</span>" : "<span class='badge badge-success'>".$row['citycurstock']."</span>")."</td>";
						echo "<td data-label='Dernier prix'>".$row['citylastprice']."</td>";
						echo "<td data-label='Date'>".$row['recdate']."</td>";
							echo "</tr>";
						}
						
						//echo "<tr><td colspan='6'> Total:".$invtotal."</td></tr>  ";
						echo "</tbody></table></div></div>";
					} else {
					echo "<div class='alert-ac'>📭 Aucun stock trouvé pour cette boutique.</div>";
					}
				} else {
					echo "<div class='alert-ac'>🔎 Saisissez un n° de boutique pour afficher son stock.</div>";
				}
				?>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
