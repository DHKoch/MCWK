<?php
    require('checkLogin.php');
	$text = empty($_GET['text']) ? 'Unknown' : $_GET['text'];

    $fp = fopen("chatLog.html", 'a');
    fwrite($fp, "<div class='message'><b>".$loggedIn."</b>: ".htmlspecialchars($text)."<br></div>\n");
    fclose($fp);

    print "<b>$name: $text<br>\n";
?>