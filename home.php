<?php
    require_once("Menu/MenuComponent.php");
    require("Menu/Menu.php");

    $currentPage = 'Home';
    $menu = new MenuComponent($menuItems, $currentPage);

    $result = $menu->generate();
    $menuCSSFile = $result['cssFile'];
    $menuHTML = $result['html'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
    <?php print $references; ?>
</head>
<body>
    <?php print $title; ?>
        <div id="wrapper">
            <div id="inner">
                <?php print $menuHTML; ?>
                <div id="buffer">
                    <?php print $user;?>
                </div>
                <div id="content">
                    <h1 id="tabTitle">Welcome to the Official MCWK Website</h1> 
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/5B5QaopxlYs" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    
</body>
</html>
