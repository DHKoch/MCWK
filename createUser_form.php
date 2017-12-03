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
	<title>Create Account</title>
	<?php print $references; ?>
    <script>
        $(function(){
            $("input[type=submit]").button();
            
            $("#confirmPass").keyup(function(){
                var password = $("#password").val();
                var confirmPass = $("#confirmPass").val();
                
                consol.dir(confirmPass);
                
                if(password.localeCompare(confirmPass) != 0){
                    //$("$outputDiv").html("Password Don't Match!");
                    document.getElementById("confirmPass").setCustomValidity("Passwords Don't Match!");
                }
                else{
                    //$("#ouputDiv").html("Passwords Match");
                    document.getElementById("confirmPass").setCustomValidity("");
                }
            });
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
                        <h1 class="ui-widget-header">Create your account</h1>

                        <?php
                            if ($error) {
                                print "<div class=\"ui-state-error\">$error</div>\n";
                            }
                        ?>

                        <form action="createUser.php" method="POST">

                            <input type="hidden" name="action" value="do_create">

                            <div class="stack">
                                <label for="firstName">First name:</label>
                                <input type="text" id="firstName" name="firstName" class="ui-widget-content ui-corner-all" autofocus required>
                            </div>

                            <div class="stack">
                                <label for="lastName">Last name:</label>
                                <input type="text" id="lastName" name="lastName" class="ui-widget-content ui-corner-all" autofocus required>
                            </div>

                            <div class="stack">
                                <label for="username">User name:</label>
                                <input type="text" id="username" name="username" class="ui-widget-content ui-corner-all" autofocus required value="<?php print $username; ?>">
                            </div>

                            <div class="stack">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="ui-widget-content ui-corner-all" required>
                            </div>

                            <div class="stack">
                                <label for="confirmPass">Confirm Password:</label>
                                <input type="password" id="confirmPass" name="confirmPass" class="ui-widget-content ui-corner-all" required>
                            </div>

                            <div class="stack">
                                <label for="birthday">Birthday:</label>
                                <input type="date" id="birthday" name="birthday" class="ui-widget-content ui-corner-all" required>
                            </div>
                            <div class="stack">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="ui-widget-content ui-corner-all" required>
                            </div>

                            <div class="stack">
                                <input type="submit" value="Submit">
                            </div>
                        </form>

                        <br>
                        <div id="outputDiv"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>