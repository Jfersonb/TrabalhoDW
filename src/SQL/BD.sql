create database vidaSerena;

use vidaSerena;

create table cadastroUsers(
    id int auto_increment primary key,
    nome varchar(250) not null,
    cpf int not null unique,
    telefone int not null unique,
    email varchar(250) not null unique,
    senha varchar(100) not null,
    arquivo longblob
);

create table cadastroFamilia(
    id int auto_increment primary key,
    id_usuario int,
    tipoParentesco varchar(100) not null,
    endereco varchar(150) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

create table cadastroCuidador(
    id int auto_increment primary key,
    id_usuario int,
    cursos varchar(250) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

create table cadastroEnfermeiro(
    id int auto_increment primary key,
    id_usuario int,
    coren varchar(30) not null,
    cip varchar(30) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

create table cadastroMedico(
    id int auto_increment primary key,
    id_usuario int,
    crm varchar(30) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

create table cadastroMIdoso(
    id int auto_increment primary key,
    id_usuario int,
    resposavel varchar(150) not null,
    condicoesMedicas varchar(250) not null,
    medicamentosUso varchar(250) not null,
    resticoesAlimentar varchar(250) not null,
    alergias varchar(250) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

create table cadastroMedicamentos(
    id int auto_increment primary key,
    tipoMedicamento enum(
        'Sem tarja',
        'Tarja amarela',
        'Tarja vermelha',
        'Tarja preta'
    ) not null,
    quantDeCaixa int not null,
    quantPorCaixa int not null,
    arquivo longblob
);