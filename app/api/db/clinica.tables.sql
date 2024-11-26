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

insert into usuario (username,contra) values ('admin','1');

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
('Director', 'ADMINISTRADOR', 1),
('Sub Director', 'ADMINISTRADOR', 1), -- tiene todos los permisos
('Secretario', 'NORMAL', 1),
('Asistente', 'NORMAL', 1);

--para el departamento de recursos humanos
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 2),
('Especialista en Nóminas', 'NORMAL', 2),
('Atencion a Empleados', 'NORMAL', 2),
('Reclutador', 'NORMAL', 2);
('Asistente', 'NORMAL', 2);

-- para el departamento de inventario que tiene los siguientes roles Encargado(a) de Almacén,Coordinador(a) de Abastecimiento y Técnico(a) de Logística
insert into rol (id_rol, nombre, tipo, departamento) values
('Encargado(a) de Almacén', 'ADMINISTRADOR', 3),
('Coordinador(a) de Abastecimiento', 'NORMAL', 3),
('Técnico(a) de Logística', 'NORMAL', 3);

----para el departamento de medicina general que tiene los siguientes roles Médico(a) General, Recepcionista de Consultorio y Asistente Médico
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 4),
('Médico(a) General', 'ADMINISTRADOR', 4),
('Recepcionista de Consultorio', 'NORMAL', 4),
('Asistente Médico', 'NORMAL', 4),
('Enfermero(a)', 'NORMAL', 4),
('Auxiliar de Enfermeria', 'NORMAL', 4),
('Encargado de Inventario', 'NORMAL', 4);

--para el departamento de laboratorios que tiene los siguientes roles Jefe de Laboratorio, Técnico(a) de Laboratorio y Asistente de Laboratorio
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Laboratorio', 'ADMINISTRADOR', 5),
('Técnico(a) de Laboratorio', 'NORMAL', 5),
('Asistente de Laboratorio', 'NORMAL', 5),
('Encargado de Inventario', 'NORMAL', 5);

--para el departamento de cirugia que tiene los siguientes roles Jefe de Departamento, Cirujano(a), anestesiologo, tecnico de cirugia y asistente de cirugia, recepcionista de cirugia
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 6),
('Cirujano(a)', 'ADMINISTRADOR', 6),
('Anestesiologo', 'NORMAL', 6),
('Técnico de Cirugía', 'NORMAL', 6),
('Recepcionista de Cirugía', 'NORMAL', 6),
('Enfermero(a)', 'NORMAL', 6),
('Auxiliar de Enfermeria', 'NORMAL', 6),
('Encargado de Inventario', 'NORMAL', 6);

--para el departamento de enfermeria que tiene los siguientes roles Jefe de Enfermeria, Enfermero(a) General, y otros roles son mas administrativos
insert into rol (id_rol, nombre, tipo, departamento) values
('Director(a) de Enfermería', 'ADMINISTRADOR', 7),
('Subdirector(a) de Enfermería', 'ADMINISTRADOR', 7),
('Asistente Administrativo de Enfermería', 'NORMAL', 7),
('Recepcionista de Enfermeria', 'NORMAL', 7);

--para el departamento de cardiologia que tiene los siguientes roles Jefe de Departamento, Cardiologo(a), Tecnico de Cardiologia, Recepcionista de Cardiologia
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 8),
('Cardiologo(a)', 'ADMINISTRADOR', 8),
('Técnico de Cardiología', 'NORMAL', 8),
('Recepcionista de Cardiología', 'NORMAL', 8),
('Enfermero(a)', 'NORMAL', 8),
('Auxiliar de Enfermeria', 'NORMAL', 8),
('Encargado de Inventario', 'NORMAL', 8);

--para el departamento de neurologia que tiene los siguientes roles Jefe de Departamento, Neurologo(a), Tecnico de Neurologia, Recepcionista de Neurologia
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 9),
('Neurologo(a)', 'ADMINISTRADOR', 9),
('Técnico de Neurología', 'NORMAL', 9),
('Recepcionista de Neurología', 'NORMAL', 9),
('Enfermero(a)', 'NORMAL', 9),
('Auxiliar de Enfermeria', 'NORMAL', 9),
('Encargado de Inventario', 'NORMAL', 9);

--para el departamento de ginecologia que tiene los siguientes roles Jefe de Departamento, Ginecologo(a), Obstetra(medico), Tecnico de Ginecologia, Recepcionista de Ginecologia
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 10),
('Ginecologo(a)', 'ADMINISTRADOR', 10),
('Técnico de Ginecología', 'NORMAL', 10),
('Recepcionista de Ginecología', 'NORMAL', 10),
('Enfermero(a)', 'NORMAL', 10),
('Auxiliar de Enfermeria', 'NORMAL', 10),
('Encargado de Inventario', 'NORMAL', 10);

--para el departamento de pediatra que tiene los siguientes roles Jefe de Departamento, Pediatra, Tecnico de Pediatra, Recepcionista de Pediatra
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 11),
('Pediatra', 'ADMINISTRADOR', 11),
('Técnico de Pediatría', 'NORMAL', 11),
('Recepcionista de Pediatría', 'NORMAL', 11),
('Enfermero(a)', 'NORMAL', 11),
('Auxiliar de Enfermeria', 'NORMAL', 11),
('Encargado de Inventario', 'NORMAL', 11);

--para el departamento de oftalmologia que tiene los siguientes roles Jefe de Departamento, Oftalmologo(a), Tecnico de Oftalmologia, Recepcionista de Oftalmologia
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 12),
('Oftalmologo(a)', 'ADMINISTRADOR', 12),
('Técnico de Oftalmología', 'NORMAL', 12),
('Recepcionista de Oftalmología', 'NORMAL', 12),
('Enfermero(a)', 'NORMAL', 12),
('Auxiliar de Enfermeria', 'NORMAL', 12),
('Encargado de Inventario', 'NORMAL', 12);

--para el departamento de ortopedia que tiene los siguientes roles Jefe de Departamento, Ortopedista, Tecnico de Ortopedia, Recepcionista de Ortopedia
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 13),
('Ortopedista', 'ADMINISTRADOR', 13),
('Técnico de Ortopedia', 'NORMAL', 13),
('Recepcionista de Ortopedia', 'NORMAL', 13),
('Enfermero(a)', 'NORMAL', 13),
('Auxiliar de Enfermeria', 'NORMAL', 13),
('Encargado de Inventario', 'NORMAL', 13);

--para el departamento de urologia que tiene los siguientes roles Jefe de Departamento, Urologo(a), Tecnico de Urologia, Recepcionista de Urologia
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 14),
('Urologo(a)', 'ADMINISTRADOR', 14),
('Técnico de Urología', 'NORMAL', 14),
('Recepcionista de Urología', 'NORMAL', 14),
('Enfermero(a)', 'NORMAL', 14),
('Auxiliar de Enfermeria', 'NORMAL', 14),
('Encargado de Inventario', 'NORMAL', 14);

--para el departamento de traumatologia que tiene los siguientes roles Jefe de Departamento, Traumatologo(a), Tecnico de Traumatologia, Recepcionista de Traumatologia
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 15),
('Traumatologo(a)', 'ADMINISTRADOR', 15),
('Técnico de Traumatología', 'NORMAL', 15),
('Recepcionista de Traumatología', 'NORMAL', 15),
('Enfermero(a)', 'NORMAL', 15),
('Auxiliar de Enfermeria', 'NORMAL', 15),
('Encargado de Inventario', 'NORMAL', 15);

--para el departamento de rehabilitacion que tiene los siguientes roles Jefe de Departamento, Fisioterapeuta, Terapeuta Ocupacional, Recepcionista de Rehabilitacion
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 16),
('Fisioterapeuta', 'ADMINISTRADOR', 16),
('Terapeuta Ocupacional', 'NORMAL', 16),
('Recepcionista de Rehabilitación', 'NORMAL', 16),
('Enfermero(a)', 'NORMAL', 16),
('Auxiliar de Enfermeria', 'NORMAL', 16),
('Encargado de Inventario', 'NORMAL', 16);

--para el departamento de nutricion que tiene los siguientes roles Jefe de Departamento, Nutriologo(a), Tecnico de Nutricion, Recepcionista de Nutricion
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 17),
('Nutriologo(a)', 'ADMINISTRADOR', 17),
('Técnico de Nutrición', 'NORMAL', 17),
('Recepcionista de Nutrición', 'NORMAL', 17),
('Enfermero(a)', 'NORMAL', 17),
('Auxiliar de Enfermeria', 'NORMAL', 17),
('Encargado de Inventario', 'NORMAL', 17);


--para el departamento de psicologia que tiene los siguientes roles Jefe de Departamento, Psicologo(a), Tecnico de Psicologia, Recepcionista de Psicologia, encargado de inventario, enfermero(a), auxiliar de enfermeria

insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 18),
('Psicologo(a)', 'ADMINISTRADOR', 18),
('Técnico de Psicología', 'NORMAL', 18),
('Recepcionista de Psicología', 'NORMAL', 18),
('Enfermero(a)', 'NORMAL', 18),
('Auxiliar de Enfermeria', 'NORMAL', 18),
('Encargado de Inventario', 'NORMAL', 18);

--para el departamento de fisioterapia que tiene los siguientes roles Jefe de Departamento, Fisioterapeuta, Tecnico de Fisioterapia, Recepcionista de Fisioterapia, encargado de inventario, enfermero(a), auxiliar de enfermeria
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 19),
('Fisioterapeuta', 'ADMINISTRADOR', 19),
('Técnico de Fisioterapia', 'NORMAL', 19),
('Recepcionista de Fisioterapia', 'NORMAL', 19),
('Enfermero(a)', 'NORMAL', 19),
('Auxiliar de Enfermeria', 'NORMAL', 19),
('Encargado de Inventario', 'NORMAL', 19);


--para el departamento de odontologia que tiene los siguientes roles Jefe de Departamento, Odontologo(a), Tecnico de Odontologia, Recepcionista de Odontologia, encargado de inventario, enfermero(a), auxiliar de enfermeria

insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 20),
('Odontologo(a)', 'ADMINISTRADOR', 20),
('Técnico de Odontología', 'NORMAL', 20),
('Recepcionista de Odontología', 'NORMAL', 20),
('Enfermero(a)', 'NORMAL', 20),
('Auxiliar de Enfermeria', 'NORMAL', 20),
('Encargado de Inventario', 'NORMAL', 20);

--para el departamento de medicina interna que tiene los siguientes roles Jefe de Departamento, Medico Internista, Tecnico de Medicina Interna, Recepcionista de Medicina Interna, encargado de inventario, enfermero(a), auxiliar de enfermeria
insert into rol (id_rol, nombre, tipo, departamento) values
('Jefe de Departamento', 'ADMINISTRADOR', 21),
('Medico Internista', 'ADMINISTRADOR', 21),
('Técnico de Medicina Interna', 'NORMAL', 21),
('Recepcionista de Medicina Interna', 'NORMAL', 21),
('Enfermero(a)', 'NORMAL', 21),
('Auxiliar de Enfermeria', 'NORMAL', 21),
('Encargado de Inventario', 'NORMAL', 21);


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

