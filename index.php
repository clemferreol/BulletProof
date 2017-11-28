<?php

echo "<h1> BulletProof </h1>";
require './utils/dbconnexion.php';
//session_start();
?>

<form method="POST">
<label>Pseudo: <input type="text" name="nickname_login"/></label><br/>
<label>Mot de passe: <input type="password" name="password_login"/></label><br/>
<input type="submit" value="Me connecter"/>
</form>

<?php
if(isset($_POST['nickname_login']) && !empty($_POST['nickname_login']) && isset($_POST['password_login']) && !empty($_POST['password_login'])){
    $nickname_login = htmlspecialchars($_POST['nickname_login']);
    $password_login = htmlspecialchars($_POST['password_login']);
    $password_hash = password_hash($password_login, PASSWORD_DEFAULT);

    $q = $pdo->prepare('SELECT * FROM user WHERE nickname = :nickname');
    $q->bindParam(':nickname', $nickname_login, PDO::PARAM_STR);
    $q->execute();
    $queryResults = $q->fetch(PDO::FETCH_ASSOC);
    if(password_verify($password_login, $queryResults['password'])){
        echo "Well done";
    }else{
        echo "Wrong info";
    }
}
?>


<form method="POST"
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
