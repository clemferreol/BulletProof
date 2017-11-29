<?php
require './utils/dbconnexion.php';
session_start();

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    $deleted_user = $_SESSION['user'];
    //echo($deleted_user);

    $q = $pdo->prepare('DELETE FROM user WHERE nickname = :nickname');
    $q->bindParam(':nickname', $deleted_user, PDO::PARAM_STR);
    $q->execute();
    $deleteResults = $q->execute();

    if($deleteResults){
    //echo ($deleted_user." vous avez été correctement désinscrit(e)");
    session_unset();
    session_destroy();
    header("location:index.php");
}

}
header("location:index.php");
?>
