<?php
    require_once("Menu/MenuComponent.php");
    require("Menu/Menu.php");
    require("getmembers.php");

    $currentPage = 'Members';
    $menu = new MenuComponent($menuItems, $currentPage);

    $result = $menu->generate();
    $menuCSSFile = $result['cssFile'];
    $menuHTML = $result['html'];

    if (!$loggedIn) {
        $msg = "You must be logged in to view this page!";

        function alert($msg) {
            echo "<script type='text/javascript'>alert('$msg');</script>";
        }
        
		header("Location: login.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Members</title>
    <?php print $references; ?>
</head>
<style>
     .userImage {
        width: 75px;
        height: 75px;
        padding-right: 25px;
        padding-left: 25px; 
    }
    
    .userBox {
        padding: 10px;
        background-color: white;
        text-align: left;
        overflow:auto;
        font-family: sans-serif;
        background-color: #1D6893;
        border-radius: 15px;
        color: white;
        width: 125px;
        height: 200px;

    }
    
    .padding {
        width 230px;
        height: 200px;
        padding: 20px;
        padding-left: 30px;
        padding-bottom: 40px;
        float: left;
    }
    
    .usertext {
        float: left;
        text-align: center;
    }
</style>

<body>
    <?php print $title; ?>
        <div id="wrapper">
            <div id="inner">
                <?php print $menuHTML; ?>
                <div id="buffer">
                    <?php print $user;?>
                </div>
                <div id="content">
                    <h1 id="tabTitle">Members</h1> 
                    <div>
                        <?php
                            echo $memberlist;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>