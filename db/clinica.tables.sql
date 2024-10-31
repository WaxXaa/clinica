DROP IF EXIST DATABASE clinica;
CREATE DATABASE clinica;
use clinica;
CREATE TABLE roles (
    id_roles VARCHAR(4) PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT
);
INSERT INTO roles (id_roles, nombre, descripcion) VALUES ('RS01', 'Admin', 'usuario administrador del sistema, tiene permiso por defecto para hacer todo');
INSERT INTO roles (id_roles, nombre, descripcion) VALUES ('RM01', 'Medico', 'Medico atiende a los pacientes y usa el sistema');
INSERT INTO roles (id_roles, nombre, descripcion) VALUES ('RL01', 'Laboratorista','solo tiene acceso a ciertos datos del paciente y a insertar resultados del laboratorio al historial medico');

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contra VARCHAR(255) NOT NULL,
    correo_electronico VARCHAR(100) UNIQUE NOT NULL,
    rol VARCHAR(4) NOT NULL,
    FOREIGN KEY(rol) REFERENCES roles(id_roles),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO usuarios (contra,rol, correo_electronico) VALUES ('1','RS01','superad@email.com');


CREATE TABLE configuracion_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave_configuracion VARCHAR(50) UNIQUE NOT NULL,
    valor_configuracion TEXT,
    descripcion TEXT
);

CREATE TABLE registros_auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    accion VARCHAR(255) NOT NULL,
    detalles TEXT,
    direccion_ip VARCHAR(45),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    puesto VARCHAR(100),
    departamento VARCHAR(100),
    fecha_contratacion DATE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

DELIMITER //
CREATE PROCEDURE sp_registrar_empleado(
    IN usuario INT,
    IN p_nombre VARCHAR(50),
    IN p_apellido VARCHAR(50) NOT NULL,
    IN p_puesto VARCHAR(100),
    IN p_departamento VARCHAR(100),
    IN p_fecha_contratacion DATE
)
BEGIN
    INSERT INTO empleados (id_usuario, nombre, apellido, puesto, departamento, fecha_contratacion)
    VALUES (usuario, p_nombre, p_apellido, p_puesto, p_departamento, p_fecha_contratacion);
END//
DELIMITER:


DELIMITER //

CREATE PROCEDURE sp_registrar_usuario(
    IN p_contra VARCHAR(500),
    IN p_correo_electronico VARCHAR(100),
    IN p_rol VARCHAR(50)
)
BEGIN
    DECLARE v_id_rol;
    SELECT id_roles INTO v_id_rol FROM roles WHERE nombre = p_rol;

    INSERT INTO usuarios (contra, correo_electronico, rol)
    VALUES (p_contra, p_correo_electronico, v_id_rol);
END //

DELIMITER ;