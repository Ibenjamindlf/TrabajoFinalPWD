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
    fechaFin TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    Foreign Key (idCompra) REFERENCES compra(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
    Foreign Key (idCET) REFERENCES compraEstadoTipo(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);

/*BLOQUE 4
menu*/

CREATE TABLE menu(
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(250) NOT NULL,
    link VARCHAR(250) NOT NULL,
    idPadre INT,
    deshabilitado TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    Foreign Key (idPadre) REFERENCES menu(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT 
);
CREATE TABLE menuRol(
    id INT NOT NULL AUTO_INCREMENT,
    idMenu INT,
    idRol INT,
    PRIMARY KEY (id),
    FOREIGN KEY (idMenu) REFERENCES menu(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (idRol) REFERENCES rol(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);



/*
Este create table es provisiorio, en comentarios por modificaciones
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
*/

/** Inserta los tipos de estado de compra*/
INSERT INTO compraEstadoTipo (id, descripcion, detalle) VALUES 
(1, 'CARRITO', 'Compra en proceso, no finalizada por el usuario.'),
(2, 'PENDIENTE_PAGO', 'A la espera de confirmación de pago.'),
(3, 'PAGO_ACEPTADO', 'Pago confirmado y recibido.'),
(4, 'PAGO_RECHAZADO', 'Pago rechazado por la pasarela.'),
(5, 'PREPARACION', 'El pedido se está preparando para su envío.'),
(6, 'ENVIADO', 'El pedido fue entregado al transportista.'),
(7, 'ENTREGADO', 'El cliente ha recibido su pedido.'),
(8, 'CANCELADO', 'El pedido ha sido cancelado.'),
(9, 'FALLA_ENTREGA', 'El transportista no pudo completar la entrega.'),
(10, 'DEVUELTO', 'El cliente ha solicitado y completado una devolución.');

/**Para continuar la numeración automática si no usas los IDs sugeridos, 
 usa AUTO_INCREMENT, pero para el ejemplo, forzamos los IDs para claridad.*/

INSERT INTO `producto`(`nombre`, `stock`, `precio`, `detalle`, `imagen`) 
VALUES 
('CIRO Y LOS PERSAS / NARANJA PERSA','50','850','1.Amor Prohibido. 2.Luz. 3.Juira!. 4.La rosa. 5.Hoy te vas. Interprete: Ciro y los persas','Vista/sources/img/ciro-y-los-persas-naranja-persa.jpg'),
('PESCADO RABIOSO / LO MEJOR DE PESCADO RABIOSO (LP)','50','864','1.Post-crucifixion. 2.Cementerio club. 3.corto. 4.despierta nena. 5.nena boba. Interprete: Pescado rabioso','Vista/sources/img/pescado-rabioso-lo-mejor.jpg'),
('LOS GATOS / EN VIVO','50','6000','1.Mama rock. 2.Mujer de carbon. 3.Blues de la calle 23. 4.Cancion para un ladron. 5.Campo para tres. Interprete: Los gatos','Vista/sources/img/los-gatos-en-vivo.jpg'),
('PESCADO RABIOSO / ARTAUD','50','78200','1.Por. 2.Todas las hojas son viento. 3.Cementerio Club. 4.Bajan. 5.La cantata de puentes amarillos. Interprete: Pescado rabioso','Vista/sources/img/pescado-rabioso.jpg'),
('GUSTAVO CERATI – SIEMPRE ES HOY (LP Doble)','50','55000','1.Artefacto. 2.Naci para esto. 3.Casa. 4.Torre de Marfil. 5.Especie. Interprete: Gustavo Cerati','Vista/sources/img/gustavo-cerati-siempre-es-hoy.jpg');
