<?php
    require('checkLogin.php');

    $newusername = $_GET['newusername'];  

    if (strlen($newusername) == 0) {
        header("Location: account.php");
        exit;
    }
            
    require_once 'db.conf';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            
    if ($conn->connect_error) {
        $error = 'Error: ' . $conn->connect_errno . ' ' . $conn->connect_error;
        exit;
    }
            
    $newusername = $conn-> real_escape_string($newusername);

    $query = "SELECT id FROM users WHERE userName = '$newusername'";
    $result = $conn->query($query);
            
    if ($result->num_rows > 0) {
        $error = "User Already Exists!";
        require "account.php";
        exit;
    }

    $query = "UPDATE users SET username = '$newusername' WHERE id = $ID";       

    $conn -> query($query);
            
    $conn->close();
            
    $_SESSION['loggedin'] = $newusername;
            
    header("Location: account.php");
    exit;

?>