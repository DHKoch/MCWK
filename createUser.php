<?php
	// Here we are using sessions to propagate the login
	// http://us3.php.net/manual/en/intro.session.php

    // HTTPS redirect
    if ($_SERVER['HTTPS'] !== "on") {
		$redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header("Location: $redirectURL");
		exit;
	}
	
	// http://us3.php.net/manual/en/function.session-start.php
	if(!session_start()) {
		// If the session couldn't start, present an error
		header("Location: error.php");
		exit;
	}
	
	
	// Check to see if the user has already logged in
	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	
	if ($loggedIn) {
		header("Location: home.php");
		exit;
	}
	
	
	$action = empty($_POST['action']) ? '' : $_POST['action'];
	
	if ($action == 'do_create') {
		handle_login();
	} else {
		login_form();
	}
	
	
    function handle_login(){
        $firstName = empty($_POST['firstName']) ? '' : $_POST['firstName'];
        $lastName = empty($_POST['lastName']) ? '' : $_POST['lastName'];
        $username = empty($_POST['username']) ? '' : $_POST['username'];
        $password = empty($_POST['password']) ? '' : $_POST['password'];
        $confirmPass = empty($_POST['confirmPass']) ? '' : $_POST['confirmPass'];
        $birthday = empty($_POST['birthday']) ? '' : $_POST['birthday'];
        $email = empty($_POST['email']) ? '' : $_POST['email'];
        
        
        if(strcmp($password, $confirmPass) == 0){
            require_once 'db.conf';
            $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            
            if($conn -> connect_error){
                $error = "Error: " . $conn->connect_errno . '' . $conn->connect_error;
                require 'createUser_form.php';
                exit;
            }
            
            $username = $conn-> real_escape_string($username);
            
            $query = "SELECT id FROM users WHERE userName = '$username'";
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) {
                $error = "User Already Exists!";
                require "login_form.php";
                exit;
            }
            
            
            $password = $conn-> real_escape_string($password);
            $password = sha1($password);
            
            $query = "insert into users (firstName, lastName, username, password, email, birthday, addDate, changeDate) values ('$firstName', '$lastName', '$username', '$password', '$email', STR_TO_DATE('$birthday', '%Y-%m-%d'), now(), now())";
            
            print $query;
            //exit;
            
            if($conn -> query($query) === TRUE){
                $error = "New User Created Successfully";
                require "login_form.php";
                exit;
            }
            else{
                $error = "Insert Error: " . $query . "<br>" . $conn -> error;
                require "createUser_form.php";
                exit;
            }
            
            $mysqli -> close();
        }
        else{
            $error = "Error: Password do not match!";
            require "createUser_form.php";
            exit;
        }
        
    }


	function login_form() {
		$username = "";
		$error = "";
		require "login_form.php";
        exit;
	}
	
?>