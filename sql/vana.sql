CREATE DATABASE vana;

USE VANA;

CREATE TABLE estatus (
    id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE rol (
	id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE usuario (
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido_paterno VARCHAR(50) NOT NULL,
    apellido_materno VARCHAR(50),
    correo VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    rol_id TINYINT UNSIGNED NOT NULL DEFAULT 2,
    estatus_id TINYINT UNSIGNED NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES rol (id),
    FOREIGN KEY (estatus_id) REFERENCES estatus (id)
) ENGINE = InnoDB;

CREATE TABLE habito (
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    frecuencia ENUM('diario', 'semanal', 'mensual', 'bimestral', 'trimestrual') NOT NULL,
    meta INT DEFAULT 1 NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('incompleto', 'completo') DEFAULT 'incompleto',
    usuario_id TINYINT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuario (id)
) ENGINE = InnoDB;

CREATE TABLE historial_habito (
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE NOT NULL,
    checkk BOOLEAN NOT NULL,
    habito_id TINYINT NOT NULL,
    FOREIGN KEY (habito_id) REFERENCES habito (id) ON DELETE CASCADE,
    UNIQUE (habito_id, fecha)
) ENGINE = InnoDB;

CREATE TABLE reporte_semanal (
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    semana_inicio DATE NOT NULL,
    semana_fin DATE NOT NULL,
    total_habitos INT NOT NULL, -- total de ids que tuvieron ingreso en habito_id en historial_habito, sin repeticiones
    habitos_checkk INT NOT NULL, -- total de registros en historial_habito de la semana
    usuario_id TINYINT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuario (id)
) ENGINE = InnoDB;

INSERT INTO historial_habito (fecha, checkk, habito_id) VALUES ('2025/05/11', 1, 2);

INSERT INTO historial_habito (fecha, checkk, habito_id) VALUES ('2025/05/11', 1, 8);

INSERT INTO reporte_semanal (semana_inicio, semana_fin, total_habitos, habitos_checkk, Usuario_id)
VALUES ('2025/05/05', '2025/05/11', 2, 2, 2);

INSERT INTO estatus (descripcion) VALUES
('Activo'),
('Eliminado');

INSERT INTO rol (nombre) VALUES 
('Administrador'),
('Usuario');

INSERT INTO usuario (nombre, apellido_paterno, apellido_materno, correo, password, rol_id, estatus_id) 
            VALUES('Daniela', 'Orozco', 'Ledesma', 'daniela.orozco5169@alumnos.udg.mx', 'hola', '1', '1');

insert into habito (nombre, descripcion, frecuencia, meta, usuario_id)
values ('lectura', 'little women', 'diario', 5, 2);

insert into habito (nombre, descripcion, frecuencia, meta, usuario_id)
values ('tejer', 'terminar proyecto', 'diario', 25, 2);

insert into habito (nombre, descripcion, frecuencia, meta, usuario_id)
values ('Dibujar', 'Terminar retrato de mamá', 'semanal', 9, 2);

insert into habito (nombre, descripcion, frecuencia, meta, usuario_id)
values ('Minecraf', 'Terminar castillo', 'mensual', 9, 2);

insert into habito (nombre, descripcion, frecuencia, meta, usuario_id)
values ('Joyeria', 'Crear nueva colección', 'bimestral', 9, 2);

insert into habito (nombre, descripcion, frecuencia, meta, usuario_id)
values ('Pilates', 'Programa intensivo', 'trimestrual', 9, 2);

insert into habito (nombre, descripcion, frecuencia, meta, estado, usuario_id)
values ('Correr', 'Prep.Maraton', 'trimestrual', 9, 'completo', 2);

insert into historial_habito (fecha, checkk, habito_id)
values ('2025-05-15', 1, 6);