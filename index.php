<?php

require_once "pdo.php";
session_start();


// Vérifier si l'utilisateur est connecté
// $_SESSION['name'] est créée dans login.php une fois que l'utilisateur s'est connecté avec succès.
$loggedIn = isset($_SESSION['name']);

// Recherche de données
$stmt = $pdo->query("SELECT * FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
  <head>
	<title>Document</title>
  </head>
  <body>
    <?php
      if (isset($_SESSION['success'])) {
        echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
	unset($_SESSION['success']);
    } ?>
  </p> 
<?php
  if (!$loggedIn) {
    echo "<a href='login.php'>?</a>";
    echo " <a href='add.php'>ajouter des données<a/>sans enregistrer.</a>";
  } else if (!$rows) {
    // s'il n'y a pas d'automobiles dans la base de données	 
    echo "<p>Bienvenue sur la base de données Automobiles</p>";
  } else { ?>  
    <table border="1">
      <tr>
	      <th>Marque</th>
        <th>Modèle</th>
	      <th>Année</th>
        <th>Kilométrage</th>
        <th>Action</th>
      </tr>
	<?php for ($i=0;$i<count($rows);$i++){ ?>
	<tr>
	  <td><?php echo htmlentities($rows[$i]['marque']); ?></td>
      	  <td><?php echo htmlentities($rows[$i]['modèle']); ?></td>
	  <td><?php echo htmlentities($rows[$i]['année']); ?></td>
   	  <td><?php echo htmlentities($rows[$i]['kilométrage']); ?></td> 
	  <td><a href="edit.php?autos_id=<?php echo htmlentities($rows[$i]['autos_id']);?>">Edit<a/>/<a href="delete.php?autos_id=<?php echo htmlentities($rows[$i]['autos_id']);?>">Delete</a></td>
	</tr>
  <?php }
  echo "</table>";
  }
  if ($loggedIn){
?>
    <p><a href='add.php'>Ajouter une nouvelle entrée</a></p>
    <p><a href='logout.php'>Déconnexion</a></p>
<?php } ?>
  </body>
</html>
