
<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$host = "localhost:3307";
		$db_username = "root";
		$db_password = "";
		$database = "acpos";
			
		$conn = mysql_connect($host, $db_username, $db_password) 
				or die ('Erreur : connexion à MySQL impossible');
		@mysql_select_db($database) or die( "Impossible de sélectionner la base de données");

?>