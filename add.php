<?php

require_once "pdo.php";
session_start();

	if (!isset($_SESSION['name'])) {
		die("ACCÈS REFUSÉ");
	}
	if (isset($_POST['annuler'])){
		header("Location: index.php");
		exit();
	}

	if (isset($_POST['add'])){
		if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
		  $_SESSION['add'] = "Tous les champs sont obligatoires";
                  header("Location: add.php");
                  return;	
		}
		else if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) || is_null($_POST['mileage']) || is_null($_POST['year'])){
		   $_SESSION['add'] = "Le kilométrage et l'année en numériques";
		   header("Location: add.php");
		   return;
		} 
		
		else {
		}
	}

//Modele
  		
	if (isset($_POST['add']) && !isset($_SESSION['add']) ){
        $stmt = $pdo->prepare('INSERT INTO autos
	(make, model, year, mileage) VALUES ( :mk, :mo, :yr, :mi)');
         $stmt->execute(array(
	':mk' => $_POST['make'],
        ':mo' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
	);
	$_SESSION['success'] = "Enregistrement ajouté";
	header("Location: index.php");
        return;	
	}

?>

<!DOCTYPE html>
<html>
  <head>
	<title>Document</title>
	<?php require_once "bootstrap.php"; ?>
  </head>
  <body>
<div class="container">
<?php
if ( isset($_SESSION['name']) ) {
    echo "<h1>Tracking Autos for ".htmlentities($_SESSION['name'])."</h1>\n";
}
?>
<form method="post">
<?php
if (isset($_SESSION['add'])){
        echo('<p style="color: red;">'.htmlentities($_SESSION['add'])."</p>");
        unset($_SESSION['add']);
}
?>
 <label for="make">Marque:</label>
 <input type="text" name="make"><br>
 <label for="model">Modèle:</label>
 <input type="text" name="model"><br>
 <label for="year">Année:</label>
 <input type="text" name="year"><br>
 <label for="mileage">kilométrage:</label>
 <input type="text" name="mileage"><br>
 <input type="submit" name="add" id="add">Ajouter</button>
 <input type="submit" name="cancel">Annuler</button>
</form>
</div>
</body>
</html>
