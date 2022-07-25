<?php 

session_start();

if ( isset($_POST['Annuler'] ) ) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';

$storedHash = '1a52e17fa899cf40fb04cfc42e6352f1';

//Les données POST
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
	$check = hash('md5', $salt.$_POST['pass']);

	// Validation to protect against empty email or password 
	if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
            $_SESSION['error'] = "Le nom d'utilisateur et le mot de passe sont requis";
	    error_log("Login fail ".$_POST['email']." $check");
	    header("Location: login.php");
	    return;
	}  

	$containsAtSign = false;
	for($i=0;$i<strlen($_POST['email']);$i++){
		if ($_POST['email'][$i] === '@') {
			$containsAtSign = true;
     		   }
	}

	// Validation pour la protection contre les courriels sans le signe "@".	
    	if (!$containsAtSign) {
		$_SESSION['error'] = "L'e-mail doit comporter un signe at (@).";
		error_log("Login fail ".$_POST['email']." $check");
		header("Location: login.php");
		return;
	}

	// Rediriger l'utilisateur vers la page index.php, si le nom d'utilisateur est valide et que le mot de passe est correct.
	else if ( $check == $storedHash ) {
		
		unset($_SESSION['name']);
		$_SESSION['name'] = $_POST['email'];
                error_log("Login success ".$_POST['email']);
		header("Location: index.php");
		return;
	// Notifier l'utilisateur si l'email est valide mais qu'il a entré un mot de passe incorrect.	
	} else {
	    $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
	    header("Location: login.php");
            return;
     }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require_once "bootstrap.php"; ?>
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Se Connecter</h1> 

<?php
//Erreur à l'écran en rouge si l'utilisateur n'a pas passé la validation.
if (isset($_SESSION['error'])) {
	echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
	unset($_SESSION['error']);
}
?>
	<form method="POST"
	 action="./login.php">	
            <div>
                <label for="email">Nom d'Utilisateur</label>
                <input type="text" name="email" id="email">
            </div>
            <div>
                <label for="pass">Mot de Passe</label>
                <input type="password" name="pass" id="pass">
            </div>
            <button type="submit">Se Connecter</button>
            <a href="./index.php">Annuler</a>
        </form>
<p>Pour un indice sur le mot de passe, regarder dans le code source et trouver l'indice sur le mot de passe dans les commentaires HTML.</p>

</div>
</body>
