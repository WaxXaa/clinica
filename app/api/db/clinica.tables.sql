-- Tabla Departamento
CREATE TABLE departamento (
    id_departamento INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    CONSTRAINT uk_departamento_nombre UNIQUE (nombre)
);
insert into departamento (id_departamento, nombre) values
(1,'Direccion'),
(2,'Recursos Humanos'),
(3,'Inventario'),
(4,'Medicina General'),
(5,'Laboratorios'),
(6'Cirugia'),
(7,'Enfermeria'),
(8,'Cardiologia'),
(9,'Neurologia'),
(10,'Ginecologia'),
(11,'Pediatra'),
(12,'Oftalmologia'),
(13,'Ortopedia'),
(14,'Urologia'),
(15,'Traumatologia'),
(16,'Rehabilitacion'),
(17,'Nutricion'),
(18,'Psicologia'),
(19,'Fisioterapia'),
(20,'Odontologia'),
(21,'Medicina Interna');

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
    id_permiso INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    departamento INT NOT NULL,
    CONSTRAINT fk_permisos_departamento FOREIGN KEY (departamento) REFERENCES departamento(id_departamento) ON DELETE RESTRICT ON UPDATE CASCADE
);


-- Tabla Rol
CREATE TABLE rol (
    id_rol INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    tipo ENUM('ADMINISTRADOR', 'NORMAL') NOT NULL,
    departamento INT NOT NULL,
    CONSTRAINT uk_rol_nombre_depto UNIQUE (nombre, departamento),
    CONSTRAINT fk_rol_departamento FOREIGN KEY (departamento)
        REFERENCES departamento(id_departamento)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);
-- para el departamento de direccion
insert into rol (id_rol, nombre, tipo, departamento) values
('D1','Director', 'ADMINISTRADOR', 1),
('SD1','Sub Director', 'ADMINISTRADOR', 1), -- tiene todos los permisos
('SC1','Secretario', 'NORMAL', 1),
('AS1','Asistente', 'NORMAL', 1);

-- para el departamento de medicina general
insert into rol (id_rol, nombre, tipo, departamento) values
('MG1','Jefe de Departamento', 'ADMINISTRADOR', 4),
('MG2','Médico(a) General', 'ADMINISTRADOR', 4),
('MG3','Recepcionista de Consultorio', 'NORMAL', 4),
('MG4','Asistente Médico', 'NORMAL', 4),
('MG5','Enfermero(a)', 'NORMAL', 4),
('MG6','Auxiliar de Enfermeria', 'NORMAL', 4),
('MG7','Encargado de Inventario', 'NORMAL', 4);

-- para el departamento de laboratorios
insert into rol (id_rol, nombre, tipo, departamento) values
('LB1','Jefe de Laboratorio', 'ADMINISTRADOR', 5),
('LB2','Técnico(a) de Laboratorio', 'NORMAL', 5),
('LB3','Asistente de Laboratorio', 'NORMAL', 5),
('LB4','Encargado de Inventario', 'NORMAL', 5);

-- para el departamento de cirugia
insert into rol (id_rol, nombre, tipo, departamento) values
('CG1','Jefe de Departamento', 'ADMINISTRADOR', 6),
('CG2','Cirujano(a)', 'ADMINISTRADOR', 6),
('CG3','Anestesiologo', 'NORMAL', 6),
('CG4','Técnico de Cirugía', 'NORMAL', 6),
('CG5','Recepcionista de Cirugía', 'NORMAL', 6),
('CG6','Enfermero(a)', 'NORMAL', 6),
('CG7','Auxiliar de Enfermeria', 'NORMAL', 6),
('CG8','Encargado de Inventario', 'NORMAL', 6);

-- para el departamento de enfermeria
insert into rol (id_rol, nombre, tipo, departamento) values
('EN1','Director(a) de Enfermería', 'ADMINISTRADOR', 7),
('EN2','Subdirector(a) de Enfermería', 'ADMINISTRADOR', 7),
('EN3','Asistente Administrativo de Enfermería', 'NORMAL', 7),
('EN4','Recepcionista de Enfermeria', 'NORMAL', 7);

-- para el departamento de cardiologia
insert into rol (id_rol, nombre, tipo, departamento) values
('CD1','Jefe de Departamento', 'ADMINISTRADOR', 8),
('CD2','Cardiologo(a)', 'ADMINISTRADOR', 8),
('CD3','Técnico de Cardiología', 'NORMAL', 8),
('CD4','Recepcionista de Cardiología', 'NORMAL', 8),
('CD5','Enfermero(a)', 'NORMAL', 8),
('CD6','Auxiliar de Enfermeria', 'NORMAL', 8),
('CD7','Encargado de Inventario', 'NORMAL', 8);

-- para el departamento de neurologia
insert into rol (id_rol, nombre, tipo, departamento) values
('NR1','Jefe de Departamento', 'ADMINISTRADOR', 9),
('NR2','Neurologo(a)', 'ADMINISTRADOR', 9),
('NR3','Técnico de Neurología', 'NORMAL', 9),
('NR4','Recepcionista de Neurología', 'NORMAL', 9),
('NR5','Enfermero(a)', 'NORMAL', 9),
('NR6','Auxiliar de Enfermeria', 'NORMAL', 9),
('NR7','Encargado de Inventario', 'NORMAL', 9);

-- para el departamento de ginecologia
insert into rol (id_rol, nombre, tipo, departamento) values
('GN1','Jefe de Departamento', 'ADMINISTRADOR', 10),
('GN2','Ginecologo(a)', 'ADMINISTRADOR', 10),
('GN3','Técnico de Ginecología', 'NORMAL', 10),
('GN4','Recepcionista de Ginecología', 'NORMAL', 10),
('GN5','Enfermero(a)', 'NORMAL', 10),
('GN6','Auxiliar de Enfermeria', 'NORMAL', 10),
('GN7','Encargado de Inventario', 'NORMAL', 10);

-- para el departamento de pediatra
insert into rol (id_rol, nombre, tipo, departamento) values
('PD1','Jefe de Departamento', 'ADMINISTRADOR', 11),
('PD2','Pediatra', 'ADMINISTRADOR', 11),
('PD3','Técnico de Pediatría', 'NORMAL', 11),
('PD4','Recepcionista de Pediatría', 'NORMAL', 11),
('PD5','Enfermero(a)', 'NORMAL', 11),
('PD6','Auxiliar de Enfermeria', 'NORMAL', 11),
('PD7','Encargado de Inventario', 'NORMAL', 11);

-- para el departamento de oftalmologia
insert into rol (id_rol, nombre, tipo, departamento) values
('OF1','Jefe de Departamento', 'ADMINISTRADOR', 12),
('OF2','Oftalmologo(a)', 'ADMINISTRADOR', 12),
('OF3','Técnico de Oftalmología', 'NORMAL', 12),
('OF4','Recepcionista de Oftalmología', 'NORMAL', 12),
('OF5','Enfermero(a)', 'NORMAL', 12),
('OF6','Auxiliar de Enfermeria', 'NORMAL', 12),
('OF7','Encargado de Inventario', 'NORMAL', 12);

-- para el departamento de ortopedia
insert into rol (id_rol, nombre, tipo, departamento) values
('OR1','Jefe de Departamento', 'ADMINISTRADOR', 13),
('OR2','Ortopedista', 'ADMINISTRADOR', 13),
('OR3','Técnico de Ortopedia', 'NORMAL', 13),
('OR4','Recepcionista de Ortopedia', 'NORMAL', 13),
('OR5','Enfermero(a)', 'NORMAL', 13),
('OR6','Auxiliar de Enfermeria', 'NORMAL', 13),
('OR7','Encargado de Inventario', 'NORMAL', 13);

-- para el departamento de urologia
insert into rol (id_rol, nombre, tipo, departamento) values
('UR1','Jefe de Departamento', 'ADMINISTRADOR', 14),
('UR2','Urologo(a)', 'ADMINISTRADOR', 14),
('UR3','Técnico de Urología', 'NORMAL', 14),
('UR4','Recepcionista de Urología', 'NORMAL', 14),
('UR5','Enfermero(a)', 'NORMAL', 14),
('UR6','Auxiliar de Enfermeria', 'NORMAL', 14),
('UR7','Encargado de Inventario', 'NORMAL', 14);

-- para el departamento de traumatologia
insert into rol (id_rol, nombre, tipo, departamento) values
('TR1','Jefe de Departamento', 'ADMINISTRADOR', 15),
('TR2','Traumatologo(a)', 'ADMINISTRADOR', 15),
('TR3','Técnico de Traumatología', 'NORMAL', 15),
('TR4','Recepcionista de Traumatología', 'NORMAL', 15),
('TR5','Enfermero(a)', 'NORMAL', 15),
('TR6','Auxiliar de Enfermeria', 'NORMAL', 15),
('TR7','Encargado de Inventario', 'NORMAL', 15);

-- para el departamento de rehabilitacion
insert into rol (id_rol, nombre, tipo, departamento) values
('RH1','Jefe de Departamento', 'ADMINISTRADOR', 16),
('RH2','Fisioterapeuta', 'ADMINISTRADOR', 16),
('RH3','Terapeuta Ocupacional', 'NORMAL', 16),
('RH4','Recepcionista de Rehabilitación', 'NORMAL', 16),
('RH5','Enfermero(a)', 'NORMAL', 16),
('RH6','Auxiliar de Enfermeria', 'NORMAL', 16),
('RH7','Encargado de Inventario', 'NORMAL', 16);

-- para el departamento de nutricion
insert into rol (id_rol, nombre, tipo, departamento) values
('NT1','Jefe de Departamento', 'ADMINISTRADOR', 17),
('NT2','Nutriologo(a)', 'ADMINISTRADOR', 17),
('NT3','Técnico de Nutrición', 'NORMAL', 17),
('NT4','Recepcionista de Nutrición', 'NORMAL', 17),
('NT5','Enfermero(a)', 'NORMAL', 17),
('NT6','Auxiliar de Enfermeria', 'NORMAL', 17),
('NT7','Encargado de Inventario', 'NORMAL', 17);

-- para el departamento de psiquiatria
insert into rol (id_rol, nombre, tipo, departamento) values
('PS1','Jefe de Departamento', 'ADMINISTRADOR', 18),
('PS2','Psiquiatra', 'ADMINISTRADOR', 18),
('PS3','Técnico de Psiquiatría', 'NORMAL', 18),
('PS4','Recepcionista de Psiquiatría', 'NORMAL', 18),
('PS5','Enfermero(a)', 'NORMAL', 18),
('PS6','Auxiliar de Enfermeria', 'NORMAL', 18),
('PS7','Encargado de Inventario', 'NORMAL', 18);

-- para el departamento de dermatologia
insert into rol (id_rol, nombre, tipo, departamento) values
('DR1','Jefe de Departamento', 'ADMINISTRADOR', 19),
('DR2','Dermatologo(a)', 'ADMINISTRADOR', 19),
('DR3','Técnico de Dermatología', 'NORMAL', 19),
('DR4','Recepcionista de Dermatología', 'NORMAL', 19),
('DR5','Enfermero(a)', 'NORMAL', 19),
('DR6','Auxiliar de Enfermeria', 'NORMAL', 19),
('DR7','Encargado de Inventario', 'NORMAL', 19);

-- para el departamento de odontologia
insert into rol (id_rol, nombre, tipo, departamento) values
('OD1','Jefe de Departamento', 'ADMINISTRADOR', 20),
('OD2','Odontologo(a)', 'ADMINISTRADOR', 20),
('OD3','Técnico de Odontología', 'NORMAL', 20),
('OD4','Recepcionista de Odontología', 'NORMAL', 20),
('OD5','Enfermero(a)', 'NORMAL', 20),
('OD6','Auxiliar de Enfermeria', 'NORMAL', 20),
('OD7','Encargado de Inventario', 'NORMAL', 20);

-- para el departamento de emergencias
insert into rol (id_rol, nombre, tipo, departamento) values
('EM1','Jefe de Departamento', 'ADMINISTRADOR', 21),
('EM2','Médico de Emergencias', 'ADMINISTRADOR', 21),
('EM3','Técnico de Emergencias', 'NORMAL', 21),
('EM4','Recepcionista de Emergencias', 'NORMAL', 21),
('EM5','Enfermero(a)', 'NORMAL', 21),
('EM6','Auxiliar de Enfermeria', 'NORMAL', 21),
('EM7','Encargado de Inventario', 'NORMAL', 21);

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
insert into empleado (nombre, departamento, usuario, rol) values ('Juan pruebas', 1,  1, 'D1');


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

