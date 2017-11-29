<?php
require './utils/dbconnexion.php';
session_start();

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    $deleted_user = $_SESSION['user'];
    echo($deleted_user);
    $q = $pdo->prepare('DELETE * FROM user WHERE nickname = :nickname');
    $q->bindParam(':nickname', $deleted_user, PDO::PARAM_STR);
    $deleted = $q->execute();
    var_dump($deleted);

    if($deleted){
    session_unset();
    session_destroy();
    echo "Vous avez été correctement désinscris";

    }
}
?>

<a href="index.php"> Retour à accueil </a><br />
