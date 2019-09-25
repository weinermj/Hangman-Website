
<?php

function isUsernameTaken($username)
{
    global $pdo;
    //this query gets a count of users who already have the provided username
    $query = "SELECT COUNT(*) FROM players WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    //return TRUE if there was a query error; this makes it seem like the user exists when it might not
    if ($count === false) {
        return true;
    }

    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function createUser($username, $password, $firstname, $lastname)
{
    global $pdo;
    //Salt and hash the provided password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    //this query inserts the new user record into the table with the salted and hashed password
    $query = "INSERT INTO players (username, password, first_name, last_name) VALUES (:username, :password, :first_name, :last_name)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $passwordHash);
    $stmt->bindParam(":first_name", $firstname);
    $stmt->bindParam(":last_name", $lastname);

    return $stmt->execute();
}

function checkAuth($username, $password)
{
    global $pdo;
//This query gets the password hash from the user table for the user attempting to login
    $query = "SELECT password FROM players WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if ($result === false) {
        return false;
    }

    //compare hash of provided password to hash in database
    return password_verify($password, $result);
}

function logout()
{
    $_SESSION = array();
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
    session_destroy();
}
