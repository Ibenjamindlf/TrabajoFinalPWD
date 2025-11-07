CREATE DATABASE db_ecommerce_PWD;
USE db_ecommerce_PWD;

-- 1. Tabla PRODUCTO
CREATE TABLE producto (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250) NOT NULL,
    stock INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    detalle TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL
    PRIMARY KEY (id)
);