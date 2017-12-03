<?php
require_once 'db.conf';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if ($conn->connect_error) {
            $error = 'Error: ' . $conn->connect_errno . ' ' . $conn->connect_error;
            $forum_Content = "<div>Connection Failed</div>\n"; 
            exit;
    }

$action = empty($_GET['action']) ? '' : $_GET['action'];

$session_ID = $_SESSION['userID'];
$session_ID = $conn->real_escape_string($session_ID);

switch ($action) {
        
    case "thread":
        
        $threadID = empty($_GET['threadID']) ? '' : $_GET['threadID'];
        $threadID = $conn->real_escape_string($threadID);
        
        $query = "SELECT posts.postID, posts.postUserID, posts.postContent, posts.addDate, threads.title as ThreadsTitle, users.username, users.imagePath FROM posts, threads, users WHERE posts.threadID = '$threadID' AND posts.postuserID = users.id AND threads.threadID = '$threadID' ORDER BY posts.addDate ASC";

        $result = $conn->query($query);
        
        if($result){
            $posts = array();  

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($posts, $row);
                }
            }
            else {
                $forum_Content = "<div>Query Failed</div>\n";
                break;
            }

            $query_array = $posts[0];
            $thread_Title = $query_array['ThreadsTitle'];
            $thread_Title = substr($thread_Title,0,60);

            $forum_Content = "<h1 id=\"thread_Title\">$thread_Title</h1><br>
                            <table>\n";

            foreach ($posts as $post) {
                $post_ID = $post['postID'];
                $thread_Title = $post['ThreadsTitle'];
                $post_Date = $post['addDate'];
                $post_Content = $post['postContent'];
                $post_Username = $post['username'];
                $post_Username = substr($post_Username,0,10);
                $post_UserImage = $post['imagePath'];
                $post_UserID = $post['postUserID'];

                if(file_exists($post_UserImage)){
                        $userPicture = $post_UserImage;
                }
                else {
                        $userPicture = "images/user.png";
                }

                if($session_ID == $post_UserID){
                    $delete = "<form action=\"forums.php?action=deletepost\" method=\"post\">\n
                                <input type=\"hidden\" name=\"post_ID\" value=\"$post_ID\"/>\n
                                <input type=\"hidden\" name=\"user_ID\" value=\"$post_UserID\"/>\n  
                                <button name=\"delete\" value=\"delete\">Delete</button>\n
                            </form>\n";
                }
                else{
                    $delete = "";
                }
                
                $vote = "<a href=\"forums.php?action=like&threadID=$threadID&postID=$post_ID\">\n
                                <button>Like</button>\n
                            </a>

                            <a href=\"forums.php?action=dislike&threadID=$threadID&postID=$post_ID\">\n
                                <button>Dislike</button>\n
                            </a>";
                
                
                $query = "SELECT likeID FROM likes WHERE likes.postID = '$post_ID' AND likes.liked = '1'";
                $result = $conn->query($query);
                $likes = $result->num_rows;
                
                $query = "SELECT likeID FROM likes WHERE likes.postID = '$post_ID' AND likes.disliked = '1'";
                $result = $conn->query($query);
                $dislikes = $result->num_rows;
                
                $total = ($likes - $dislikes);
                

                $forum_Content .= 
                    "
                    <tr>\n
                        <td><div class=\"post_User\"><img class=\"userImage\" src=\"$userPicture\"/><br>$post_Username</div>$delete</td>\n
                        <td>\n
                            <div class=\"post_Box\">\n
                                <div class=\"post_Content\">$post_Content</div>\n
                                <div class=\"post_Interaction\">$vote  Likes: $total</div>\n
                                <div class=\"post_Info\">$post_Date</div>\n
                            </div>\n
                        </td>\n
                    </tr>\n";
            }

            $forum_Content .= "</table>\n
                            <br\n>
                            <div id=\"post_Reply\">\n
                                <form action=\"forums.php?action=postreply\" method=\"post\">\n
                                    <input type=\"hidden\" name=\"thread_ID\" value=\"$threadID\"/>\n
                                    <textarea rows=\"1\" cols=\"50\" wrap=\"physical\" type=\"text\" id=\"post_ReplyBox\"  name=\"post_ReplyBox\"></textarea>\n
                                    <br>\n
                                    <button name=\"submit\" value=\"submit\">Reply</button>\n
                                </form>\n
                            </div>\n";
            $conn->close();
        }
        
        else {
            header("Location: forums.php?action=error");
        }
        
    break;
        
    case "newthread_form":
        
        $forum_Content = "<h1 id=\"tabTitle\">New Thread</h1><br>\n
                        <div id=\"create_ThreadBox\">\n
                             <form action=\"forums.php?action=newthread\" method=\"POST\">\n
                                <div>\n
                                    <label for=\"Thread Title\">Title: </label>\n
                                    <input type=\"text\" id=\"thread_TitleBox\" name=\"thread_title\">\n
                                </div>\n
                            
                                <div>\n
                                    <label for=\"Post Data\">Post: </label>\n
                                    <textarea rows=\"1\" cols=\"50\" wrap=\"physical\" type=\"text\" id=\"thread_PostContent\"  name=\"post_content\"></textarea>\n
                                </div>\n
                            
                                <div>\n
                                    <button name=\"submit\" value=\"submit\">Submit</button>\n
                                </div>\n
                            </form>\n
                        </div>\n"; 
        
    break;
        
    case "newthread":
        
        $thread_Title = empty($_POST['thread_title']) ? '' : $_POST['thread_title'];
        $thread_Title = $conn->real_escape_string($thread_Title);
        
        $post_Content = empty($_POST['post_content']) ? '' : $_POST['post_content'];
        $post_Content = $conn->real_escape_string($post_Content);
        
        $query = "INSERT INTO threads (title, postUserID, addDate, changeDate) VALUES ('$thread_Title', '$session_ID', NOW(),NOW())";
        $result = $conn->query($query);
        
        $query = "SELECT threadID FROM threads WHERE title = '$thread_Title' AND postUserID = '$session_ID'";
        $result = $conn->query($query);
        
        $query_array = $result->fetch_assoc();
        $thread_ID = $query_array['threadID'];
        
        $query = "INSERT INTO posts (threadID, postUserID, postContent, addDate) VALUES ('$thread_ID', '$session_ID', '$post_Content', NOW())";
        $result = $conn->query($query);
        
        header("Location: forums.php?action=thread&threadID=$thread_ID");
        
    break;
        
    case "postreply":
        
        $thread_ID = empty($_POST['thread_ID']) ? '' : $_POST['thread_ID'];
        $thread_ID = $conn->real_escape_string($thread_ID);
        
        $post_Content = empty($_POST['post_ReplyBox']) ? '' : $_POST['post_ReplyBox'];
        $post_Content = $conn->real_escape_string($post_Content);
        
        $query = "INSERT INTO posts (threadID, postUserID, postContent, addDate) VALUES ('$thread_ID', '$session_ID', '$post_Content', NOW())";
        $result = $conn->query($query);
        
        $query = "UPDATE threads SET changeDate = NOW() WHERE threadID = $thread_ID";
        $result = $conn->query($query);
        
        header("Location: forums.php?action=thread&threadID=$thread_ID");
        
    break;
        
    case "deletepost":
        
        $post_ID = empty($_POST['post_ID']) ? '' : $_POST['post_ID'];
        $post_ID = $conn->real_escape_string($post_ID);
        
        $post_userID = empty($_POST['post_userID']) ? '' : $_POST['post_userID'];
        $post_userID = $conn->real_escape_string($post_userID);

        $query = "SELECT users.id, posts.threadID FROM users, posts WHERE postID = $post_ID AND users.id = $session_ID";

        $result = $conn->query($query);
        
        if($result){
            $query_array = $result->fetch_assoc();
            $id = $query_array['id'];
            $thread_ID = $query_array['threadID'];

            if($id == $session_ID){
                $query = "DELETE FROM posts WHERE postID = $post_ID AND postUserID = $session_ID";

                $result = $conn->query($query);
            } 

            header("Location: forums.php?action=thread&threadID=$thread_ID");
        }
        
        else {
            header("Location: forums.php?action=error");
        }
        
    break; 
        
    case "like":
        $post_ID = empty($_GET['postID']) ? '' : $_GET['postID'];
        $threadID = empty($_GET['threadID']) ? '' : $_GET['threadID'];
        
        $query = "SELECT postID, liked, disliked FROM likes WHERE postID = $post_ID AND likeUserID = $session_ID";
        $result = $conn->query($query);
        
        if ($result->num_rows == 0) {
            $query = "INSERT INTO likes (postID, likeUserID, liked, disliked) VALUES ('$post_ID', '$session_ID', '1', '0')";
            $result = $conn->query($query);
            header("Location: forums.php?action=thread&threadID=$threadID");
            break;
        }
        
        $query_array = $result->fetch_assoc();
        $liked = $query_array['liked'];
        $disliked = $query_array['disliked'];
        
        if ($liked == 1 && $disliked == 0) {
            $query = "UPDATE likes SET liked = '0', disliked = '0' WHERE postID = $post_ID AND likeUserID = $session_ID";
            $result = $conn->query($query);
            header("Location: forums.php?action=thread&threadID=$threadID");
            break;
        }
        else if ($liked == 0 && $disliked == 1) {
            $query = "UPDATE likes SET liked = '1', disliked = '0' WHERE postID = $post_ID AND likeUserID = $session_ID";
            $result = $conn->query($query);
            header("Location: forums.php?action=thread&threadID=$threadID");
            break;
        }
        else if ($liked == 0 && $disliked == 0) {
            $query = "UPDATE likes SET liked = '1', disliked = '0' WHERE postID = $post_ID AND likeUserID = $session_ID";
            $result = $conn->query($query);
            header("Location: forums.php?action=thread&threadID=$threadID");
            break;
        }
        
        header("Location: forums.php?action=thread&threadID=$threadID");
        
    break;
        
    case "dislike":
        $post_ID = empty($_GET['postID']) ? '' : $_GET['postID'];
        $threadID = empty($_GET['threadID']) ? '' : $_GET['threadID'];
        
        $query = "SELECT postID, liked, disliked FROM likes WHERE postID = $post_ID AND likeUserID = $session_ID";
        $result = $conn->query($query);
        
        if ($result->num_rows == 0) {
            $query = "INSERT INTO likes (postID, likeUserID, liked, disliked) VALUES ('$post_ID', '$session_ID', '0', '1')";
            $result = $conn->query($query);
            header("Location: forums.php?action=thread&threadID=$threadID");
            break;
        }
        
        $query_array = $result->fetch_assoc();
        $liked = $query_array['liked'];
        $disliked = $query_array['disliked'];
        
        if ($disliked == 1 && $liked == 0) {
            $query = "UPDATE likes SET liked = '0', disliked = '0' WHERE postID = $post_ID AND likeUserID = $session_ID";
            $result = $conn->query($query);
            header("Location: forums.php?action=thread&threadID=$threadID");
            break;
        }
        else if ($disliked == 0 && $liked == 1) {
            $query = "UPDATE likes SET liked = '0', disliked = '1' WHERE postID = $post_ID AND likeUserID = $session_ID";
            $result = $conn->query($query);
            header("Location: forums.php?action=thread&threadID=$threadID");
            break;
        }
        else if ($disliked == 0 && $liked == 0) {
            $query = "UPDATE likes SET liked = '0', disliked = '1' WHERE postID = $post_ID AND likeUserID = $session_ID";
            $result = $conn->query($query);
            header("Location: forums.php?action=thread&threadID=$threadID");
            break;
        }
        
        header("Location: forums.php?action=thread&threadID=$threadID");
        
        
    break;
        
    case "error":
        
        $forum_Content = "<div>An error has occured</div>\n"; 
        
    break;    
        
    default:
        
        $query = "SELECT threads.threadID, threads.title, threads.postUserID, threads.addDate, threads.changeDate, users.username, users.imagePath FROM threads INNER JOIN users ON threads.postUserID = users.id ORDER BY threads.changeDate DESC";

        $result = $conn->query($query);
        
        if($result){
            $threads = array();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($threads, $row);
                }
            }
            else {
                header("Location: forums.php?action=error");
                break;
            }

            $forum_Content .= "<h1 id=\"tabTitle\">Threads</h1><br>\n
                                <table id=\"thread_Table\">";   

            foreach ($threads as $thread) {

                $thread_ID = $thread['threadID'];
                $thread_Title = $thread['title'];
                $thread_Title = substr($thread_Title,0,25);
                $thread_UserID = $thread['postUserID'];
                $thread_Date = $thread['addDate'];
                $thread_LastDate = $thread['changeDate'];
                //$thread_PostNum = $thread['postAmount'];
                $thread_Username = $thread['username'];

                $query = "SELECT posts.postUserID, posts.addDate, users.username, users.imagePath FROM posts, threads, users WHERE posts.threadID = '$thread_ID' AND posts.postuserID = users.id AND threads.threadID = '$thread_ID' ORDER BY posts.addDate DESC LIMIT 1";

                $result = $conn->query($query);
                $query_array = $result->fetch_assoc();

                $last_Post_User = $query_array['username'];
                $last_Post_User_Picture = $query_array['imagePath'];
                $last_Post_Date = $query_array['addDate'];

                if(file_exists($last_Post_User_Picture)){
                        $userPicture = $last_Post_User_Picture;
                }
                else {
                        $userPicture = "images/user.png";
                }

                $query = "SELECT posts.postID FROM posts, threads WHERE posts.threadID = '$thread_ID' AND threads.threadID = '$thread_ID'";
                $result = $conn->query($query);
                $thread_PostNum = $result->num_rows;

                $url = "forums.php?action=thread&threadID=$thread_ID";
                $forum_Content .= 
                    "<tr>\n
                        <td class=\"thread_LinkBox\">\n
                            <a class=\"thread_Link\" href=\"$url\">$thread_Title</a> <br> <span class=\"thread_info\">Started by $thread_Username, $thread_Date</span>\n
                        </td>\n
                        <td class=\"thread_PostAmount\">\n
                            Posts: $thread_PostNum
                        </td>\n
                        <td>\n
                            <div class=\"\"><img class=\"thread_UserImage\" src=\"$userPicture\"/></div>\n
                        </td>\n
                        <td class=\"thread_LastUser\">\n
                            <div class=\"thread_info\">$last_Post_User<br>$last_Post_Date</div>\n
                        </td>\n
                    </tr>\n";

                }

                $forum_Content .= "</table>\n
                                <br>\n
                                <a href=\"forums.php?action=newthread_form\">\n
                                <button>New Thread</button>\n
                                </a>\n"; 

            $conn->close();
        }
        
        else {
            header("Location: forums.php?action=error");
        }
        
    break;
}

?>