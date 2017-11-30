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

