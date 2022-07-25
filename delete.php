<?php

require_once "pdo.php";
session_start();

	if (!isset($_SESSION['name'])) {
		die("ACCÈS REFUSÉ");
	}
	if (isset($_POST['cancel'])){
		header("Location: index.php");
		exit();
	}

	// Requête pour les données pré-remplies
	$stmt = $pdo->query("SELECT * FROM autos");
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	for ($i=0;$i<count($rows);$i++){
	  if ($rows[$i]['autos_id'] == $_REQUEST['autos_id']){
	    $make = $rows[$i]['make'];
	    $model= $rows[$i]['model'];
	    $year = $rows[$i]['year'];
	    $mileage = $rows[$i]['mileage'];
	    }
	}
	
	if (isset($_POST['delete'])) {
          $stmt = $pdo->prepare('DELETE FROM autos WHERE autos_id = :id'); 
	  $stmt->bindParam(':id', $_REQUEST['autos_id'], PDO::PARAM_INT);
  	  $stmt->execute();
          $_SESSION['success'] = "Enregistrement supprimé";
          header("Location: index.php");
          return;	
	}
?>

<!DOCTYPE html>
<html>
  <head>
	<title>Supréssion</title>
   <?php require_once "bootstrap.php"; ?>
  </head>
  <body>
<div class="container">
<p>Confirmez : Suppression de <?php echo htmlentities($make)." ".htmlentities($model);?></p>
<form method="post">
<input type="submit" name="delete" value="Suprimer">
<input type="submit" name="cancel" value="Annuler">
</form>
</div>
</body>
</html>
