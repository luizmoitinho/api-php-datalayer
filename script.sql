
use db_api_rest;

create table tb_usuario(
    id_usuario int not null auto_increment primary key,
    nome_usuario varchar(45) not null,
    email_usuario varchar(30) not null,
    usuario varchar(15) not null,
    senha varchar(8) not null
)


