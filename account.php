<?php
    require_once("Menu/MenuComponent.php");
    require("Menu/Menu.php");

    $currentPage = '';
    $menu = new MenuComponent($menuItems, $currentPage);

    $result = $menu->generate();
    $menuCSSFile = $result['cssFile'];
    $menuHTML = $result['html'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Account</title>
    <?php print $references; ?>
<style>

</style>
<script>
    function getUsername () {
        $("#nameBox").attr("value", "<?php echo $username ?>");
    }
    
    function changeName () {
        var newname = $("#nameBox").val();
        window.location.href = "changeUsername.php?newusername=" + newname; 
    }
    
    

</script>
</head>
<body onload="getUsername();">
    <?php print $title; ?>
        <div id="wrapper">
            <div id="inner">
                <?php print $menuHTML; ?>
                <div id="buffer">
                    <?php print $user;?>
                </div>
                <div id="content">
                    <h1 id="tabTitle">Account</h1> 
                    <div id="contentBox" id="loginWidget" class="ui-widget">
                        <form id="messageForm" name=nameBox onSubmit="changeName(); return false; ">
                                <p>
                                    <label for="nameBox" class="nameBox" id="label">Username:</label>
                                    <input size="60" type="text" name="messageBox" class="messageBox" id="nameBox" value="" required>
                                    <input type="button" value="Change" onclick="changeName();">
                                </p>
                        </form>
                        <form action="uploadUserImage.php" method="post" enctype="multipart/form-data">
                            Select image to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload Image" name="submit">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>