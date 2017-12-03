<?php
    require("Menu/MenuComponent.php");
    require("Menu/Menu.php");

    $currentPage = 'Forums';
    $menu = new MenuComponent($menuItems, $currentPage);

    $result = $menu->generate();
    $menuCSSFile = $result['cssFile'];
    $menuHTML = $result['html'];

    if (!$loggedIn) {
		header("Location: login.php");
		exit;
	}

    require("forums_process.php");

?>

<!DOCTYPE html>
<html>
<head>
<title>Forums</title>
    <?php print $references; ?>
    <link rel="stylesheet" href="forum_style.css" type="text/css">
</head>
<style>
    
</style>
<script>

</script>
<body>
    <?php print $title; ?>
        <div id="wrapper">
            <div id="inner">
                <?php print $menuHTML; ?>
                <div id="buffer">
                    <?php print $user;?>
                </div>
                <div id="content">
                    <!--<h1 id="tabTitle"></h1>--> 
                    <div id="contentBox">
                       <?php print $forum_Content; ?>
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>
