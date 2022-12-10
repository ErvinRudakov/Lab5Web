create database web;

create table web.ad
(
    ID int auto_increment unique,
    EMAIL varchar(255) not null,
    TITLE varchar(255) not null,
    DESCRIPTION text not null,
    CATEGORY varchar(255) not null,
    CREATED datetime not null default NOW(),
    constraint ad_pk
        primary key (id)
);