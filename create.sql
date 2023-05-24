set names utf8;
drop database if exists employee;
create database 'employee' default character set utf8;

use employee;

drop table if exists 'department';
create table 'department'(
    'dept_id' int(111) not null auto_increment,
    'dept_name' varchar(255) not null default '',
    primary key ('dept_id')
) engine=innodb default charset=utf8;

insert into 'department' values
(1,'総務部'),(2,'営業部'),(3,'企画部'),(4,'開発部'),(5,'広報部');

drop table if exists 'employee';
create table 'employee' (
    'ID' int(11) not null auto_increment,
    'name' varchar(255) not null default '',
    'age' int(11) not null default '0',
    'address' varchar(255) not null default '',
    'dept_id' int(11) not null default '0',
    'updated_at' datetime not null default current_timestamp,
    'created_at' datetime not null default current_timestamp,
    primary key ('ID')
) engine=innodb default charset=utf8;

insert into 'employee' values
(1,'山田',25,'東京都世田谷区世田谷1-2-3',1,now(),now()),
(2,'佐藤',31,'東京都杉並区杉並1-2-3',3,now(),now()),
(3,'内藤',29,'東京都台東区台東1-2-3',5,now(),now()),
(4,'横山',35,'東京都板橋区上板橋1-2-3',2,now(),now()),
(5,'長崎',24,'東京都目黒区目黒1-2-3',2,now(),now());