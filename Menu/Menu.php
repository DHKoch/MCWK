<?php
    require('checkLogin.php');

    $menuItems = array();
    $menuItems[] = array('label' => 'Home', 'link' => 'home.php');
    $menuItems[] = array('label' => 'Chat', 'link' => 'chat.php');
    $menuItems[] = array('label' => 'Forums', 'link' => 'forums.php');
    $menuItems[] = array('label' => 'Memes', 'link' => 'memes.php');
    $menuItems[] = array('label' => 'About', 'link' => 'about.php');
    $menuItems[] = array('label' => 'Members', 'link' => 'members.php');
    
    if (!$loggedIn) {
		$menuItems[] = array('label' => 'Login', 'link' => 'login_form.php');
        $user = "<div id=\"user\">
            <p>User</p>
            <img src=\"images/noUser.jpg\">
            <p>Not Logged In</p>
            <button onclick=\"window.location.href='login.php'\">Login</button>
        </div>";
        
	}
    else {
        $menuItems[] = array('label' => 'Logout', 'link' => 'logout.php');
        $username = $_SESSION['loggedin'];
        $userID = $_SESSION['userID'];
        $image = $_SESSION['imagePath'];
        
        if(file_exists($image)){
            $userPicture = $image;
        }
        else {
            $userPicture = "images/user.png";
        }
            
        $user = "<div id=\"user\">
            <p>User</p>
            <img src=\"$userPicture\">
            <p>".$username."</p>
            <button class=\"stack\" onclick=\"window.location.href='account.php'\">Account</button>
        </div>";
    }
    
    $title = "<h1 id=pageTitle>Middle Class White Kids</h1>";

    $references = "<link href=\"jquery-ui-1.11.4.custom/jquery-ui.min.css\" rel=\"stylesheet\" type=\"text/css\">\n
    <script src=\"jquery-ui-1.11.4.custom/external/jquery/jquery.js\"></script>\n
    <script src=\"jquery-ui-1.11.4.custom/jquery-ui.min.js\"></script>\n
    <link rel=\"stylesheet\" href=\"Menu/menu_style.css\" type=\"text/css\">\n
    <link href=\"https://fonts.googleapis.com/css?family=Play\" rel=\"stylesheet\">\n<link href=\"app.css\" rel=\"stylesheet\" type=\"text/css\">";

?>