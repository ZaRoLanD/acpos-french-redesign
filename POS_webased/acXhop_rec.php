<?php  session_start(); ob_start();
include('connection.php');
$mesg = "";
$_SESSION['curpage']="shop_list";
$delshop = $_GET['del'];
if($delshop != ""){
	$sqldelshop = "delete from shopslist where shopid = '".$delshop."'";
	$resdelshop = mysql_query($sqldelshop);
}

$edtshop = $_GET['edt'];
if($edtshop != ""){
	$sqledtshop = "select * from shopslist where shopid = '".$edtshop."'";
	$resedtshop = mysql_query($sqledtshop);
	$rowedtshop = mysql_fetch_assoc($resedtshop);
}



	if(isset($_POST['submit'])){
		$shopname = stripslashes($_POST['shopname']);
		$city = stripslashes($_POST['city']);
		$shopid = stripslashes($_POST['shopid']);
		//echo "shop id = ".$shopid;
		$sqlrec = "select * from shopslist where shopid = '".$shopid."'";
		$resrec = mysql_query($sqlrec);
		$nrec = mysql_num_rows($resrec);
		
		
		if($nrec == 0){		
		
			$query = "insert into shopslist (shopname, city) values ('".$shopname."', '".$city."')";
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'New Shop Successfully Added';
			}
			else{
				$mesg = "New Shop Addition Failed";			
			}
		}elseif($nrec > 0){		
		
			$query = "update shopslist set 
						shopname = '".$shopname."', 
						city  = '".$city."'
					 where shopid = '".$shopid."'";
			
			$result = mysql_query($query);
			
			if($result){ 
				$mesg = 'Shop Is Updated Successfully';
			}
			else{
				$mesg = "Shop Updation Failed";			
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
		<title>Registre des boutiques | dexAC Point de Vente</title>
	</head>
	<body data-page="shop_list">
		<?php include('pageheader.php'); ?>
		<div class="layout-grid">
			<?php include('acWidget.php'); ?>
			<main class="main-panel">
				<h2 class="section-title">🏪 Registre des boutiques</h2>

				<?php if($mesg != ""){ ?>
					<div class="alert-ac alert-success">✅ <?php echo $mesg; ?></div>
				<?php } ?>

				<div class="glass-card spotlight" style="padding:1rem 1.25rem; margin-bottom:1.5rem">
					<form name="search" id="search" method="POST" action="acXhop_rec.php">
						<div style="display:flex; gap:.8rem; flex-wrap:wrap; align-items:flex-end">
							<div class="form-group" style="flex:1; min-width:220px; margin-bottom:0">
								<label for="search" class="control-label">Recherche</label>
								<input type="text" id="search" name="search" class="form-control" placeholder="🔍 Shop ID…">
							</div>
							<button type="submit" class="btn btn-primary" name="searchbtn" id="searchbtn">Rechercher</button>
						</div>
					</form>
				</div>

				<?php
					if(isset($_POST['search'])){
						$query = "SELECT * FROM shopslist  where shopid = '".stripslashes($_POST['search'])."' order by shopid desc"; ;
					}else {
						$query = "SELECT * FROM shopslist order by shopid desc";
					}

					$result = mysql_query($query);
					if(mysql_num_rows($result)>0){
						echo '<div class="glass-card" style="padding:1rem"><div style="overflow-x:auto">';
						echo '<table class="table">';					echo "<thead><tr><th>N° boutique</th><th>Nom</th><th>Ville</th><th>Actions</th></tr></thead><tbody>";
						while($row = mysql_fetch_array($result))
						{
							echo "<tr>";
						echo "<td data-label='N° boutique'>#".$row['shopid']."</td>";
						echo "<td data-label='Nom'><strong>".$row['shopname']."</strong></td>";
						echo "<td data-label='Ville'><span class='badge badge-accent'>".$row['city']."</span></td>";
						echo "<td data-label='Actions'><a class='btn btn-danger' style='padding:.3rem .7rem; font-size:.78rem' href='acXhop_rec.php?del=".$row['shopid']."'>Supprimer</a>
						<a class='btn' style='padding:.3rem .7rem; font-size:.78rem' href='acProduct.php?edt=".$row['shopid']."'>Modifier</a>
							</td>";
							echo "</tr>";
						}
						echo "</tbody></table></div></div>";
					} else {
					echo "<div class='alert-ac'>📭 Aucune boutique enregistrée.</div>";
					}
				?>
			</main>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>
