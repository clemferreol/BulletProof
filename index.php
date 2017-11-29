<?php
require './utils/dbconnexion.php';

echo "<h1> BulletProof </h1>";

session_start();

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    echo "Bienvenue ".($_SESSION['user']);

?>
    <form method="POST"
    <label>Message: <textarea cols="80" rows="8" name="content"></textarea></label><br/>
    <input type="submit" value="Envoyer"/>
</form><br/>

</br/>

    <a href="deconnexion.php"> Se déconnecter </a><br />
    <a href="unsuscribe.php"> Se désinscrire </a><br />

    <?php
    if(isset($_POST['content']) && !empty($_POST['content'])){
        $content = htmlspecialchars($_POST['content']);

        $poster = $_SESSION['user'];
        //var_dump($poster);

        if($content){
            $q = $pdo->prepare('SELECT * FROM user WHERE nickname = :nickname');
            $q->bindParam(':nickname', $poster, PDO::PARAM_STR);
            $q->execute();
            $queryResults = $q->fetch(PDO::FETCH_ASSOC);
            //var_dump($queryResults);

            if(!empty($queryResults['id']) && !empty($queryResults['nickname']) ){

                $user_id = $queryResults['id'];
                $user_nickname = $queryResults['nickname'];
                //var_dump($user_id);

                $post = $pdo->prepare('INSERT INTO post (user_id, nickname_user, content) VALUES (:user_id, :nickname_user, :content)');
                $post->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $post->bindParam(':nickname_user', $user_nickname, PDO::PARAM_STR);
                $post->bindParam(':content', $content, PDO::PARAM_STR);
                $post->execute();

                $display = $pdo->prepare('SELECT * FROM post');
                $display->execute();
                $displayResults = $display->fetchAll();
                foreach($displayResults as $result) {
                    echo $result['user_id'] ." - ";
                    echo $result['nickname_user'] ." - ";
                    echo $result['content'], '<br>';
                    }

            }

        }

    }
    ?>
<?php
}else{
 ?>

<form method="POST" action="index.php">
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
        $_SESSION['user'] = $nickname_login;
        echo "Bien connecté";
    }else{
        echo "Mauvais identifiants";
    }
}
?>


<form method="POST" action="index.php">
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
    if($register){
         $_SESSION['user'] = $nickname_register;
     }
    }
}
?>
