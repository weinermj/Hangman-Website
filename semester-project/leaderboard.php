<?php
require('db.php');
$body = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $myUsername,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br />";
    die();
}


$leaderQuery = "SELECT username, score FROM players WHERE score > 0 ORDER BY score DESC";

$leaderStmt = $pdo->prepare($leaderQuery);
$leaderStmt->execute();

$count = 1;
while ($row = $leaderStmt->fetch(PDO::FETCH_ASSOC)) {
    //$body .= "<div class='leaders'><p>$count . ${row['username']} ${row['score']}</p>";
    $body .= "<tr><td>$count</td><td>${row['username']}</td><td>${row['score']}</td></tr>";
    $count++;
}

?>

<!doctype html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="homepage.css" type="text/css">
</head>
<body>
<header>
    <h1>Leaderboard</h1>
</header>
<table class = "table" style="width:100%">
    <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Score</th>
    </tr>
    <?=$body?>
</table>
<nav class = "links">
    <a href="http://weinermj.cse252.spikeshroud.com/semester-project/hangman.php">Hangman</a>
</nav>
</body>
</html>
