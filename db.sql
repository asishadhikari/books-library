--- Drop all existing tables ---
CREATE DATABASE IF NOT EXISTS BOOKS;
USE BOOKS;
---CREATE USER 'USER1'@'localhost' IDENTIFIED BY 'USER1PASSWORD';
---GRANT ALL PRIVILEGES ON BOOKS.* TO 'USER1'@'localhost';    

DROP TABLE IF EXISTS title;
DROP TABLE IF EXISTS year;
DROP TABLE IF EXISTS price;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS author;

create table title(
    title_id int not null,
    title_name varchar(255) not null,
    category_id int,
    author_id int,
    primary key (title_id)
);

create table year (
    year int(4) not null,
    title_id int
);

create table price (
    price decimal(4, 2) not null,
    title_id int
);

create table category (
    category_id int not null,
    category varchar(32) not null,
    primary key (category_id)
);

create table author (
    author_id int not null,
    author varchar(32) not null,
    primary key (author_id)
);





