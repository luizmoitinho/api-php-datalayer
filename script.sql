

create database db_api_rest;
use db_api_rest;

create table tb_usuario(
    id_usuario int not null primary key,
    nome_usuario varchar(45) not null,
    email_usuario varchar(30) not null,
    usuario varchar(15) not null,
    senha varchar(8) not null
)

alter table tb_usuario add constraint `pk_tb_usuario` primary key(id_usuario);
alter table tb_usuario change id_usuario id_usuario int not null auto_increment;
