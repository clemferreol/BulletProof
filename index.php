<?php

echo "<h1> BulletProof </h1>";
require './utils/dbconnexion.php';
//session_start();
?>

<form method="POST">
<label>Pseudo: <input type="text" name="nickname_register"/></label><br/>
<label>Mot de passe: <input type="password" name="password_register"/></label><br/>
<input type="submit" value="M'inscrire"/>
</form>

<?php
if(isset($_POST['nickname_register']) && !empty($_POST['nickname_register']) && isset($_POST['password_register']) && !empty($_POST['password_register'])){
    $nickname_register = htmlspecialchars($_POST['nickname_register']);
    $password_register = htmlspecialchars($_POST['password_register']);
    $password_hash = password_hash($password_register, PASSWORD_DEFAULT);

    $q = $pdo->prepare('INSERT INTO user (nickname, password) VALUES (:nickname, :password)');
    $q->bindParam(':nickname', $nickname_register, PDO::PARAM_STR);
    $q->bindParam(':password', $password_hash, PDO::PARAM_STR);
    $register = $q->execute();
}


?>
