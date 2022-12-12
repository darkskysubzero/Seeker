create database seekerdb;
grant all privilges on seekerdb.* to 'alin'@'localhost';

use seekerdb;

-- admins table
drop table if exists admins;
create table admins(
    adminID int not null primary key auto_increment,
    adminName varchar(50) not null,
    adminEmail varchar(50) not null,
    adminPassword varchar(255) not null 
);
insert into admins values(null,'bruce','bruce@wayne.com','00000');

-- products table
drop table if exists products;
create table products(
    productID int not null primary key auto_increment,
    productName varchar(100) not null,
    productCategory varchar(100) not null,
    productDescription text not null,
    productCostPrice decimal(10,2) not null,
    productSalePrice decimal(10,2) not null,
    productStock int not null,
    productImage varchar(255) null
);


drop table if exists users;
create table users(
    userID int not null primary key auto_increment,
    userName varchar(50) not null,
    userSurname varchar(50) not null,
    userEmail varchar(100) not null,
    userGender varchar(1) not null,
    userAge int(2) not null,
    userPhone int(10) not null,
    userPassword varchar(255) not null
);
insert into users values(null,"John","Wick","john@wick.com","M",10,0123456789,"00000");

-- messages table
drop table if exists contact;
create table contact(
    messageID int not null primary key auto_increment,
    messageTitle varchar(100) not null,
    messageText text not null,
    messageDate varchar(20) not null,
    userID int not null,
    constraint fk_user foreign key (userID) references users(userID) on delete cascade on update cascade 
);

insert into contact values(null,"Need help!","Can you please help me buying this product.","2020/11/03",1);

-- to get user name
-- select userName from users inner join contact on users.userID=contact.userID;


-- payments table
drop table if exists paymentdetails;
create table paymentdetails(
    paymentDetailsID int not null primary key auto_increment,
    paymentDetailsNameOnCard varchar(30) not null,
    paymentDetailsCardNumber varchar(13) not null,
    paymentDetailsCVC int(4) not null,
    paymentDetailsExpiryDate varchar(5) not null,
    userID int not null,
    constraint fk_user_paymentdetails foreign key (userID) references users(userID) on delete cascade on update cascade
);

-- delivery address table
drop table if exists deliveryaddress;
create table deliveryaddress(
    deliveryAddressID int not null primary key auto_increment,
    deliveryAddressProvince varchar(50) not null,
    deliveryAddressCity varchar(20) not null,
    deliveryAddressLocation varchar(255) not null,
    deliveryAddressPostal varchar(4) not null,
    userID int not null,
    constraint fk_user_deliveryaddress foreign key (userID) references users(userID) on delete cascade on update cascade

);

-- payments table
drop table if exists payments;
create table payments(
    paymentID int not null primary key auto_increment,
    paymentDate varchar(15) not null,
    paymentAmount decimal(10,2) not null,
    userID int not null,
    constraint fk_user_payments foreign key (userID) references users(userID) on delete cascade on update cascade
);

-- orders table
drop table if exists orders;
create table orders(
    orderID int not null primary key auto_increment,
    orderDate varchar(15) not null,
    paymentID int not null,
    constraint fk_payment_orders foreign key (paymentID) references payments(paymentID) on delete cascade on 
    update cascade
);

-- order products table (cart)
drop table if exists orderproducts;
create table orderproducts(
    orderID int not null,
    productID int not null,
    productQuantity int not null,

    constraint fk_order_orderproducts foreign key (orderID) references orders(orderID) on delete cascade on update cascade,

    constraint fk_product_orderproducts foreign key (productID) references products(productID) on delete cascade on update cascade
);

-- shipment table
drop table if exists shipment;
create table shipment(
    shipmentID int not null primary key auto_increment,
    shipmentDate varchar(15) not null,
    orderID int not null,
    deliveryAddressID int not null,

    constraint fk_order_shipment foreign key (orderID) references orders(orderID) on delete cascade on update cascade,

    constraint fk_delivery_shipment foreign key (deliveryAddressID) references deliveryaddress(deliveryAddressID) on delete cascade on update cascade

);