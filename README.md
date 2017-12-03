# MCWK

### Team Members:
William Givens,
Dalton Koch,
Troy Pei

Our application is based on the website 
[MCWK.us](https://ec2-52-14-189-142.us-east-2.compute.amazonaws.com/MCWK/home.php), where users can create individual profiles and participate in an online forum. Each threads is a topic ,within which users can contribute contents to the thread by adding posts or replies. Users will also be able to delete any contents they add into the forum. Our application creates a space for a specific group of gamers to share their user experiences and discuss gaming strategies and other interesting topics.

### Database Table Definitions:
create table threads (  
	threadID int not null auto_increment primary key,  
    title varchar(200) not null,  
    postUserID int not null,  
    addDate datetime not null,  
   	changeDate datetime not null  
);  

create table posts (  
	postID int not null auto_increment primary key,  
    	threadID int not null,  
    	postUserID int not null,  
    	postContent mediumtext not null,  
    	addDate datetime not null  
);  

create table likes (  
	likeID int not null auto_increment primary key,  
	postID int not null,  
    likeUserID int not null,  
    liked bool default false,  
    disliked bool default false  
);  

CREATE TABLE users (  
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  firstName text,  
  lastName text,  
  username text not null,  
  password text not null,  
  email text,  
  birthday datetime not null,  
  addDate datetime not null,  
  changeDate datetime not null,  
  imagePath varchar(1024) DEFAULT NULL  
);  

### Entity Relationship Diagram for Database:

![ERD](https://github.com/DHKoch/MCWK/blob/master/Database_ERD.jpeg)

### CRUD:
This web application meets the CRUD criteria in the following ways. First, the user can add a new thread by clicking the ‘New Thread’ button on the forum page, which satisfies the “Create” criterion in CRUD. The SQL statement is as follows:  “INSERT INTO threads (title, postUserID, addDate, changeDate) VALUES ('$thread_Title', '$session_ID', NOW(),NOW())”, which. can be found in the forums_process.php file at line 160.

Second, the forums page presents a table of all the threads in the threads table, satisfying the ‘Read’ criterion in CRUD. The SQL statement used is: “SELECT threads.threadID, threads.title, threads.postUserID, threads.addDate, threads.changeDate, users.username, users.imagePath FROM threads INNER JOIN users ON threads.postUserID = users.id ORDER BY threads.changeDate DESC”, which can be found in the forums_process.php file at line 317. 

Third, the user may update his or her account information, such as username. This meets the ‘Update’ criterion in CRUD. The SQL statement can be found at line 22 in changeUsername.php:  “UPDATE users SET username = '$newusername' WHERE id = $ID”.

Lastly, the “Delete” criterion in CRUD is satisfied when the user deletes his or her posts in a thread. The SQL statement used to perform this action, which can be found in forums_process.php at line 212, is “DELETE FROM posts WHERE postID = $post_ID AND postUserID = $session_ID”.






