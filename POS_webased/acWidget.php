<?php //for more info fb.com/ijsamp
$acnow = date('H:i');
$cur = isset($_SESSION['curpage']) ? $_SESSION['curpage'] : '';
function acActive($page, $cur) { echo $page === $cur ? ' active' : ''; }
?>
<aside class="side-nav" aria-label="Navigation principale">
	<div style="text-align:center; padding:.35rem 0 1rem">
		<div class="stat-label">Heure boutique</div>
		<div class="stat-value" style="font-size:1.35rem"><?php echo $acnow; ?></div>
	</div>

	<?php if ($_SESSION['shopid'] != "") { ?>

	<a href="acInventory.php?getACPage=mod_query" class="<?php acActive('inventory', $cur); ?>">📦 Inventaire</a>
	<a href="acInventory_rec.php?getACPage=mod_recquery" class="<?php acActive('inventory_list', $cur); ?>">🗂 Voir l'inventaire</a>
	<a href="acProduct_shop.php?getACPage=shop" class="<?php acActive('shop', $cur); ?>">🏬 Boutiques</a>
	<a href="acProduct.php?getACPage=prod" class="<?php acActive('stock', $cur); ?>">🏬 Voir les boutiques</a>
	<a href="acProduct_shop.php?getACPage=shop_wise" class="<?php acActive('stock_shopwise', $cur); ?>">🛍 Stock par boutique</a>
	<a href="acProduct_rec.php?getACPage=prodrec" class="<?php acActive('stock_list', $cur); ?>">📋 Registre des stocks</a>
	<a href="transaction.php" class="<?php acActive('transaction', $cur); ?>">🧾 Caisse — Ventes du jour</a>
	<a href="acTransaction_record.php?getACPage=transhop" class="<?php acActive('transaction_hist', $cur); ?>">📊 Transactions boutique</a>
	<a href="acXhop_rec.php?getACPage=shoprec" class="<?php acActive('shop_list', $cur); ?>">🏪 Registre des boutiques</a>

	<div class="stat-label" style="margin:1rem 0 .4rem">Données</div>
	<a href="import_inv.php?getACPage=imp_inv" class="<?php acActive('import_inv', $cur); ?>">⬆ Importer l'inventaire</a>
	<a href="import_trans.php?getACPage=imp_tran" class="<?php acActive('import_trans', $cur); ?>">⬆ Importer les transactions</a>
	<a href="export.php?getACPage=expo_now" class="<?php acActive('export', $cur); ?>">⬇ Exporter</a>

	<div class="stat-label" style="margin:1rem 0 .4rem">Compte</div>
	<a href="myInformation_edition.php?getACPage=myprofile" class="<?php acActive('editprofile', $cur); ?>">👤 Mon profil</a>
	<a href="logout.php?getACPage=logged_successful">🚪 Se déconnecter</a>

	<?php } else { ?>

	<a href="login.php?getACPage=loginAuth" class="<?php acActive('login', $cur); ?>">🔑 Se connecter</a>
	<a href="acCreate.php?getACPage=regAcc" class="<?php acActive('register', $cur); ?>">✨ Créer un compte</a>

	<?php } ?>
</aside>