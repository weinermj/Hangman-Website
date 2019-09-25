<?php
session_start();

if (!isset($_SESSION['auth']))
    $_SESSION['auth'] = false;

//db.php is a file that contains the $server, $username, and $password
//variables for the database and starts the database connection
//
//Example:

//<?php
//$username = 'lambers2';
//$password = 'supersekret';
//$dbname = 'lambers2';
//
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

//The messages.php file contains all the success/error messages
require 'messages.php';
$messages = [];

//This is the main if statement that chooses which content to display


if(isset($_POST['register'])) {
    //Show the registration form if the Register New User button was clicked
    require 'partials/registrationForm.view.php';
} else if (isset($_POST['signup'])) {
    //Attempt to create a new user if the Register button was clicked
    //some simple validation checks

    //check to see if both passwords from the registration form match
    if ($_POST['password'] != $_POST['password2']) {
        $messages[] = $passwordMatchError;
    }

    //check to see if the username from the registration form is already taken
    if (isUsernameTaken($_POST['username'])) {
        $messages[] = $usernameTakenError;
    }

    if($messages) {
        //if there was an error, re-output the registration form
        require 'partials/registrationForm.view.php';
    } else {
        //attempt to create the user
        if(createUser($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'])) {
            //user creation successful; show the login form
            $messages[] = $userCreated;
            require 'partials/loginForm.view.php';
        } else {
            //user creation failed for some reason; show the register form
            $messages[] = $registrationError;
            require 'partials/registrationForm.view.php';
        }

    }
} else if (isset($_POST['login'])) {
    //attempt to the authenticate the user of the Login button was clicked
    if(checkAuth($_POST['username'], $_POST['password'])){
        //the login was successful; show the secret infos
        $_SESSION['auth'] = TRUE;
        $_SESSION['username'] = $_POST['username'];
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/semester-project/hangman.php');
    } else {
        //the login failed; reshow the login form
        $messages[] = $loginError;
        require 'partials/loginForm.view.php';
    }
} else if (isset($_GET['logout'])) {
    //logout request; destroy the session
    logout();
    require 'partials/loginForm.view.php';
} else if ($_SESSION['auth'] === TRUE) {
    //the user is successfully authenticated; show secret infos
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/semester-project/hangman.php');
} else {
    //no other conditions met; show the login form
    require 'partials/loginForm.view.php';
}
