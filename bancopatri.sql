create database PatriLog;
#drop database PatriLog;

use PatriLog;

create table Decl(
id INT NOT NULL AUTO_INCREMENT,
primary key (id),
img blob,
numero varchar(40) not null,
descricao varchar(10) not null,
valor varchar(50) not null,
responsavel varchar(40),
locest varchar(40),
dataaquisicao date,
deprec varchar (20),
conserv varchar (15),
obs varchar(200)
);