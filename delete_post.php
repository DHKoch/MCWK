<?php
    if ($_SERVER['HTTPS'] !== "on") {
		$redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header("Location: $redirectURL");
		exit;
	}	

	if(!session_start()) {

		header("Location: error.php");
		exit;
	}

        require_once 'db.conf';

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        if ($conn->connect_error) {
                $error = 'Error: ' . $conn->connect_errno . ' ' . $conn->connect_error;
                $threadlist = "<div>Connection Failed</div>\n"; 
                exit;
        }
        
        $post_ID = empty($_POST['post_ID']) ? '' : $_POST['post_ID'];
        $post_userID = empty($_POST['post_userID']) ? '' : $_POST['post_userID'];
        $session_ID = $_SESSION['userID'];

        $query = "SELECT users.id FROM users, posts WHERE postID = $post_ID AND users.id = $session_ID";

        $result = $conn->query($query);
        $query_array = $result->fetch_assoc();
        $id = $query_array['id'];
        
        if($id == $session_ID){
            $query = "DELETE FROM posts WHERE postID = $post_ID AND postUserID = $session_ID";

            $result = $conn->query($query);
        } 

        header("Location: forums.php");
?>