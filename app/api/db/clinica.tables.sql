-- Tabla Departamento
CREATE TABLE departamento (
    id_departamento INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    CONSTRAINT uk_departamento_nombre UNIQUE (nombre)
);
insert into departamento (nombre) values ('Laboratorios'), ('Cirugia'), ('Recursos Humanos'), ('Farmacia');

-- Tabla Usuario
CREATE TABLE usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    contra VARCHAR(255) NOT NULL,
    CONSTRAINT uk_usuario_username UNIQUE (username)
);
insert into usuario (username,contra) values ('superad','1');
-- Tabla Permisos
CREATE TABLE permisos (
    id_permiso INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    departamento INT NOT NULL,
    CONSTRAINT fk_permisos_departamento FOREIGN KEY (departamento) REFERENCES departamento(id_departamento) ON DELETE RESTRICT ON UPDATE CASCADE
);


-- Tabla Rol
CREATE TABLE rol (
    id_rol INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    tipo ENUM('ADMINISTRADOR', 'NORMAL') NOT NULL,
    departamento INT NOT NULL,
    CONSTRAINT uk_rol_nombre_depto UNIQUE (nombre, departamento),
    CONSTRAINT fk_rol_departamento FOREIGN KEY (departamento)
        REFERENCES departamento(id_departamento)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);
insert into rol (nombre, tipo, departamento) values ('jefe', 'ADMINISTRADOR', 1);

insert into rol (nombre, tipo, departamento) values ('doctor', 'NORMAL', 1);
insert into permisos (nombre, descripcion, departamento) values ('VP1', 'Ver listado de pacientes', 1);


-- Tabla Rol_Permisos
CREATE TABLE rol_permisos (
    rol INT,
    permiso INT,
    PRIMARY KEY (rol, permiso),
    CONSTRAINT fk_rolpermisos_rol FOREIGN KEY (rol)
        REFERENCES rol(id_rol)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_rolpermisos_permisos FOREIGN KEY (permiso)
        REFERENCES permisos(id_permiso)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Tabla Empleado
CREATE TABLE empleado (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    departamento INT NOT NULL,
    usuario INT NOT NULL UNIQUE,
    rol INT NOT NULL,
    CONSTRAINT fk_empleado_departamento FOREIGN KEY (departamento)
        REFERENCES departamento(id_departamento)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_empleado_usuario FOREIGN KEY (usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_empleado_rol FOREIGN KEY (rol)
        REFERENCES rol(id_rol)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);
insert into empleado (nombre, departamento, usuario, rol) values ('Juan pruebas', 1,  1, 1);
