<?php

require_once "pdo.php";
session_start();

	if (!isset($_SESSION['name'])) {
		die("ACCÈS REFUSÉ");
	}
	if (isset($_POST['Annuler'])){
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
	
	if (isset($_POST['save'])){
           if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
                  $_SESSION['save'] = "Tous les champs sont obligatoires";
                  header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
                  return;
                }
	   	else if (!is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) || is_null($_POST['mileage']) || is_null($_POST['year'])){
                   $_SESSION['save'] = "Le kilométrage et l'année en numériques";
                   header("Location: edit.php?autos_id=".$_REQUEST['id']);
                   return;
		}
		else {
		}
        }

	if (isset($_POST['save']) && !isset($_SESSION['save']) ){
        $stmt = $pdo->prepare('UPDATE autos SET 
	make = :mk, model = :mo, year = :yr, mileage = :mi WHERE autos_id = :id');
	$stmt->execute(array(
	':id' => $_REQUEST['autos_id'],
	':mk' => $_POST['make'],
        ':mo' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
	);
        $_SESSION['success'] = "Mise à jour de la fichier";
        header("Location: index.php");
        return;	
	}
?>
<!-- VIEW -->
<!DOCTYPE html>
<html>
  <head>
	<title>Document</title>
   <?php require_once "bootstrap.php"; ?>
  </head>
  <body>
<div class="container">
  <h1>Modifier une automobile</h1>
<form method="post">
<?php
if (isset($_SESSION['save'])){
        echo('<p style="color: red;">'.htmlentities($_SESSION['save'])."</p>");
        unset($_SESSION['save']);
}
?>
 <label for="make">Marque:</label>
 <input type="text" name="make" size="60" value="<?php echo htmlentities($make); ?>"><br>
 <label for="model">Modèle:</label>
 <input type="text" name="model" size="60" value="<?php echo htmlentities($model); ?>"><br>
 <label for="year">Année:</label>
 <input type="text" name="year" size="10" value="<?php echo htmlentities($year); ?>"><br>
 <label for="mileage">Kilomètrage:</label>
 <input type="text" name="mileage" size="10" value="<?php echo htmlentities($mileage); ?>"><br>
<input type="submit" name="edit" value="Sauvegarder">
<input type="submit" name="cancel" value="Annuler">
</form>
</div>
</body>
</html>
