CREATE DATABASE bdcarritocompras;
USE bdcarritocompras;
 /*BLOQUE 1
 producto*/

CREATE TABLE producto (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250) NOT NULL,
    stock INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    detalle TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);


/*BLOQUE 2
usuario*/
CREATE TABLE usuario (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    password VARCHAR(250) NOT NULL,
    mail VARCHAR(250) NOT NULL UNIQUE,
    deshabilitado TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE rol (
    id INT NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(50),
    PRIMARY KEY (id)
);


CREATE TABLE usuarioRol (
    id INT NOT NULL AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    idRol INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (idUsuario) REFERENCES usuario(id),
    FOREIGN KEY (idRol) REFERENCES rol(id)
);

/* BLOQUE 3
 COMPRA*/

CREATE TABLE compra (
    id INT NOT NULL AUTO_INCREMENT,
    fecha TIMESTAMP NOT NULL,
    idUsuario INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (idUsuario) REFERENCES usuario(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT

);



CREATE TABLE compraProducto (
    id INT NOT NULL AUTO_INCREMENT,
    idCompra INT NOT NULL,
    idProducto INT NOT NULL,
    cantidad INT(3),
    PRIMARY KEY (id),
    FOREIGN KEY (idCompra) REFERENCES compra(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (idProducto) REFERENCES producto(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);



CREATE TABLE compraEstadoTipo (
    id INT NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR (50) NOT NULL,
    detalle VARCHAR(255),
    PRIMARY KEY (id)
);



CREATE TABLE compraEstado (
    id INT NOT NULL AUTO_INCREMENT,
    idCompra INT NOT NULL,
    idCET INT NOT NULL,
    fechaIni TIMESTAMP NOT NULL,
    fechaFin TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    Foreign Key (idCompra) REFERENCES compra(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
    Foreign Key (idCET) REFERENCES compraEstadoTipo(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);