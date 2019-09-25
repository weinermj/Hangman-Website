<?php

    session_start();
    if ($_SESSION['auth'] !== true) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/semester-project/login.php');
    }


require 'db.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname", $myUsername, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br />";
    die();
}

//registration file
require 'registration.php';
?>


<!DOCTYPE HTML>

<html>
<head>
    <title>Hangman Game</title>
    <link rel="stylesheet" type="text/css" href="homepage.css">
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
</head>
<body>

<div class='top'>
    <div class='hang-container'>
        <div class='scaffolding-top'></div>
        <div class='scaffolding-left'></div>

        <div class='draw-area'>
            <div class='rope'></div>
        </div>

        <div class='scaffolding-base'></div>
    </div>
    <div class='side-container'>
        <div class='container-title'>Guess A Letter!</div>
        <div class='input-area'>
            <input id='letter-input' type='text' maxlength='1'/>
        </div>
    </div>

    <div class='side-container'>
        <div class='container-title'>Guessed Letters</div>
        <div id="wrong-letters" class='input-area'></div>
    </div>

    <div class = 'side-container'>
        <div class = "container-title">Choose Difficulty</div>
            <input type="radio" name="difficulty" id = "hard" value="hard" checked> Hard<br>
            <input type="radio" name="difficulty" id = "intermediate" value="intermediate"> Intermediate<br>
            <input type="radio" name="difficulty" id = "easy" value="easy"> Easy
    </div>
</div>
<div class='bottom'>
    <div class='word-box'>
        <div class='word-display'>
        </div>
    </div>
</div>
<nav class = "links">
            <a href="http://weinermj.cse252.spikeshroud.com/semester-project/leaderboard.php">Leaders</a>
            <a href="http://weinermj.cse252.spikeshroud.com/semester-project/partners.html">Our Partners</a>
    </nav>

</body>
<script src='game.js'></script>
<script src='person.js'></script>
<script src='rules.js'></script>
</html>