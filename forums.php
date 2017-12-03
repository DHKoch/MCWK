<?php
    require_once("Menu/MenuComponent.php");
    require("Menu/Menu.php");

    $currentPage = 'Forums';
    $menu = new MenuComponent($menuItems, $currentPage);

    $result = $menu->generate();
    $menuCSSFile = $result['cssFile'];
    $menuHTML = $result['html'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Forums</title>
    <?php print $references; ?>
</head>
<style>

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
                    <h1 id="tabTitle">Forums</h1> 
                    <div id="contentBox">
                       
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>
