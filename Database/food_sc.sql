create database food_sc;

use food_sc;

create table customers
(
  customerid varchar(12) not null primary key,
  name char(60) not null,
  sex int unsigned,
  age int unsigned,
  phone varchar(20) not null,
  qq varchar(20),
  email varchar(30),
  password char(40) not null,
  address char(80) not null,
  city char(30) not null,
  state char(20),
  zip char(10),
  country char(20) not null
);

create table orders
(
  orderid int unsigned not null auto_increment primary key,
  customerid varchar(12) not null,
  amount float(6,2),
  date date not null,
  order_status char(10),
  ship_name char(60) not null,
  ship_address char(80) not null,
  ship_city char(30) not null,
  ship_state char(20),
  ship_zip char(10),
  ship_country char(20) not null
);

create table foods
(
   foodid int unsigned not null auto_increment primary key,
   title char(100),
   catid int unsigned,
   price float(4,2) not null,
   stock int unsigned,
   status int unsigned,
   description varchar(255)
);

create table merchants
(
  catid int unsigned not null auto_increment primary key,
  catname char(60) not null,
  phone char(20),
  address char(100),
  recommend int unsigned
);

create table order_items
(
  orderid int unsigned not null,
  foodid int unsigned  not null,
  item_price float(4,2) not null,
  quantity tinyint unsigned not null,
  primary key (orderid, foodid)
);

create table admin
(
  username char(16) not null primary key,
  password char(40) not null
);

grant select, insert, update, delete
on food_sc.*
to food_sc@localhost identified by 'password';
