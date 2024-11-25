-- Tabla Departamento
CREATE TABLE departamento (
    id_departamento INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    CONSTRAINT uk_departamento_nombre UNIQUE (nombre)
);
insert into departamento (nombre) values ('Laboratorios'), ('Cirugia'), ('Recursos Humanos'), ('Farmacia'), ('Direccion');

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


CREATE TABLE pacientes(){
    id_paciente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    sexo ENUM('M', 'F') NOT NULL,
    correo VARCHAR(100) not null,
    CONSTRAINT fk_paciente_departamento FOREIGN KEY (departamento)
        REFERENCES departamento(id_departamento)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
}
-- Tabla que relaciona pacientes con expedientes que tienen la enfermedad, fecha de creacion y el doctor que lo atendio, ademas de la descripcion de la enfermedad, tratamiento y medicamentos, examenes y resultados y diagnosticos

CREATE TABLE examenes(
    id_examen INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
)

CREATE TABLE expedientes_pacientes(
    id_expediente INT PRIMARY KEY AUTO_INCREMENT,
    paciente INT NOT NULL,
    sintomas TEXT NOT NULL,
    fecha_creacion DATE NOT NULL,
    doctor INT NOT NULL,
    tratamiento TEXT,
    medicamentos TEXT,
    diagnostico TEXT,
    CONSTRAINT fk_expediente_paciente FOREIGN KEY (paciente)
        REFERENCES pacientes(id_paciente)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_expediente_doctor FOREIGN KEY (doctor)
        REFERENCES empleado(id_empleado)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
)

-- tabla para relacionar el expediente de un paciente con los examenes que se le han realizado
CREATE TABLE expedientes_examenes(
    id_examen_paciente INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE NOT NULL,
    expediente INT NOT NULL,
    examen INT NOT NULL,
    resultados TEXT,
    CONSTRAINT fk_expediente_examenes FOREIGN KEY (expediente)
        REFERENCES expedientes_pacientes(id_expediente)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_expediente_examenes FOREIGN KEY (examen)
        REFERENCES examenes(id_examen)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)

-- se debe tener un control de los medicamentos que se tienen
CREATE TABLE medicamentos(
    id_medicamento INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
)

-- tabla para relacionar los medicamentos con los expedientes de los pacientes
CREATE TABLE medicamentos_expedientes(
    id_medicamento_paciente INT PRIMARY KEY AUTO_INCREMENT,
    expediente INT NOT NULL,
    medicamento INT NOT NULL,
    fecha DATE NOT NULL,
    CONSTRAINT fk_medicamento_expediente FOREIGN KEY (expediente)
        REFERENCES expedientes_pacientes(id_expediente)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_medicamento_expediente FOREIGN KEY (medicamento)
        REFERENCES medicamentos(id_medicamento)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)

-- tabla para relacionar los medicamentos con los empleados que los recetan solo pueden ser doctores y hay ocaciones en los que un doctor no tiene el permiso(debido a su rol para recetar cierto medicamento) por ejemlo un medico general no va a recetar medicamentos especifoicos para el corazon

CREATE TABLE medicamentos_doctores(
    id_medicamento_doctor INT PRIMARY KEY AUTO_INCREMENT,
    doctor INT NOT NULL,
    medicamento INT NOT NULL,
    CONSTRAINT fk_medicamento_doctor FOREIGN KEY (doctor)
        REFERENCES empleado(id_empleado)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_medicamento_doctor FOREIGN KEY (medicamento)
        REFERENCES medicamentos(id_medicamento)
        ON DELETE CASCADE
        ON UPDATE CASCADE 
)

