<?php
session_start();

$user = 'Licorne';
$password = '12345';

// test connexion
if (isset($_POST['submit'])) {

    $username = $_POST['Username'];
    $password = $_POST['password'];

    if ($username && $password) {

        if ($username == $user && $password == $password) {

            $_SESSION['Username'] = $username;
            header('Location: admin.php');
            // echo "Vous êtes connecté.";
        } else {

            echo "Identifiants erronés.";
        }
    } else {

        echo "Veuillez remplir les champs.";
    }
}

?>
<link rel="stylesheet" type="text/css" href="../style/bootstrap.css">
<h1>Administartion - Connexion</h1>
<form action="" method="POST">
	<h3>Nom</h3>
	<input type="text" name="Username"><br>
	<br>
	<h3>Mot de passe</h3>
	<input type="password" name="password"><br>
	<br> <input type="submit" name="submit"><br>
	<br>
</form>