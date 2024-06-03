
USE `Shift_management_system`;

CREATE TABLE `usuario` (
    `cedula` INT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `apellido` VARCHAR(255) NOT NULL,
    `telefono` VARCHAR(20)
);

CREATE TABLE `tipo_consulta` (
    `codigo` VARCHAR(2) PRIMARY KEY,
    `descripcion` VARCHAR(255) NOT NULL
);

CREATE TABLE `turno` (
    `id_turno` VARCHAR(50) PRIMARY KEY,
    `id_usuario` INT,
    `id_consulta` VARCHAR(50),
    `desc_turno` VARCHAR(255),
    `fecha` DATE,
    `hora` TIME,
    FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`cedula`),
    FOREIGN KEY (`id_consulta`) REFERENCES `tipo_consulta`(`codigo`)
);


CREATE TABLE `funcionario` (
    `cedula` VARCHAR(50) PRIMARY KEY,
    `id_turno` VARCHAR(50),
    `id_dependencia` VARCHAR(2),
    `nombre` VARCHAR(255),
    `apellido` VARCHAR(255),
    `email` VARCHAR(255),
    `contrasena` VARCHAR(255),
    FOREIGN KEY (`id_dependencia`) REFERENCES `tipo_consulta`(`codigo`),
    FOREIGN KEY (`id_turno`) REFERENCES `turno`(`id_turno`)
);