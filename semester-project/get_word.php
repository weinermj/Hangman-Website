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

$wordQuery = "SELECT word FROM words WHERE difficulty = :difficulty ORDER BY rand() LIMIT 1";
$stmt = $pdo->prepare($wordQuery);
$stmt->bindParam(":difficulty", $_GET['difficulty']);
$stmt->execute();

echo json_encode(["word"=>$stmt->fetchColumn()]);