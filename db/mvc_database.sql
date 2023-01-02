drop schema if exists mvc_database;
create schema mvc_database;
use mvc_database;

create table users(
    id int primary key auto_increment,
    email varchar(45),
    pass varchar(45),
    isEmailConfirmed INT NOT NULL DEFAULT 0,
    emailToken VARCHAR(20) NOT NULL
);

select * from users;
