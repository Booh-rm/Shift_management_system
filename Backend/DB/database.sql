
USE `Shift_management_system`;

CREATE TABLE `tb_usuario` (
    `cedula` INT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `apellido` VARCHAR(255) NOT NULL,
    `telefono` VARCHAR(20),
    `email` VARCHAR(255)
);

CREATE TABLE `tb_tipo_consulta` (
    `codigo` VARCHAR(2) PRIMARY KEY,
    `descripcion` VARCHAR(255) NOT NULL
);

CREATE TABLE `tb_funcionario` (
    `cedula` VARCHAR(50) PRIMARY KEY,
    -- `id_turno` VARCHAR(50),
    `id_dependencia` VARCHAR(2),
    `nombre` VARCHAR(255),
    `apellido` VARCHAR(255),
    `email` VARCHAR(255),
    `contrasena` VARCHAR(255),
    FOREIGN KEY (`id_dependencia`) REFERENCES `tb_tipo_consulta`(`codigo`)
    -- FOREIGN KEY (`id_turno`) REFERENCES `turno`(`id_turno`)
);
CREATE TABLE `tb_turno` (
    `id_turno` VARCHAR(50) PRIMARY KEY,
    `id_usuario` INT,
    `id_consulta` VARCHAR(50),
    `id_funcionario` VARCHAR(50),
    `desc_turno` VARCHAR(255),
    `fecha` DATE,
    `hora` TIME,
    FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario`(`cedula`),
    FOREIGN KEY (`id_consulta`) REFERENCES `tb_tipo_consulta`(`codigo`),
    FOREIGN KEY (`id_funcionario`) REFERENCES `tb_funcionario`(`cedula`)
);

CREATE TABLE login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    id_dependencia INT NOT NULL,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tb_funcionario(cedula)
);