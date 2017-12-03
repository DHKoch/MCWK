<?php
    require_once 'db.conf';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if ($conn->connect_error) {
            $error = 'Error: ' . $conn->connect_errno . ' ' . $conn->connect_error;
            exit;
    }

    $query = "SELECT id, username, addDate, imagePath FROM users ORDER BY username";

    $result = $conn->query($query);

	$members = array();

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($members, $row);
		}
	}

    $memberlist = "";

    foreach ($members as $member) {
			$id = $member['id'];
            $username = $member['username'];
            $username = substr($username,0,14);
			$addDate = $member['addDate'];	
            $image = $member['imagePath'];
            if(file_exists($image)){
                $userPicture = $image;
            }
            else {
                $userPicture = "images/user.png";
            }
			$memberlist .= 
                    "<div class = \"padding\">\n
                    <div class = \"userBox\">\n
                    <p><img class=\"userImage\" src=\"$userPicture\"/></p>\n
                    <div class = \"usertext\">
                    $username\n
                    <p>$addDate</p>\n
                    </div>\n
                    </div>\n
                    </div>\n";
    }
            // Close the DB connection
    $conn->close();


?>