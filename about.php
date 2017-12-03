<?php
    require_once("Menu/MenuComponent.php");
    require("Menu/Menu.php");

    $currentPage = 'About';
    $menu = new MenuComponent($menuItems, $currentPage);

    $result = $menu->generate();
    $menuCSSFile = $result['cssFile'];
    $menuHTML = $result['html'];
?>

<!DOCTYPE html>
<html>
<head>
<title>About</title>
    <?php print $references; ?>
</head>
<style>
    #contentBox {
        padding: 10px;
        background-color: white;
        text-align: left;
        overflow:auto;
        font-family: sans-serif;
        background-color: #1D6893;
        border-radius: 15px;
        color: white;
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
                    <h1 id="tabTitle">About MCWK</h1> 
                    <div id="contentBox">
                        Middle Class White Kids (MCWK) was formed originally as GTA V crew back in late 2013. It has since evolved to a Teamspeak based community with 20+ consistent members. If you are interested in joining come see us in Teamspeak at 'ts.mcwk.us'.
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>
