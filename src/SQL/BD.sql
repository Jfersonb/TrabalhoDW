use vidaSerena;

create table cadastroUsers(
    id int auto_increment primary key,
    nome varchar(250) not null,
    cpf varchar(14) not null unique,
    telefone varchar(15) not null unique,
    email varchar(250) not null unique,
    senha varchar(100) not null,
    arquivo longblob,
    perfil varchar(10)
);
insert into cadastroUsers (nome, cpf, telefone, email, senha, perfil)
values 
('Ana Souza', '111.111.111-11', '(63) 90000-0001', 'ana@email.com', 'senha123', 'admin'),
('Bruno Lima', '222.222.222-22', '(63) 90000-0002', 'bruno@email.com', 'senha123', 'admin'),
('Carlos Silva', '333.333.333-33', '(63) 90000-0003', 'carlos@email.com', 'senha123', 'usuario'),
('Daniela Ramos', '444.444.444-44', '(63) 90000-0004', 'daniela@email.com', 'senha123', 'usuario');

create table cadastroFamilia(
    id int auto_increment primary key,
    id_usuario int,
    tipoParentesco varchar(100) not null,
    endereco varchar(150) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

insert into
    cadastroFamilia (id_usuario, tipoParentesco, endereco)
values
    (3, 'Pai', 'Rua A, 123'),
    (4, 'Mãe', 'Rua B, 456'),
    (3, 'Irmão', 'Rua C, 789'),
    (4, 'Tia', 'Rua D, 321');

create table cadastroCuidador(
    id int auto_increment primary key,
    id_usuario int,
    cursos varchar(250) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

insert into
    cadastroCuidador (id_usuario, cursos)
values
    (3, 'Cuidador de Idosos - 160h'),
    (4, 'Primeiros Socorros'),
    (3, 'Técnicas de Mobilização'),
    (4, 'Cuidados com Alzheimer');

create table cadastroEnfermeiro(
    id int auto_increment primary key,
    id_usuario int,
    coren varchar(30) not null,
    cip varchar(30) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

insert into
    cadastroEnfermeiro (id_usuario, coren, cip)
values
    (3, 'COREN12345TO', 'CIP67890'),
    (4, 'COREN23456TO', 'CIP78901'),
    (3, 'COREN34567TO', 'CIP89012'),
    (4, 'COREN45678TO', 'CIP90123');

create table cadastroMedico(
    id int auto_increment primary key,
    id_usuario int,
    crm varchar(30) not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

insert into
    cadastroMedico (id_usuario, crm)
values
    (3, 'CRM1234TO'),
    (4, 'CRM2345TO'),
    (3, 'CRM3456TO'),
    (4, 'CRM4567TO');

create table cadastroIdoso(
    id int auto_increment primary key,
    id_usuario int,
    responsavel varchar(150) not null,
    condicoesMedicas text not null,
    medicamentosUso text not null,
    resticoesAlimentar text not null,
    alergias text not null,
    foreign key (id_usuario) references cadastroUsers(id)
);

insert into
    cadastroIdoso (
        id_usuario,
        responsavel,
        condicoesMedicas,
        medicamentosUso,
        resticoesAlimentar,
        alergias
    )
values
    (
        3,
        'Ana Souza',
        'Hipertensão',
        'Losartana',
        'Sem sal',
        'Nenhuma'
    ),
    (
        4,
        'Bruno Lima',
        'Diabetes',
        'Insulina',
        'Sem açúcar',
        'Lactose'
    ),
    (
        3,
        'Carlos Silva',
        'Demência',
        'Rivastigmina',
        'Sem glúten',
        'Amendoim'
    ),
    (
        4,
        'Daniela Ramos',
        'Artrose',
        'Paracetamol',
        'Nenhuma',
        'Nenhuma'
    );

create table cadastroMedicamentos(
    id int auto_increment primary key,
    nomeMedicamento varchar(150) not null,
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

insert into
    cadastroMedicamentos (
        nomeMedicamento,
        tipoMedicamento,
        quantDeCaixa,
        quantPorCaixa
    )
values
    ('Paracetamol', 'Sem tarja', 10, 20),
    ('Diazepam', 'Tarja preta', 5, 30),
    ('Losartana', 'Tarja vermelha', 8, 15),
    ('Insulina', 'Tarja amarela', 6, 10);