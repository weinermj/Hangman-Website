<?php
session_start();

require 'db.php';
try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname", $myUsername, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br />";
    die();
}

addPoints($_SESSION['username'], $_GET['score']);
function addPoints($username, $possiblePoints)
{
    global $pdo;
    //this query gets a count of users who already have the provided username
    $query = "UPDATE players SET score = score + :points WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":points", $possiblePoints, PDO::PARAM_INT);
    $stmt->execute();

}


//orderbyRand LIMIT 1