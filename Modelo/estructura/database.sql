CREATE DATABASE db_ecommerce_PWD;
USE db_ecommerce_PWD;

CREATE Table productos (
    id INT(10) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250) NOT NULL,
    PRIMARY KEY (id)
)