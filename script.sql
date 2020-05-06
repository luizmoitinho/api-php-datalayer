
drop database if exists tb_usuario;

create database tb_usuario;
use db_api_rest;
alter table tb_usuario add constraint `pk_tb_usuario` primary key(id_usuario);
alter table tb_usuario change id_usuario id_usuario int not null auto_increment;
