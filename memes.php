<?php
    require_once("Menu/MenuComponent.php");
    require("Menu/Menu.php");

    $currentPage = 'Memes';
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
<title>Memes</title>
    <?php print $references; ?>
</head>
<style>
    #content img {
        width: 200px;
        height: 200px;
        padding: 30px;
    }
    
    #image {
        float: left;
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
                    <h1 id="tabTitle">Meme Page</h1> 
                    <?php
                        $dir = '/var/www/html/Final/memes';
                        $file_extension = array('jpg','jpeg','png','gif');

                        if(file_exists($dir) == false || is_readable($dir) == false){
                            echo ''. $dir.' is not a directory';
                        } 

                        else{
                            $files = scandir($dir);

                            foreach($files as $file){
                                $file_type = strtolower(end(explode('.', $file)));

                                if(in_array($file_type, $file_extension) == true && $file !== '..' && $file !== '.') {
                                    echo '<div id="image"><img src="memes/'.$file.'" alt="'.$file.'"/></div>'."\n";
                                }
                            }
                        }
                    ?>
                    
                </div>
            </div>
        </div>
</body>
</html>