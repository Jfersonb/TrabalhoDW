create database vidaSerena;
use vidaSerena;

create table cadastroUsers(
id int auto_increment unique,
nome varchar(250) not null,
cpf int not null,
telefone int not null,
emial varchar(250) not null,
senha1 varchar(100) not null,
senha2 varchar(100) not null,
arquivo longblob
);