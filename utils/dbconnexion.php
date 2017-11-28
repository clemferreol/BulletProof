<?php
require_once(realpath(dirname(__FILE__))."/../config/dbconfig.php");

try {
    $pdo = new PDO('mysql:host='.$config["host"], $config["user"], $config["password"]);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
}
