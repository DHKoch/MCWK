<?php
    require_once("Menu/MenuComponent.php");
    require("Menu/Menu.php");

    $currentPage = 'Login';
    $menu = new MenuComponent($menuItems, $currentPage);

    $result = $menu->generate();
    $menuCSSFile = $result['cssFile'];
    $menuHTML = $result['html'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
    <?php print $references; ?>
    <script>
        $(function(){
            $("input[type=submit]").button();
        });
    </script>
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
                    <div id="loginWidget" class="ui-widget">
                        <h1 class="ui-widget-header">Login</h1>

                        <?php
                            if ($error) {
                                print "<div class=\"ui-state-error\">$error</div>\n";
                            }
                        ?>

                        <form action="login.php" method="POST">

                            <input type="hidden" name="action" value="do_login">

                            <div class="stack">
                                <label for="username">User name:</label>
                                <input type="text" id="username" name="username" class="ui-widget-content ui-corner-all" autofocus value="<?php print $username; ?>">
                            </div>

                            <div class="stack">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="ui-widget-content ui-corner-all">
                            </div>

                            <div class="stack">
                                <input type="submit" value="Submit">
                            </div>
                        </form>

                        <br>
                        <a href="createUser_form.php">Not a user?</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>