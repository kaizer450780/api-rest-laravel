CREATE DATABASE IF NOT EXISTS api_rest_laravel;
USE api_rest_laravel;

CREATE TABLE users{
id_user              int(255) auto_incremental NOT NULL,
email                varchar(255) NOT NULL,
id                   varchar(255) NOT NULL,
id_token             varchar(255) NOT NULL,
imagen               varchar(255) NOT NULL,
nombre               varchar(255) NOT NULL,
proveedor            varchar(255) NOT NULL,
remember_token       varchar(255),
tipo_usuario         varchar(50),
CONSTRAINT pk_users PRIMARY KEY(id)
}ENGINE=InnoDb;

CREATE TABLE escenarios{
id              int(255) auto_incremental NOT NULL,
nombre          varchar(255) NOT NULL,
codigo          varchar(50) NOT NULL,
imagen          varchar(255) NOT NULL,
descripcion     text,
CONSTRAINT pk_users PRIMARY KEY(id)
}ENGINE=InnoDb;

CREATE TABLE reserva{
id              int(255) auto_incremental NOT NULL,
id_user         int(255) NOT NULL,
id_reserva      int(255) NOT NULL,
reserva_creada  varchar(255) NOT NULL,
CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT fk_user_escenario FOREIGN KEY(id_user) REFERENCES users(id),
CONSTRAINT fk_user_reserva FOREIGN KEY(id_reserva) REFERENCES escenario(id),
}ENGINE=InnoDb;

CREATE TABLE users_registered(
id              int(255) auto_incremental NOT NULL,
nombre          varchar(255) NOT NULL,
apellido        varchar(255) NOT NULL,
email           varchar(255) NOT NULL,
contraseña      varchar(50) NOT NULL,
tipo_usuario   varchar(50) NOT NULL,
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;