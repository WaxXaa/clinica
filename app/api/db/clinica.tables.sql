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
(6,'Cirugia'),
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
    username VARCHAR(10) NOT NULL,
    contra VARCHAR(500) NOT NULL,
    CONSTRAINT uk_usuario_username UNIQUE (username)
);

insert into usuario (username,contra) values ('superad','1');




-- Tabla Rol
CREATE TABLE rol (
    id_rol VARCHAR(5) PRIMARY KEY,
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
('DRN1','Director', 'ADMINISTRADOR', 1),
('DRN2','Sub Director', 'ADMINISTRADOR', 1),
('DRN3','Secretario', 'NORMAL', 1),
('DRN4','Asistente', 'NORMAL', 1);

insert into rol (id_rol, nombre, tipo, departamento) values
('RHS1','Jefe de Departamento', 'ADMINISTRADOR', 2),
('RHS2','Especialista en Nóminas', 'NORMAL', 2),
('RHS3','Atencion a Empleados', 'NORMAL', 2),
('RHS4','Reclutador', 'NORMAL', 2),
('RHS5','Asistente', 'NORMAL', 2);

insert into rol (id_rol, nombre, tipo, departamento) values
('IN1','Encargado(a) de Almacén', 'ADMINISTRADOR', 3),
('IN2','Coordinador(a) de Abastecimiento', 'NORMAL', 3),
('IN3','Técnico(a) de Logística', 'NORMAL', 3);

insert into rol (id_rol, nombre, tipo, departamento) values
('MG1','Jefe de Departamento', 'ADMINISTRADOR', 4),
('MG2','Médico(a) General', 'ADMINISTRADOR', 4),
('MG3','Recepcionista de Consultorio', 'NORMAL', 4),
('MG4','Asistente Médico', 'NORMAL', 4),
('MG5','Enfermero(a)', 'NORMAL', 4),
('MG6','Auxiliar de Enfermeria', 'NORMAL', 4),
('MG7','Encargado de Inventario', 'NORMAL', 4);

insert into rol (id_rol, nombre, tipo, departamento) values
('LB1','Jefe de Laboratorio', 'ADMINISTRADOR', 5),
('LB2','Técnico(a) de Laboratorio', 'NORMAL', 5),
('LB3','Asistente de Laboratorio', 'NORMAL', 5),
('LB4','Encargado de Inventario', 'NORMAL', 5);

insert into rol (id_rol, nombre, tipo, departamento) values
('CG1','Jefe de Departamento', 'ADMINISTRADOR', 6),
('CG2','Cirujano(a)', 'ADMINISTRADOR', 6),
('CG3','Anestesiologo', 'NORMAL', 6),
('CG4','Técnico de Cirugía', 'NORMAL', 6),
('CG5','Recepcionista de Cirugía', 'NORMAL', 6),
('CG6','Enfermero(a)', 'NORMAL', 6),
('CG7','Auxiliar de Enfermeria', 'NORMAL', 6),
('CG8','Encargado de Inventario', 'NORMAL', 6);

insert into rol (id_rol, nombre, tipo, departamento) values
('EN1','Director(a) de Enfermería', 'ADMINISTRADOR', 7),
('EN2','Subdirector(a) de Enfermería', 'ADMINISTRADOR', 7),
('EN3','Asistente Administrativo de Enfermería', 'NORMAL', 7),
('EN4','Recepcionista de Enfermeria', 'NORMAL', 7);

insert into rol (id_rol, nombre, tipo, departamento) values
('CD1','Jefe de Departamento', 'ADMINISTRADOR', 8),
('CD2','Cardiologo(a)', 'ADMINISTRADOR', 8),
('CD3','Técnico de Cardiología', 'NORMAL', 8),
('CD4','Recepcionista de Cardiología', 'NORMAL', 8),
('CD5','Enfermero(a)', 'NORMAL', 8),
('CD6','Auxiliar de Enfermeria', 'NORMAL', 8),
('CD7','Encargado de Inventario', 'NORMAL', 8);

insert into rol (id_rol, nombre, tipo, departamento) values
('NR1','Jefe de Departamento', 'ADMINISTRADOR', 9),
('NR2','Neurologo(a)', 'ADMINISTRADOR', 9),
('NR3','Técnico de Neurología', 'NORMAL', 9),
('NR4','Recepcionista de Neurología', 'NORMAL', 9),
('NR5','Enfermero(a)', 'NORMAL', 9),
('NR6','Auxiliar de Enfermeria', 'NORMAL', 9),
('NR7','Encargado de Inventario', 'NORMAL', 9);

insert into rol (id_rol, nombre, tipo, departamento) values
('GN1','Jefe de Departamento', 'ADMINISTRADOR', 10),
('GN2','Ginecologo(a)', 'ADMINISTRADOR', 10),
('GN3','Técnico de Ginecología', 'NORMAL', 10),
('GN4','Recepcionista de Ginecología', 'NORMAL', 10),
('GN5','Enfermero(a)', 'NORMAL', 10),
('GN6','Auxiliar de Enfermeria', 'NORMAL', 10),
('GN7','Encargado de Inventario', 'NORMAL', 10);

insert into rol (id_rol, nombre, tipo, departamento) values
('PD1','Jefe de Departamento', 'ADMINISTRADOR', 11),
('PD2','Pediatra', 'ADMINISTRADOR', 11),
('PD3','Técnico de Pediatría', 'NORMAL', 11),
('PD4','Recepcionista de Pediatría', 'NORMAL', 11),
('PD5','Enfermero(a)', 'NORMAL', 11),
('PD6','Auxiliar de Enfermeria', 'NORMAL', 11),
('PD7','Encargado de Inventario', 'NORMAL', 11);

insert into rol (id_rol, nombre, tipo, departamento) values
('OF1','Jefe de Departamento', 'ADMINISTRADOR', 12),
('OF2','Oftalmologo(a)', 'ADMINISTRADOR', 12),
('OF3','Técnico de Oftalmología', 'NORMAL', 12),
('OF4','Recepcionista de Oftalmología', 'NORMAL', 12),
('OF5','Enfermero(a)', 'NORMAL', 12),
('OF6','Auxiliar de Enfermeria', 'NORMAL', 12),
('OF7','Encargado de Inventario', 'NORMAL', 12);

insert into rol (id_rol, nombre, tipo, departamento) values
('OR1','Jefe de Departamento', 'ADMINISTRADOR', 13),
('OR2','Ortopedista', 'ADMINISTRADOR', 13),
('OR3','Técnico de Ortopedia', 'NORMAL', 13),
('OR4','Recepcionista de Ortopedia', 'NORMAL', 13),
('OR5','Enfermero(a)', 'NORMAL', 13),
('OR6','Auxiliar de Enfermeria', 'NORMAL', 13),
('OR7','Encargado de Inventario', 'NORMAL', 13);

insert into rol (id_rol, nombre, tipo, departamento) values
('UR1','Jefe de Departamento', 'ADMINISTRADOR', 14),
('UR2','Urologo(a)', 'ADMINISTRADOR', 14),
('UR3','Técnico de Urología', 'NORMAL', 14),
('UR4','Recepcionista de Urología', 'NORMAL', 14),
('UR5','Enfermero(a)', 'NORMAL', 14),
('UR6','Auxiliar de Enfermeria', 'NORMAL', 14),
('UR7','Encargado de Inventario', 'NORMAL', 14);

insert into rol (id_rol, nombre, tipo, departamento) values
('TR1','Jefe de Departamento', 'ADMINISTRADOR', 15),
('TR2','Traumatologo(a)', 'ADMINISTRADOR', 15),
('TR3','Técnico de Traumatología', 'NORMAL', 15),
('TR4','Recepcionista de Traumatología', 'NORMAL', 15),
('TR5','Enfermero(a)', 'NORMAL', 15),
('TR6','Auxiliar de Enfermeria', 'NORMAL', 15),
('TR7','Encargado de Inventario', 'NORMAL', 15);

insert into rol (id_rol, nombre, tipo, departamento) values
('RH1','Jefe de Departamento', 'ADMINISTRADOR', 16),
('RH2','Fisioterapeuta', 'ADMINISTRADOR', 16),
('RH3','Terapeuta Ocupacional', 'NORMAL', 16),
('RH4','Recepcionista de Rehabilitación', 'NORMAL', 16),
('RH5','Enfermero(a)', 'NORMAL', 16),
('RH6','Auxiliar de Enfermeria', 'NORMAL', 16),
('RH7','Encargado de Inventario', 'NORMAL', 16);

insert into rol (id_rol, nombre, tipo, departamento) values
('NT1','Jefe de Departamento', 'ADMINISTRADOR', 17),
('NT2','Nutriologo(a)', 'ADMINISTRADOR', 17),
('NT3','Técnico de Nutrición', 'NORMAL', 17),
('NT4','Recepcionista de Nutrición', 'NORMAL', 17),
('NT5','Enfermero(a)', 'NORMAL', 17),
('NT6','Auxiliar de Enfermeria', 'NORMAL', 17),
('NT7','Encargado de Inventario', 'NORMAL', 17);

insert into rol (id_rol, nombre, tipo, departamento) values
('PS1','Jefe de Departamento', 'ADMINISTRADOR', 18),
('PS2','Psiquiatra', 'ADMINISTRADOR', 18),
('PS3','Técnico de Psiquiatría', 'NORMAL', 18),
('PS4','Recepcionista de Psiquiatría', 'NORMAL', 18),
('PS5','Enfermero(a)', 'NORMAL', 18),
('PS6','Auxiliar de Enfermeria', 'NORMAL', 18),
('PS7','Encargado de Inventario', 'NORMAL', 18);

insert into rol (id_rol, nombre, tipo, departamento) values
('DR1','Jefe de Departamento', 'ADMINISTRADOR', 19),
('DR2','Dermatologo(a)', 'ADMINISTRADOR', 19),
('DR3','Técnico de Dermatología', 'NORMAL', 19),
('DR4','Recepcionista de Dermatología', 'NORMAL', 19),
('DR5','Enfermero(a)', 'NORMAL', 19),
('DR6','Auxiliar de Enfermeria', 'NORMAL', 19),
('DR7','Encargado de Inventario', 'NORMAL', 19);

insert into rol (id_rol, nombre, tipo, departamento) values
('OD1','Jefe de Departamento', 'ADMINISTRADOR', 20),
('OD2','Odontologo(a)', 'ADMINISTRADOR', 20),
('OD3','Técnico de Odontología', 'NORMAL', 20),
('OD4','Recepcionista de Odontología', 'NORMAL', 20),
('OD5','Enfermero(a)', 'NORMAL', 20),
('OD6','Auxiliar de Enfermeria', 'NORMAL', 20),
('OD7','Encargado de Inventario', 'NORMAL', 20);

insert into rol (id_rol, nombre, tipo, departamento) values
('EM1','Jefe de Departamento', 'ADMINISTRADOR', 21),
('EM2','Médico de Emergencias', 'ADMINISTRADOR', 21),
('EM3','Técnico de Emergencias', 'NORMAL', 21),
('EM4','Recepcionista de Emergencias', 'NORMAL', 21),
('EM5','Enfermero(a)', 'NORMAL', 21),
('EM6','Auxiliar de Enfermeria', 'NORMAL', 21),
('EM7','Encargado de Inventario', 'NORMAL', 21);


-- Tabla Permisos
CREATE TABLE permisos (
    id_permiso VARCHAR(5) NOT NULL PRIMARY KEY,
    descripcion VARCHAR(100) NOT NULL,
    departamento INT,
    CONSTRAINT fk_permisos_departamento FOREIGN KEY (departamento) REFERENCES departamento(id_departamento) ON DELETE RESTRICT ON UPDATE CASCADE
);

insert into permisos (id_permiso, descripcion, departamento) values ('PHR1', 'reistrar Empleados', 2);
insert into permisos (id_permiso, descripcion, departamento) values ('PHR2', 'ver empleados', 2);
insert into permisos (id_permiso, descripcion, departamento) values ('PHR3', 'editar salario', 2);
insert into permisos (id_permiso, descripcion, departamento) values ('PHR4', 'editar turno', 2);
insert into permisos (id_permiso, descripcion, departamento) values ('PHR5', 'enviar correos a empleados', 2);


-- Tabla Rol_Permisos
CREATE TABLE rol_permisos (
    rol VARCHAR(5) NOT NULL,
    permiso VARCHAR(5) NOT NULL,
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

-- el rol RHS1, DRN1 y DRN2 son los que tienen permisos para registrar empleados
insert into rol_permisos (rol, permiso) values
('RHS1', 'PHR1'),
('DRN1', 'PHR1'),
('DRN2', 'PHR1'),
('RHS4', 'PHR1');

-- los que pueden ver la lista de empleados es decir el permiso PHR2 son todos kis que tienen acceso al modulo de recursos humanos
insert into rol_permisos (rol, permiso) values
('RHS1', 'PHR2'),
('RHS2', 'PHR2'),
('RHS3', 'PHR2'),
('RHS4', 'PHR2'),
('RHS5', 'PHR2'),
('DRN1', 'PHR2'),
('DRN2', 'PHR2'),
('DRN3', 'PHR2'),
('DRN4', 'PHR2'),
('MG1', 'PHR2'),
('MG2', 'PHR2'),
('LB1', 'PHR2'),
('CG1','PHR2'),
('CG2','PHR2'),
('EN1','PHR2'),
('EN2','PHR2'),
('CD1','PHR2'),
('CD2','PHR2'),
('NR1','PHR2'),
('NR2','PHR2'),
('GN1','PHR2'),
('GN2','PHR2'),
('PD1','PHR2'),
('PD2','PHR2'),
('OF1','PHR2'),
('OF2','PHR2'),
('OR1','PHR2'),
('OR2','PHR2'),
('UR1','PHR2'),
('UR2','PHR2'),
('TR1','PHR2'),
('TR2','PHR2'),
('RH1','PHR2'),
('RH2','PHR2'),
('NT1','PHR2'),
('NT2','PHR2'),
('PS1','PHR2'),
('PS2','PHR2'),
('DR1','PHR2'),
('DR2','PHR2'),
('OD1','PHR2'),
('OD2','PHR2'),
('EM1','PHR2'),
('EM2','PHR2');

-- el permiso PHR3 que es editar salario solo lo tienen los jefes de departamento, el director y subdirector de direccion y el especialista en nomina
insert into rol_permisos (rol, permiso) values
('DRN1', 'PHR3'),
('DRN2', 'PHR3'),
('RHS1', 'PHR3'),
('RHS2', 'PHR3'),
('RHS3', 'PHR3'),
('RHS4', 'PHR3'),
('MG1', 'PHR3'),
('LB1', 'PHR3'),
('CG1','PHR3'),
('EN1','PHR3'),
('CD1','PHR3'),
('NR1','PHR3'),
('GN1','PHR3'),
('PD1','PHR3'),
('OF1','PHR3'),
('OR1','PHR3'),
('UR1','PHR3'),
('TR1','PHR3'),
('RH1','PHR3'),
('NT1','PHR3'),
('PS1','PHR3'),
('DR1','PHR3'),
('OD1','PHR3'),
('EM1','PHR3');

insert into rol_permisos (rol, permiso) values
('DRN1', 'PHR4'),
('DRN2', 'PHR4'),
('RHS1', 'PHR4'),
('RHS2', 'PHR4'),
('RHS3', 'PHR4'),
('RHS4', 'PHR4'),
('RHS5', 'PHR4'),
('MG1', 'PHR4'),
('LB1', 'PHR4'),
('CG1','PHR4'),
('EN1','PHR4'),
('CD1','PHR4'),
('NR1','PHR4'),
('GN1','PHR4'),
('PD1','PHR4'),
('OF1','PHR4'),
('OR1','PHR4'),
('UR1','PHR4'),
('TR1','PHR4'),
('RH1','PHR4'),
('NT1','PHR4'),
('PS1','PHR4'),
('DR1','PHR4'),
('OD1','PHR4'),
('EM1','PHR4');

insert into rol_permisos (rol, permiso) values
('DRN1', 'PHR5'),
('DRN2', 'PHR5'),
('RHS1', 'PHR5'),
('RHS2', 'PHR5'),
('RHS3', 'PHR5'),
('RHS4', 'PHR5'),
('RHS5', 'PHR5'),
('MG1', 'PHR5'),
('LB1', 'PHR5'),
('CG1','PHR5'),
('EN1','PHR5'),
('CD1','PHR5'),
('NR1','PHR5'),
('GN1','PHR5'),
('PD1','PHR5'),
('OF1','PHR5'),
('OR1','PHR5'),
('UR1','PHR5'),
('TR1','PHR5'),
('RH1','PHR5'),
('NT1','PHR5'),
('PS1','PHR5'),
('DR1','PHR5'),
('OD1','PHR5'),
('EM1','PHR5');


insert into permisos (id_permiso, descripcion, departamento) 
values ('PGP1', 'Registrar Paciente', 4),
('PGP2', 'Ver Pacientes  registrados', 4),
('PGP3', 'ingrasar Paciente', 4),
('PGP4', 'atender paciente', 4),
('PGP5', 'dar alta paciente', 4),
('PGP6', 'recetar medicamento', 4),
('PGP7', 'recetar tratamiento', 4),
('PGP8', 'ver pacientes', 4),
('PGP9', 'hacer traspaso de paciente', 4),
('PGP10', 'asignar examen', 4);


insert into rol_permisos (rol, permiso) values
('DRN2', 'PGP1'),
('MG1', 'PGP1'),
('CG1', 'PGP1'),
('EN1', 'PGP1'),
('CD1', 'PGP1'),
('NR1', 'PGP1'),
('GN1', 'PGP1'),
('PD1', 'PGP1'),
('OF1', 'PGP1'),
('OR1', 'PGP1'),
('UR1', 'PGP1'),
('TR1', 'PGP1'),
('RH1', 'PGP1'),
('NT1', 'PGP1'),
('PS1', 'PGP1'),
('DR1', 'PGP1'),
('OD1', 'PGP1'),
('EM1', 'PGP1'),
('MG2', 'PGP1'),
('CG2', 'PGP1'),
('EN2', 'PGP1'),
('CD2', 'PGP1'),
('NR2', 'PGP1'),
('GN2', 'PGP1'),
('PD2', 'PGP1'),
('OF2', 'PGP1'),
('OR2', 'PGP1'),
('UR2', 'PGP1'),
('TR2', 'PGP1'),
('RH2', 'PGP1'),
('NT2', 'PGP1'),
('PS2', 'PGP1'),
('DR2', 'PGP1'),
('OD2', 'PGP1'),
('EM2', 'PGP1'),
('MG4', 'PGP1'),
('CG4', 'PGP1'),
('EN4', 'PGP1'),
('CD4', 'PGP1'),
('NR4', 'PGP1'),
('GN4', 'PGP1'),
('PD4', 'PGP1'),
('OF4', 'PGP1'),
('OR4', 'PGP1'),
('UR4', 'PGP1'),
('TR4', 'PGP1'),
('RH4', 'PGP1'),
('NT4', 'PGP1'),
('PS4', 'PGP1'),
('DR4', 'PGP1'),
('OD4', 'PGP1'),
('EM4', 'PGP1'),
('MG5', 'PGP1'),
('CG5', 'PGP1'),
('EN5', 'PGP1'),
('CD5', 'PGP1'),
('NR5', 'PGP1'),
('GN5', 'PGP1'),
('PD5', 'PGP1'),
('OF5', 'PGP1'),
('OR5', 'PGP1'),
('UR5', 'PGP1'),
('TR5', 'PGP1'),
('RH5', 'PGP1'),
('NT5', 'PGP1'),
('PS5', 'PGP1'),
('DR5', 'PGP1'),
('OD5', 'PGP1'),
('EM5', 'PGP1');


insert into rol_permisos (rol, permiso) values
('DRN1', 'PGP2'),
('DRN2', 'PGP2'),
('MG1', 'PGP2'),
('CG1', 'PGP2'),
('EN1', 'PGP2'),
('CD1', 'PGP2'),
('NR1', 'PGP2'),
('GN1', 'PGP2'),
('PD1', 'PGP2'),
('OF1', 'PGP2'),
('OR1', 'PGP2'),
('UR1', 'PGP2'),
('TR1', 'PGP2'),
('RH1', 'PGP2'),
('NT1', 'PGP2'),
('PS1', 'PGP2'),
('DR1', 'PGP2'),
('OD1', 'PGP2'),
('EM1', 'PGP2'),
('MG2', 'PGP2'),
('CG2', 'PGP2'),
('EN2', 'PGP2'),
('CD2', 'PGP2'),
('NR2', 'PGP2'),
('GN2', 'PGP2'),
('PD2', 'PGP2'),
('OF2', 'PGP2'),
('OR2', 'PGP2'),
('UR2', 'PGP2'),
('TR2', 'PGP2'),
('RH2', 'PGP2'),
('NT2', 'PGP2'),
('PS2', 'PGP2'),
('DR2', 'PGP2'),
('OD2', 'PGP2'),
('EM2', 'PGP2'),
('MG4', 'PGP2'),
('CG4', 'PGP2'),
('EN4', 'PGP2'),
('CD4', 'PGP2'),
('NR4', 'PGP2'),
('GN4', 'PGP2'),
('PD4', 'PGP2'),
('OF4', 'PGP2'),
('OR4', 'PGP2'),
('UR4', 'PGP2'),
('TR4', 'PGP2'),
('RH4', 'PGP2'),
('NT4', 'PGP2'),
('PS4', 'PGP2'),
('DR4', 'PGP2'),
('OD4', 'PGP2'),
('EM4', 'PGP2'),
('MG5', 'PGP2'),
('CG5', 'PGP2'),
('EN3', 'PGP2'),
('CD5', 'PGP2'),
('NR5', 'PGP2'),
('GN5', 'PGP2'),
('PD5', 'PGP2'),
('OF5', 'PGP2'),
('OR5', 'PGP2'),
('UR5', 'PGP2'),
('TR5', 'PGP2'),
('RH5', 'PGP2'),
('NT5', 'PGP2'),
('PS5', 'PGP2'),
('DR5', 'PGP2'),
('OD5', 'PGP2'),
('EM5', 'PGP2'),
('LB1','PGP2'),
('MG6', 'PGP2'),
('CG6', 'PGP2'),
('CD6', 'PGP2'),
('NR6', 'PGP2'),
('GN6', 'PGP2'),
('PD6', 'PGP2'),
('OF6', 'PGP2'),
('OR6', 'PGP2'),
('UR6', 'PGP2'),
('TR6', 'PGP2'),
('RH6', 'PGP2'),
('NT6', 'PGP2'),
('PS6', 'PGP2'),
('DR6', 'PGP2'),
('OD6', 'PGP2'),
('EM6', 'PGP2');


insert into rol_permisos (rol, permiso) values
('DRN1', 'PGP3'),
('DRN2', 'PGP3'),
('MG1', 'PGP3'),
('CG1', 'PGP3'),
('EN1', 'PGP3'),
('CD1', 'PGP3'),
('NR1', 'PGP3'),
('GN1', 'PGP3'),
('PD1', 'PGP3'),
('OF1', 'PGP3'),
('OR1', 'PGP3'),
('UR1', 'PGP3'),
('TR1', 'PGP3'),
('RH1', 'PGP3'),
('NT1', 'PGP3'),
('PS1', 'PGP3'),
('DR1', 'PGP3'),
('OD1', 'PGP3'),
('EM1', 'PGP3'),
('MG2', 'PGP3'),
('CG2', 'PGP3'),
('EN2', 'PGP3'),
('CD2', 'PGP3'),
('NR2', 'PGP3'),
('GN2', 'PGP3'),
('PD2', 'PGP3'),
('OF2', 'PGP3'),
('OR2', 'PGP3'),
('UR2', 'PGP3'),
('TR2', 'PGP3'),
('RH2', 'PGP3'),
('NT2', 'PGP3'),
('PS2', 'PGP3'),
('DR2', 'PGP3'),
('OD2', 'PGP3'),
('EM2', 'PGP3'),
('MG4', 'PGP3'),
('CG4', 'PGP3'),
('CD4', 'PGP3'),
('NR4', 'PGP3'),
('GN4', 'PGP3'),
('PD4', 'PGP3'),
('OF4', 'PGP3'),
('OR4', 'PGP3'),
('UR4', 'PGP3'),
('TR4', 'PGP3'),
('RH4', 'PGP3'),
('NT4', 'PGP3'),
('PS4', 'PGP3'),
('DR4', 'PGP3'),
('OD4', 'PGP3'),
('EM4', 'PGP3');


-- para atender paciente solo pueden los medico
insert into rol_permisos (rol, permiso) values
('MG2', 'PGP4'),
('CG2', 'PGP4'),
('CD2', 'PGP4'),
('NR2', 'PGP4'),
('GN2', 'PGP4'),
('PD2', 'PGP4'),
('OF2', 'PGP4'),
('OR2', 'PGP4'),
('UR2', 'PGP4'),
('TR2', 'PGP4'),
('RH2', 'PGP4'),
('NT2', 'PGP4'),
('PS2', 'PGP4'),
('DR2', 'PGP4'),
('OD2', 'PGP4'),
('EM2', 'PGP4');


-- para atender paciente solo pueden los medico
insert into rol_permisos (rol, permiso) values
('MG2', 'PGP5'),
('CG2', 'PGP5'),
('CD2', 'PGP5'),
('NR2', 'PGP5'),
('GN2', 'PGP5'),
('PD2', 'PGP5'),
('OF2', 'PGP5'),
('OR2', 'PGP5'),
('UR2', 'PGP5'),
('TR2', 'PGP5'),
('RH2', 'PGP5'),
('NT2', 'PGP5'),
('PS2', 'PGP5'),
('DR2', 'PGP5'),
('OD2', 'PGP5'),
('EM2', 'PGP5');

-- para recetar medicamento solo pueden los medico
insert into rol_permisos (rol, permiso) values
('MG2', 'PGP6'),
('CG2', 'PGP6'),
('CD2', 'PGP6'),
('NR2', 'PGP6'),
('GN2', 'PGP6'),
('PD2', 'PGP6'),
('OF2', 'PGP6'),
('OR2', 'PGP6'),
('UR2', 'PGP6'),
('TR2', 'PGP6'),
('RH2', 'PGP6'),
('NT2', 'PGP6'),
('PS2', 'PGP6'),
('DR2', 'PGP6'),
('OD2', 'PGP6'),
('EM2', 'PGP6');

-- para recetar tratamiento solo pueden los medico
insert into rol_permisos (rol, permiso) values
('MG2', 'PGP7'),
('CG2', 'PGP7'),
('CD2', 'PGP7'),
('NR2', 'PGP7'),
('GN2', 'PGP7'),
('PD2', 'PGP7'),
('OF2', 'PGP7'),
('OR2', 'PGP7'),
('UR2', 'PGP7'),
('TR2', 'PGP7'),
('RH2', 'PGP7'),
('NT2', 'PGP7'),
('PS2', 'PGP7'),
('DR2', 'PGP7'),
('OD2', 'PGP7'),
('EM2', 'PGP7');

-- para ver pacientes solo pueden los medico
insert into rol_permisos (rol, permiso) values
('MG2', 'PGP8'),
('CG2', 'PGP8'),
('CD2', 'PGP8'),
('NR2', 'PGP8'),
('GN2', 'PGP8'),
('PD2', 'PGP8'),
('OF2', 'PGP8'),
('OR2', 'PGP8'),
('UR2', 'PGP8'),
('TR2', 'PGP8'),
('RH2', 'PGP8'),
('NT2', 'PGP8'),
('PS2', 'PGP8'),
('DR2', 'PGP8'),
('OD2', 'PGP8'),
('EM2', 'PGP8');

-- para hacer traspaso de paciente solo pueden los medico
insert into rol_permisos (rol, permiso) values
('MG2', 'PGP9'),
('CG2', 'PGP9'),
('CD2', 'PGP9'),
('NR2', 'PGP9'),
('GN2', 'PGP9'),
('PD2', 'PGP9'),
('OF2', 'PGP9'),
('OR2', 'PGP9'),
('UR2', 'PGP9'),
('TR2', 'PGP9'),
('RH2', 'PGP9'),
('NT2', 'PGP9'),
('PS2', 'PGP9'),
('DR2', 'PGP9'),
('OD2', 'PGP9'),
('EM2', 'PGP9');

-- para asignar examen solo pueden los medico
insert into rol_permisos (rol, permiso) values
('MG2', 'PGP10'),
('CG2', 'PGP10'),
('CD2', 'PGP10'),
('NR2', 'PGP10'),
('GN2', 'PGP10'),
('PD2', 'PGP10'),
('OF2', 'PGP10'),
('OR2', 'PGP10'),
('UR2', 'PGP10'),
('TR2', 'PGP10'),
('RH2', 'PGP10'),
('NT2', 'PGP10'),
('PS2', 'PGP10'),
('DR2', 'PGP10'),
('OD2', 'PGP10'),
('EM2', 'PGP10');




insert into permisos (id_permiso, descripcion, departamento) values
('PLB1', 'Ver examenes por atenderse', 5),
('PLB2', 'indicar que el examen se realizo', 5),
('PLB3', 'indicar que los resultados estan listos', 5);

insert into permisos (id_permiso, descripcion, departamento) values
('PIV1', 'ver la lista de insumos', 3),
('PIV2', 'ver pedidos de insumos', 3),
('PIV3', 'hacer peticion', 3),
('PIV4', 'procesar informacion', 3);

insert into rol_permisos (rol, permiso) values
('CG3', 'PLB1'),
('CD3', 'PLB1'),
('NR3', 'PLB1'),
('GN3', 'PLB1'),
('PD3', 'PLB1'),
('OF3', 'PLB1'),
('OR3', 'PLB1'),
('UR3', 'PLB1'),
('TR3', 'PLB1'),
('RH3', 'PLB1'),
('NT3', 'PLB1');


insert into rol_permisos (rol, permiso) values
('PS3', 'PLB1'),
('DR3', 'PLB1'),
('OD3', 'PLB1'),
('EM3', 'PLB1'),
('MG1', 'PLB1'),
('CG1', 'PLB1'),
('CD1', 'PLB1'),
('NR1', 'PLB1'),
('GN1', 'PLB1'),
('PD1', 'PLB1'),
('OF1', 'PLB1'),
('OR1', 'PLB1'),
('UR1', 'PLB1'),
('TR1', 'PLB1'),
('RH1', 'PLB1'),
('NT1', 'PLB1'),
('PS1', 'PLB1'),
('DR1', 'PLB1'),
('OD1', 'PLB1'),
('EM1', 'PLB1'),
('MG2', 'PLB1'),
('CG2', 'PLB1'),
('CD2', 'PLB1'),
('NR2', 'PLB1'),
('GN2', 'PLB1'),
('PD2', 'PLB1'),
('OF2', 'PLB1'),
('OR2', 'PLB1');



insert into rol_permisos (rol, permiso) values
('PS3', 'PLB1'),
('DR3', 'PLB1'),
('OD3', 'PLB1'),
('EM3', 'PLB1'),
('MG1', 'PLB1'),
('CG1', 'PLB1'),
('CD1', 'PLB1'),
('NR1', 'PLB1'),
('GN1', 'PLB1'),
('PD1', 'PLB1'),
('OF1', 'PLB1'),
('OR1', 'PLB1'),
('UR1', 'PLB1'),
('TR1', 'PLB1'),
('RH1', 'PLB1'),
('NT1', 'PLB1'),
('PS1', 'PLB1'),
('DR1', 'PLB1'),
('OD1', 'PLB1'),
('EM1', 'PLB1'),
('MG2', 'PLB1'),
('CG2', 'PLB1'),
('CD2', 'PLB1'),
('NR2', 'PLB1'),
('GN2', 'PLB1'),
('PD2', 'PLB1'),
('OF2', 'PLB1'),
('OR2', 'PLB1');

insert into rol_permisos (rol, permiso) values
('UR2', 'PLB1'),
('TR2', 'PLB1'),
('RH2', 'PLB1'),
('NT2', 'PLB1'),
('PS2', 'PLB1'),
('DR2', 'PLB1'),
('OD2', 'PLB1'),
('EM2', 'PLB1'),
('MG5', 'PLB1');



insert into rol_permisos (rol, permiso) values
('CD5', 'PLB1'),
('NR5', 'PLB1'),
('GN5', 'PLB1'),
('PD5', 'PLB1'),
('OF5', 'PLB1'),
('OR5', 'PLB1'),
('UR5', 'PLB1');


insert into rol_permisos (rol, permiso) values
('TR5', 'PLB1'),
('RH5', 'PLB1'),
('NT5', 'PLB1'),
('PS5', 'PLB1'),
('DR5', 'PLB1'),
('OD5', 'PLB1'),
('EM5', 'PLB1');

insert into rol_permisos (rol, permiso) values
('DRN1', 'PLB1'),
('DRN2', 'PLB1'),
('LB1', 'PLB1'),
('LB2', 'PLB1'),
('LB3', 'PLB1');


insert into rol_permisos (rol, permiso) values
('LB1', 'PLB3'),
('LB2', 'PLB3');

insert into rol_permisos (rol, permiso) values
('DRN1', 'PIV1'),
('DRN2', 'PIV1'),
('MG6', 'PIV1'),
('CG6', 'PIV1'),
('CD6', 'PIV1'),
('NR6', 'PIV1'),
('GN6', 'PIV1'),
('PD6', 'PIV1'),
('OF6', 'PIV1'),
('OR6', 'PIV1'),
('UR6', 'PIV1'),
('TR6', 'PIV1'),
('RH6', 'PIV1'),
('NT6', 'PIV1'),
('PS6', 'PIV1'),
('DR6', 'PIV1'),
('OD6', 'PIV1'),
('EM6', 'PIV1'),
('MG1', 'PIV1'),
('CG1', 'PIV1'),
('CD1', 'PIV1'),
('NR1', 'PIV1'),
('GN1', 'PIV1'),
('PD1', 'PIV1'),
('OF1', 'PIV1'),
('OR1', 'PIV1'),
('UR1', 'PIV1'),
('TR1', 'PIV1'),
('RH1', 'PIV1'),
('NT1', 'PIV1'),
('PS1', 'PIV1'),
('DR1', 'PIV1'),
('OD1', 'PIV1'),
('EM1', 'PIV1'),
('IN1', 'PIV1'),
('IN2', 'PIV1'),
('IN3', 'PIV1');




insert into rol_permisos (rol, permiso) values
('DRN1', 'PIV2'),
('DRN2', 'PIV2'),
('IN1', 'PIV2'),
('IN2', 'PIV2');

insert into rol_permisos (rol, permiso) values
('IN1', 'PIV3'),
('IN2', 'PIV3'),
('MG6', 'PIV3'),
('CG6', 'PIV3'),
('CD6', 'PIV3'),
('NR6', 'PIV3'),
('GN6', 'PIV3'),
('PD6', 'PIV3'),
('OF6', 'PIV3'),
('OR6', 'PIV3'),
('UR6', 'PIV3'),
('TR6', 'PIV3'),
('RH6', 'PIV3'),
('NT6', 'PIV3'),
('PS6', 'PIV3'),
('DR6', 'PIV3'),
('OD6', 'PIV3'),
('EM6', 'PIV3'),
('MG1', 'PIV3'),
('CG1', 'PIV3'),
('CD1', 'PIV3'),
('NR1', 'PIV3'),
('GN1', 'PIV3'),
('PD1', 'PIV3'),
('OF1', 'PIV3'),
('OR1', 'PIV3'),
('UR1', 'PIV3'),
('TR1', 'PIV3'),
('RH1', 'PIV3'),
('NT1', 'PIV3'),
('PS1', 'PIV3'),
('DR1', 'PIV3'),
('OD1', 'PIV3'),
('EM1', 'PIV3');



-- crear tabla para turnos, hay 3 turnos 7am-3pm, 3pm-11pm, 11pm-7am
CREATE TABLE turnos (
    id_turno INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL
);
INSERT INTO turnos (id_turno, nombre, hora_inicio, hora_fin) VALUES
(1, 'Administrativo', '08:00:00', '17:00:00'),
(2, 'Matutino', '07:00:00', '15:00:00'),
(3, 'Vespertino', '15:00:00', '23:00:00'),
(4, 'Nocturno', '23:00:00', '07:00:00');

-- Tabla Empleado
CREATE TABLE empleado (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(25) NOT NULL,
    departamento INT NOT NULL,
    usuario INT NOT NULL UNIQUE,
    rol VARCHAR(5) NOT NULL,
    fecha_contratacion DATE NOT NULL DEFAULT CURRENT_DATE,
    turno INT,
    email VARCHAR(100) UNIQUE NOT NULL,
    num_empleado VARCHAR(6) NOT NULL,
    salario DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_empleado_turno FOREIGN KEY (turno)
        REFERENCES turnos(id_turno)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_empleado_departamento FOREIGN KEY (departamento)
        REFERENCES departamento(id_departamento)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_empleado_usuario FOREIGN KEY (usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_empleado_rol FOREIGN KEY (rol)
        REFERENCES rol(id_rol)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);
insert into empleado (nombre,apellido,cedula, departamento, usuario,email, rol, turno) values ('Juan','Pruebas','8-888-8888', 1,  1,'juanpruebas001@gmail.com', 'DRN1', 1);


DELIMITER //
CREATE FUNCTION generarIdEmpleado() RETURNS VARCHAR(6)
BEGIN
    DECLARE nuevo_id VARCHAR(6);
    DECLARE existe INT;
    REPEAT
        SET nuevo_id = LPAD(CONV(FLOOR(RAND() * 1000000), 10, 36), 6, '0');
        SELECT COUNT(*) INTO existe FROM empleado WHERE num_empleado = nuevo_id;
    UNTIL existe = 0 END REPEAT;
    RETURN nuevo_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE registrarEmpleado (
    IN nombre VARCHAR(50),
    IN apellido VARCHAR(50),
    IN cedula VARCHAR(25),
    IN departamento INT,
    IN usuario VARCHAR(10),
    IN contra VARCHAR(500),
    IN rol VARCHAR(5),
    IN turno INT,
    IN email VARCHAR(100),
    IN salario DECIMAL(10,2)
)
BEGIN
    DECLARE id_usuario INT;
    DECLARE id_empleado INT;
    DECLARE num_empleado VARCHAR(6);
    SET num_empleado = generarIdEmpleado();
    INSERT INTO usuario (username, contra) VALUES (usuario, contra);
    INSERT INTO empleado (nombre,apellido,cedula, departamento, usuario, rol, turno, email, salario, num_empleado) VALUES 
    (nombre,apellido,cedula, departamento, LAST_INSERT_ID(), rol, turno,email,salario, num_empleado);
END //
DELIMITER ;


-- ahora tengo que crear una tabla llamada modulos que va a tener los modulos que se van a mostrar en el menu, que son: Gestion Pacientes, Finanzas, Inventario, Recursos Humanos, Laboratorios
CREATE TABLE modulos (
    id_modulo INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);  
INSERT INTO modulos (id_modulo, nombre, descripcion) VALUES
(1, 'Gestion Pacientes', 'Modulo para gestionar los pacientes'),
(4, 'Finanzas', 'Modulo para gestionar las finanzas'),
(3, 'Inventario', 'Modulo para gestionar el inventario'),
(2, 'Recursos Humanos', 'Modulo para gestionar los recursos humanos'),
(5, 'Laboratorios', 'Modulo para gestionar los laboratorios');

-- ahora tengo que relacionar los modulos con los roles para indicar que modulo puede ver cada rol
CREATE TABLE modulo_rol (
    id_modulo INT NOT NULL,
    id_rol VARCHAR(5) NOT NULL,
    PRIMARY KEY (id_modulo, id_rol),
    FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_rol) REFERENCES rol(id_rol) ON DELETE CASCADE ON UPDATE CASCADE
);

-- el director y subdirector del departamento de direccion pueden ver todos los modulos
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(1, 'DRN1'),
(2, 'DRN1'),
(3, 'DRN1'),
(4, 'DRN1'),
(5, 'DRN1'),
(1, 'DRN2'),
(2, 'DRN2'),
(3, 'DRN2'),
(4, 'DRN2'),
(5, 'DRN2');



-- el asistente y secretario solo pueden ver el modulo de finanzas, recursos humanos, inventario
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(2, 'DRN3'),
(3, 'DRN3'),
(4, 'DRN3'),
(2, 'DRN4'),
(3, 'DRN4'),
(4, 'DRN4');

-- el jefe de departamento de recursos humanos solo puede ver el modulo de recursos humanos y finanzas y el resto solo el de recursos humanos
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(2, 'RHS1'),
(4, 'RHS1'),
(2, 'RHS2'),
(2, 'RHS3'),
(2, 'RHS4'),
(2, 'RHS5');

-- el jefe de departamento de inventario solo puede ver el modulo de inventario y finanzas y el resto solo el de inventario
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(3, 'IN1'),
(4, 'IN1'),
(3, 'IN2'),
(3, 'IN3');

-- el jefe de departamento de medicina general puede ver todos excepto,  el medico puede ver el de gestio de pacientes, Laboratorios e Inventario, la de recepcionesta solo ve el de gestion de pacientes, el enfermero ve el de gestion de pacientes y laboratorios, el axuliar de enfermeria ve el de gestion de pacientes y el encargado de inventario ve el de inventario
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(1, 'MG1'),
(2, 'MG1'),
(3, 'MG1'),
(4, 'MG1'),
(5, 'MG1'),
(1, 'MG2'),
(2, 'MG2'),
(3, 'MG2'),
(5, 'MG2'),
(1, 'MG3'),
(1, 'MG4'),
(5, 'MG4'),
(1, 'MG5'),
(5, 'MG5'),
(3, 'MG5'),
(1, 'MG6'),
(5, 'MG6'),
(3, 'MG7');

-- el jefe de departamento de laboratorios puede ver todos, el tecnico de laboratorio puede ver el de Laboratorios e Inventario, la de asistente de laboratorio solo ve el de Laboratorio, el encargado de inventario ve el de inventario
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(1, 'LB1'),
(2, 'LB1'),
(3, 'LB1'),
(4, 'LB1'),
(5, 'LB1'),
(3, 'LB2'),
(5, 'LB2'),
(5, 'LB3'),
(3, 'LB4');


-- con cirugia pasa lo mismo que con medicina general
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(1, 'CG1'),
(2, 'CG1'),
(3, 'CG1'),
(4, 'CG1'),
(5, 'CG1'),
(1, 'CG2'),
(2, 'CG2'),
(3, 'CG2'),
(5, 'CG2'),
(1, 'CG3'),
(1, 'CG4'),
(5, 'CG4'),
(1, 'CG5'),
(5, 'CG5'),
(3, 'CG5'),
(1, 'CG6'),
(5, 'CG6'),
(3, 'CG7');

-- el director y subdrictor de enfermeria pueden ver todos, el asistente solo ve el de gestion de pacientes y el recepcionista solo ve el de gestion de pacientes
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(1, 'EN1'),
(2, 'EN1'),
(3, 'EN1'),
(4, 'EN1'),
(5, 'EN1'),
(1, 'EN2'),
(2, 'EN2'),
(3, 'EN2'),
(4, 'EN2'),
(5, 'EN2'),
(1, 'EN3'),
(1, 'EN4');

-- con el resto de departamentos pasa lo mismo que con medicina general y cirugia
INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(1, 'CD1'),
(2, 'CD1'),
(3, 'CD1'),
(4, 'CD1'),
(5, 'CD1'),
(1, 'CD2'),
(2, 'CD2'),
(3, 'CD2'),
(5, 'CD2'),
(1, 'CD3'),
(1, 'CD4'),
(5, 'CD4'),
(1, 'CD5'),
(5, 'CD5'),
(3, 'CD5'),
(1, 'CD6'),
(5, 'CD6'),
(3, 'CD7');

INSERT INTO modulo_rol (id_modulo, id_rol) VALUES
(1, 'NR1'),
(2, 'NR1'),
(3, 'NR1'),
(4, 'NR1'),
(5, 'NR1'),
(1, 'NR2'),
(2, 'NR2'),
(3, 'NR2'),
(5, 'NR2'),
(1, 'NR3'),
(1, 'NR4'),
(5, 'NR4'),
(1, 'NR5'),
(5, 'NR5'),
(3, 'NR5'),
(1, 'NR6'),
(5, 'NR6'),
(3, 'NR7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'GN1'),
(2, 'GN1'),
(3, 'GN1'),
(4, 'GN1'),
(5, 'GN1'),
(1, 'GN2'),
(2, 'GN2'),
(3, 'GN2'),
(5, 'GN2'),
(1, 'GN3'),
(1, 'GN4'),
(5, 'GN4'),
(1, 'GN5'),
(5, 'GN5'),
(3, 'GN5'),
(1, 'GN6'),
(5, 'GN6'),
(3, 'GN7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'PD1'),
(2, 'PD1'),
(3, 'PD1'),
(4, 'PD1'),
(5, 'PD1'),
(1, 'PD2'),
(2, 'PD2'),
(3, 'PD2'),
(5, 'PD2'),
(1, 'PD3'),
(1, 'PD4'),
(5, 'PD4'),
(1, 'PD5'),
(5, 'PD5'),
(3, 'PD5'),
(1, 'PD6'),
(5, 'PD6'),
(3, 'PD7');


insert into modulo_rol (id_modulo, id_rol) values
(1, 'OF1'),
(2, 'OF1'),
(3, 'OF1'),
(4, 'OF1'),
(5, 'OF1'),
(1, 'OF2'),
(2, 'OF2'),
(3, 'OF2'),
(5, 'OF2'),
(1, 'OF3'),
(1, 'OF4'),
(5, 'OF4'),
(1, 'OF5'),
(5, 'OF5'),
(3, 'OF5'),
(1, 'OF6'),
(5, 'OF6'),
(3, 'OF7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'OR1'),
(2, 'OR1'),
(3, 'OR1'),
(4, 'OR1'),
(5, 'OR1'),
(1, 'OR2'),
(2, 'OR2'),
(3, 'OR2'),
(5, 'OR2'),
(1, 'OR3'),
(1, 'OR4'),
(5, 'OR4'),
(1, 'OR5'),
(5, 'OR5'),
(3, 'OR5'),
(1, 'OR6'),
(5, 'OR6'),
(3, 'OR7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'UR1'),
(2, 'UR1'),
(3, 'UR1'),
(4, 'UR1'),
(5, 'UR1'),
(1, 'UR2'),
(2, 'UR2'),
(3, 'UR2'),
(5, 'UR2'),
(1, 'UR3'),
(1, 'UR4'),
(5, 'UR4'),
(1, 'UR5'),
(5, 'UR5'),
(3, 'UR5'),
(1, 'UR6'),
(5, 'UR6'),
(3, 'UR7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'TR1'),
(2, 'TR1'),
(3, 'TR1'),
(4, 'TR1'),
(5, 'TR1'),
(1, 'TR2'),
(2, 'TR2'),
(3, 'TR2'),
(5, 'TR2'),
(1, 'TR3'),
(1, 'TR4'),
(5, 'TR4'),
(1, 'TR5'),
(5, 'TR5'),
(3, 'TR5'),
(1, 'TR6'),
(5, 'TR6'),
(3, 'TR7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'RH1'),
(2, 'RH1'),
(3, 'RH1'),
(4, 'RH1'),
(5, 'RH1'),
(1, 'RH2'),
(2, 'RH2'),
(3, 'RH2'),
(5, 'RH2'),
(1, 'RH3'),
(1, 'RH4'),
(5, 'RH4'),
(1, 'RH5'),
(5, 'RH5'),
(3, 'RH5'),
(1, 'RH6'),
(5, 'RH6'),
(3, 'RH7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'NT1'),
(2, 'NT1'),
(3, 'NT1'),
(4, 'NT1'),
(5, 'NT1'),
(1, 'NT2'),
(2, 'NT2'),
(3, 'NT2'),
(5, 'NT2'),
(1, 'NT3'),
(1, 'NT4'),
(5, 'NT4'),
(1, 'NT5'),
(5, 'NT5'),
(3, 'NT5'),
(1, 'NT6'),
(5, 'NT6'),
(3, 'NT7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'PS1'),
(2, 'PS1'),
(3, 'PS1'),
(4, 'PS1'),
(5, 'PS1'),
(1, 'PS2'),
(2, 'PS2'),
(3, 'PS2'),
(5, 'PS2'),
(1, 'PS3'),
(1, 'PS4'),
(5, 'PS4'),
(1, 'PS5'),
(5, 'PS5'),
(3, 'PS5'),
(1, 'PS6'),
(5, 'PS6'),
(3, 'PS7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'DR1'),
(2, 'DR1'),
(3, 'DR1'),
(4, 'DR1'),
(5, 'DR1'),
(1, 'DR2'),
(2, 'DR2'),
(3, 'DR2'),
(5, 'DR2'),
(1, 'DR3'),
(1, 'DR4'),
(5, 'DR4'),
(1, 'DR5'),
(5, 'DR5'),
(3, 'DR5'),
(1, 'DR6'),
(5, 'DR6'),
(3, 'DR7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'OD1'),
(2, 'OD1'),
(3, 'OD1'),
(4, 'OD1'),
(5, 'OD1'),
(1, 'OD2'),
(2, 'OD2'),
(3, 'OD2'),
(5, 'OD2'),
(1, 'OD3'),
(1, 'OD4'),
(5, 'OD4'),
(1, 'OD5'),
(5, 'OD5'),
(3, 'OD5'),
(1, 'OD6'),
(5, 'OD6'),
(3, 'OD7');

insert into modulo_rol (id_modulo, id_rol) values
(1, 'EM1'),
(2, 'EM1'),
(3, 'EM1'),
(4, 'EM1'),
(5, 'EM1'),
(1, 'EM2'),
(2, 'EM2'),
(3, 'EM2'),
(5, 'EM2'),
(1, 'EM3'),
(1, 'EM4'),
(5, 'EM4'),
(1, 'EM5'),
(5, 'EM5'),
(3, 'EM5'),
(1, 'EM6'),
(5, 'EM6'),
(3, 'EM7');


-- ahora quiero una tabla examenes que va a tener los examenes que se pueden realizar y sus precios
create table examenes (
    id_examen INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

-- ahora quiero una llenar esta tabla con los examenes que se pueden realizar
insert into examenes (id_examen, nombre, descripcion, precio) values
(1, 'Hemograma Completo', 'Examen de sangre para evaluar la salud general y detectar una variedad de trastornos', 100.00),
(2, 'Prueba de Glucosa en Ayunas', 'Examen de sangre para medir los niveles de glucosa después de un período de ayuno', 75.00),
(3, 'Perfil Lipídico', 'Examen de sangre para medir los niveles de colesterol y triglicéridos', 125.00),
(4, 'Monitorización Ambulatoria de la Presión Arterial', 'Examen para medir la presión arterial durante 24 horas', 25.00),
(5, 'Examen de Agudeza Visual', 'Examen para evaluar la claridad de la visión', 150.00),
(6, 'Audiometría', 'Examen para evaluar la capacidad auditiva', 200.00),
(7, 'Electrocardiograma (ECG)', 'Examen para registrar la actividad eléctrica del corazón', 300.00),
(8, 'Espirometría', 'Examen para medir la función pulmonar', 250.00),
(9, 'Prueba de Función Hepática', 'Examen de sangre para evaluar la función del hígado', 275.00),
(10, 'Prueba de Función Renal', 'Examen de sangre para evaluar la función de los riñones', 225.00),
(11, 'Prueba de TSH (Hormona Estimulante de la Tiroides)', 'Examen de sangre para evaluar la función de la tiroides', 175.00),
(12, 'Hemograma Completo con Recuento Diferencial', 'Incluye el conteo y la proporción de diferentes tipos de glóbulos blancos', 120.00),
(13, 'Curva de Tolerancia a la Glucosa', 'Evalúa cómo el cuerpo maneja la glucosa con varias mediciones después de una carga de glucosa', 130.00),
(14, 'Lipoproteínas de Alta Densidad (HDL)', 'Colesterol "bueno" para evaluar el riesgo cardiovascular', 140.00),
(15, 'Lipoproteínas de Baja Densidad (LDL)', 'Colesterol "malo" relacionado con enfermedades cardíacas', 150.00),
(16, 'Triglicéridos', 'Niveles de grasa en la sangre como parte del perfil lipídico', 110.00),
(17, 'Proteína C Reactiva (PCR)', 'Detecta inflamación en el cuerpo, relacionada con enfermedades cardíacas o infecciones', 160.00),
(18, 'Troponina', 'Marcador específico de daño cardíaco, usado en el diagnóstico de infartos', 170.00),
(19, 'Prueba de Dímero-D', 'Evalúa la probabilidad de trombosis o embolia pulmonar', 180.00),
(20, 'Ecocardiograma Doppler', 'Ultrasonido del corazón para medir el flujo sanguíneo y las válvulas cardíacas', 350.00),
(21, 'Prueba de Esfuerzo Cardiovascular (Prueba de la Caminadora)', 'Evalúa la función cardíaca bajo estrés físico', 400.00),
(22, 'Gasometría Arterial', 'Mide los niveles de oxígeno, dióxido de carbono y pH en sangre arterial', 190.00),
(23, 'Test de Coombs Directo', 'Detecta anticuerpos adheridos a glóbulos rojos, común en anemia hemolítica', 200.00),
(24, 'Test de Coombs Indirecto', 'Detecta anticuerpos en el suero relacionados con incompatibilidades sanguíneas', 210.00),
(25, 'Prueba de Creatinina en Suero', 'Mide la función renal mediante los niveles de creatinina', 220.00),
(26, 'Prueba de Urea en Sangre', 'Evalúa la función renal y la eliminación de productos de desecho', 230.00),
(27, 'Microalbuminuria', 'Mide pequeñas cantidades de albúmina en orina, útil para detectar daño renal temprano', 240.00),
(28, 'Prueba de Bilirrubina (Directa e Indirecta)', 'Evalúa la función hepática y trastornos como la ictericia', 250.00),
(29, 'Fosfatasa Alcalina (ALP)', 'Mide la función hepática y ósea', 260.00),
(30, 'Alanina Aminotransferasa (ALT)', 'Enzima hepática para detectar daño en el hígado', 270.00),
(31, 'Aspartato Aminotransferasa (AST)', 'Otra enzima hepática relacionada con la función hepática', 280.00),
(32, 'Factor Reumatoide (FR)', 'Detecta trastornos autoinmunes como artritis reumatoide', 290.00),
(33, 'Prueba de ANA (Anticuerpos Antinucleares)', 'Indica trastornos autoinmunes como lupus', 300.00),
(34, 'Velocidad de Sedimentación Globular (VSG)', 'Evalúa inflamación en el cuerpo', 310.00),
(35, 'Espirometría Forzada', 'Mide la capacidad pulmonar y el flujo aéreo', 320.00),
(36, 'Electromiografía (EMG)', 'Evalúa la actividad eléctrica de los músculos', 330.00),
(37, 'Electroencefalograma (EEG)', 'Registra la actividad eléctrica del cerebro, útil para epilepsia', 340.00),
(38, 'Prueba de Antígeno Prostático Específico (PSA)', 'Detecta anomalías en la próstata', 350.00),
(39, 'Prueba de Vitamina D', 'Evalúa los niveles de vitamina D para detectar deficiencia', 360.00),
(40, 'Prueba de Ferritina', 'Mide las reservas de hierro en el cuerpo', 370.00),
(41, 'Prueba de Hemoglobina Glicosilada (HbA1c)', 'Evalúa el control de la diabetes a largo plazo', 380.00),
(42, 'Prueba de Hormona Antimülleriana (AMH)', 'Evalúa la reserva ovárica en mujeres', 390.00),
(43, 'Prueba de Fibrinógeno', 'Mide un componente clave de la coagulación de la sangre', 400.00),
(44, 'Test de Lactato en Sangre', 'Evalúa el metabolismo celular y el nivel de oxígeno en tejidos', 410.00),
(45, 'Cultivo de Sangre', 'Detecta infecciones bacterianas o fúngicas en la sangre', 420.00),
(46, 'Prueba de Calcio Ionizado', 'Mide la forma activa del calcio en la sangre', 430.00),
(47, 'Prueba de Electrolitos (Na, K, Cl)', 'Evalúa el equilibrio de minerales y líquidos', 440.00),
(48, 'Prueba de Hormona Paratiroidea (PTH)', 'Relacionada con trastornos del calcio y la tiroides', 450.00),
(49, 'Prueba de Cortisol en Suero', 'Evalúa la función de las glándulas suprarrenales', 460.00),
(50, 'Prueba de Aldosterona', 'Relacionada con el equilibrio de líquidos y la presión arterial', 470.00),
(51, 'Prueba de Insulina en Sangre', 'Mide los niveles de insulina en sangre', 480.00),
(52, 'Prueba de Progesterona', 'Hormona relacionada con la ovulación y el embarazo', 490.00),
(53, 'Prueba de Prolactina', 'Hormona relacionada con la lactancia y la fertilidad', 500.00),
(54, 'Prueba de Estradiol', 'Hormona relacionada con la fertilidad y el ciclo menstrual', 510.00),
(55, 'Rayos X de Tórax', 'Imágenes del tórax para evaluar los pulmones y el corazón', 200.00),
(56, 'Rayos X de Abdomen', 'Imágenes del abdomen para evaluar el hígado, riñones y otros órganos', 250.00),
(57, 'Rayos X de Columna', 'Imágenes de la columna vertebral para evaluar lesiones o deformidades', 300.00),
(58, 'Rayos X de Extremidades', 'Imágenes de brazos o piernas para evaluar lesiones o fracturas', 150.00),
(59, 'Mamografía', 'Rayos X de las mamas para detectar cáncer de mama', 350.00),
(60, 'Tomografía Computarizada (TAC)', 'Imágenes detalladas de órganos internos y tejidos', 400.00),
(61, 'Resonancia Magnética (RM)', 'Imágenes detall adas de tejidos blandos y órganos internos', 500.00),
(62, 'Rayos X de Cráneo', 'Imágenes del cráneo para evaluar lesiones o anomalías', 300.00),
(63, 'Rayos X de Senos Paranasales', 'Imágenes de los senos paranasales para detectar infecciones o anomalías', 250.00),
(64, 'Rayos X de Columna Cervical', 'Imágenes de la columna cervical para evaluar lesiones o deformidades', 350.00),
(65, 'Rayos X de Columna Torácica', 'Imágenes de la columna torácica para evaluar lesiones o deformidades', 350.00),
(66, 'Rayos X de Columna Lumbar', 'Imágenes de la columna lumbar para evaluar lesiones o deformidades', 350.00),
(67, 'Rayos X de Pelvis', 'Imágenes de la pelvis para evaluar lesiones o anomalías', 300.00),
(68, 'Rayos X de Cadera', 'Imágenes de la cadera para evaluar lesiones o anomalías', 300.00),
(69, 'Rayos X de Rodilla', 'Imágenes de la rodilla para evaluar lesiones o anomalías', 250.00),
(70, 'Rayos X de Tobillo', 'Imágenes del tobillo para evaluar lesiones o anomalías', 250.00),
(71, 'Rayos X de Pie', 'Imágenes del pie para evaluar lesiones o anomalías', 250.00),
(72, 'Rayos X de Mano', 'Imágenes de la mano para evaluar lesiones o anomalías', 250.00),
(73, 'Rayos X de Muñeca', 'Imágenes de la muñeca para evaluar lesiones o anomalías', 250.00),
(74, 'Rayos X de Codo', 'Imágenes del codo para evaluar lesiones o anomalías', 250.00),
(75, 'Rayos X de Hombro', 'Imágenes del hombro para evaluar lesiones o anomalías', 300.00),
(76, 'Rayos X de Abdomen Simple', 'Imágenes del abdomen para evaluar órganos y estructuras internas', 300.00);


-- ahora tengo que especificar que roles de medicos pueden solicitar cierto examen,(los examenes solo lo pueden solicitar los medicos)
CREATE TABLE medicos_examenes (
    id_medico VARCHAR(5) NOT NULL,
    id_examen INT NOT NULL,
    PRIMARY KEY (id_medico, id_examen),
    FOREIGN KEY (id_medico) REFERENCES rol(id_rol) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_examen) REFERENCES examenes(id_examen) ON DELETE CASCADE ON UPDATE CASCADE
);
-- insertar los medicos que pueden solicitar ciertos examenes 
-- empecemos con los medicos generales, que no pueden solicitar examenes tan especificos sino mas bien examenes comunes o generales
-- Insertar los exámenes más comunes que pueden ser solicitados por los médicos generales
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('MG2', 1),   -- Hemograma Completo
('MG2', 2),   -- Prueba de Glucosa en Ayunas
('MG2', 3),   -- Perfil Lipídico
('MG2', 7),   -- Electrocardiograma (ECG)
('MG2', 9),   -- Prueba de Función Hepática
('MG2', 10),  -- Prueba de Función Renal
('MG2', 12),  -- Hemograma Completo con Recuento Diferencial
('MG2', 13),  -- Curva de Tolerancia a la Glucosa
('MG2', 16),  -- Triglicéridos
('MG2', 17),  -- Proteína C Reactiva (PCR)
('MG2', 25),  -- Prueba de Creatinina en Suero
('MG2', 26),  -- Prueba de Urea en Sangre
('MG2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('MG2', 41),  -- Prueba de Hemoglobina Glicosilada (HbA1c)
('MG2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('MG2', 55),  -- Rayos X de Tórax
('MG2', 56),  -- Rayos X de Abdomen
('MG2', 57),  -- Rayos X de Columna
('MG2', 58),  -- Rayos X de Extremidades
('MG2', 76);  -- Rayos X de Abdomen Simple

-- ahora los examenes que puede realizar un cardiologo van a ser mas de los que puede solicitar un medico general
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('CD2', 1),   -- Hemograma Completo
('CD2', 2),   -- Prueba de Glucosa en Ayunas
('CD2', 3),   -- Perfil Lipídico
('CD2', 4),   -- Monitorización Ambulatoria de la Presión Arterial
('CD2', 7),   -- Electrocardiograma (ECG)
('CD2', 14),  -- Lipoproteínas de Alta Densidad (HDL)
('CD2', 15),  -- Lipoproteínas de Baja Densidad (LDL)
('CD2', 16),  -- Triglicéridos
('CD2', 17),  -- Proteína C Reactiva (PCR)
('CD2', 18),  -- Troponina
('CD2', 19),  -- Prueba de Dímero-D
('CD2', 20),  -- Ecocardiograma Doppler
('CD2', 21),  -- Prueba de Esfuerzo Cardiovascular
('CD2', 22),  -- Gasometría Arterial
('CD2', 27),  -- Microalbuminuria
('CD2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('CD2', 41),  -- Prueba de Hemoglobina Glicosilada (HbA1c)
('CD2', 43),  -- Prueba de Fibrinógeno
('CD2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('CD2', 48),  -- Prueba de Hormona Paratiroidea (PTH)
('CD2', 49),  -- Prueba de Cortisol en Suero
('CD2', 50),  -- Prueba de Aldosterona
('CD2', 55),  -- Rayos X de Tórax
('CD2', 60),  -- Tomografía Computarizada (TAC)
('CD2', 61);  -- Resonancia Magnética (RM)

-- ahora los que puede realizar un neurologo
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('NR2', 1),   -- Hemograma Completo
('NR2', 2),   -- Prueba de Glucosa en Ayunas
('NR2', 12),  -- Hemograma Completo con Recuento Diferencial
('NR2', 25),  -- Prueba de Creatinina en Suero
('NR2', 26),  -- Prueba de Urea en Sangre
('NR2', 33),  -- Prueba de ANA (Anticuerpos Antinucleares)
('NR2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('NR2', 36),  -- Electromiografía (EMG)
('NR2', 37),  -- Electroencefalograma (EEG)
('NR2', 40),  -- Prueba de Ferritina
('NR2', 44),  -- Test de Lactato en Sangre
('NR2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('NR2', 60),  -- Tomografía Computarizada (TAC)
('NR2', 61),  -- Resonancia Magnética (RM)
('NR2', 62),  -- Rayos X de Cráneo
('NR2', 64),  -- Rayos X de Columna Cervical
('NR2', 65),  -- Rayos X de Columna Torácica
('NR2', 66),  -- Rayos X de Columna Lumbar
('NR2', 3),   -- Perfil Lipídico
('NR2', 7),   -- Electrocardiograma (ECG)
('NR2', 9),   -- Prueba de Función Hepática
('NR2', 10),  -- Prueba de Función Renal
('NR2', 13),  -- Curva de Tolerancia a la Glucosa
('NR2', 16),  -- Triglicéridos
('NR2', 17),  -- Proteína C Reactiva (PCR)
('NR2', 41);  -- Prueba de Hemoglobina Glicosilada (HbA1c)


-- ahora los que puede realizar un ginicologo
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('GN2', 1),   -- Hemograma Completo
('GN2', 2),   -- Prueba de Glucosa en Ayunas
('GN2', 12),  -- Hemograma Completo con Recuento Diferencial
('GN2', 25),  -- Prueba de Creatinina en Suero
('GN2', 26),  -- Prueba de Urea en Sangre
('GN2', 33),  -- Prueba de ANA (Anticuerpos Antinucleares)
('GN2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('GN2', 36),  -- Electromiografía (EMG)
('GN2', 37),  -- Electroencefalograma (EEG)
('GN2', 40),  -- Prueba de Ferritina
('GN2', 44),  -- Test de Lactato en Sangre
('GN2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('GN2', 60),  -- Tomografía Computarizada (TAC)
('GN2', 61),  -- Resonancia Magnética (RM)
('GN2', 62),  -- Rayos X de Cráneo
('GN2', 64),  -- Rayos X de Columna Cervical
('GN2', 65),  -- Rayos X de Columna Torácica
('GN2', 66),  -- Rayos X de Columna Lumbar
('GN2', 3),   -- Perfil Lipídico
('GN2', 7),   -- Electrocardiograma (ECG)
('GN2', 9),   -- Prueba de Función Hepática
('GN2', 10),  -- Prueba de Función Renal
('GN2', 13),  -- Curva de Tolerancia a la Glucosa
('GN2', 16),  -- Triglicéridos
('GN2', 17),  -- Proteína C Reactiva (PCR)
('GN2', 41);  -- Prueba de Hemoglobina Glicosilada (HbA1c)

-- ahora los que puede realizar un pediatra
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('PD2', 1),   -- Hemograma Completo
('PD2', 2),   -- Prueba de Glucosa en Ayunas
('PD2', 12),  -- Hemograma Completo con Recuento Diferencial
('PD2', 25),  -- Prueba de Creatinina en Suero
('PD2', 26),  -- Prueba de Urea en Sangre
('PD2', 33),  -- Prueba de ANA (Anticuerpos Antinucleares)
('PD2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('PD2', 36),  -- Electromiografía (EMG)
('PD2', 37),  -- Electroencefalograma (EEG)
('PD2', 40),  -- Prueba de Ferritina
('PD2', 44),  -- Test de Lactato en Sangre
('PD2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('PD2', 60),  -- Tomografía Computarizada (TAC)
('PD2', 61),  -- Resonancia Magnética (RM)
('PD2', 62),  -- Rayos X de Cráneo
('PD2', 64),  -- Rayos X de Columna Cervical
('PD2', 65),  -- Rayos X de Columna Torácica
('PD2', 66),  -- Rayos X de Columna Lumbar
('PD2', 3),   -- Perfil Lipídico
('PD2', 7),   -- Electrocardiograma (ECG)
('PD2', 9),   -- Prueba de Función Hepática
('PD2', 10),  -- Prueba de Función Renal
('PD2', 13),  -- Curva de Tolerancia a la Glucosa
('PD2', 16),  -- Triglicéridos
('PD2', 17),  -- Proteína C Reactiva (PCR)
('PD2', 41);  -- Prueba de Hemoglobina Glicosilada (HbA1c)

-- ahora los que puede realizar un oftalmologo
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('OF2', 1),   -- Hemograma Completo
('OF2', 5),   -- Examen de Agudeza Visual
('OF2', 6),   -- Audiometría
('OF2', 12),  -- Hemograma Completo con Recuento Diferencial
('OF2', 25),  -- Prueba de Creatinina en Suero
('OF2', 26),  -- Prueba de Urea en Sangre
('OF2', 33),  -- Prueba de ANA (Anticuerpos Antinucleares)
('OF2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('OF2', 40),  -- Prueba de Ferritina
('OF2', 44),  -- Test de Lactato en Sangre
('OF2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('OF2', 60),  -- Tomografía Computarizada (TAC)
('OF2', 61),  -- Resonancia Magnética (RM)
('OF2', 62),  -- Rayos X de Cráneo
('OF2', 63),  -- Rayos X de Senos Paranasales
('OF2', 64),  -- Rayos X de Columna Cervical
('OF2', 65),  -- Rayos X de Columna Torácica
('OF2', 66),  -- Rayos X de Columna Lumbar
('OF2', 3),   -- Perfil Lipídico
('OF2', 7),   -- Electrocardiograma (ECG)
('OF2', 9),   -- Prueba de Función Hepática
('OF2', 10),  -- Prueba de Función Renal
('OF2', 13),  -- Curva de Tolerancia a la Glucosa
('OF2', 16),  -- Triglicéridos
('OF2', 17),  -- Proteína C Reactiva (PCR)
('OF2', 41);  -- Prueba de Hemoglobina Glicosilada (HbA1c)
-- ahora los que puede realizar un ortopedista
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('OR2', 1),   -- Hemograma Completo
('OR2', 12),  -- Hemograma Completo con Recuento Diferencial
('OR2', 25),  -- Prueba de Creatinina en Suero
('OR2', 26),  -- Prueba de Urea en Sangre
('OR2', 33),  -- Prueba de ANA (Anticuerpos Antinucleares)
('OR2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('OR2', 36),  -- Electromiografía (EMG)
('OR2', 44),  -- Test de Lactato en Sangre
('OR2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('OR2', 60),  -- Tomografía Computarizada (TAC)
('OR2', 61),  -- Resonancia Magnética (RM)
('OR2', 64),  -- Rayos X de Columna Cervical
('OR2', 65),  -- Rayos X de Columna Torácica
('OR2', 66),  -- Rayos X de Columna Lumbar
('OR2', 67),  -- Rayos X de Pelvis
('OR2', 68),  -- Rayos X de Cadera
('OR2', 69),  -- Rayos X de Rodilla
('OR2', 70),  -- Rayos X de Tobillo
('OR2', 71),  -- Rayos X de Pie
('OR2', 72),  -- Rayos X de Mano
('OR2', 73),  -- Rayos X de Muñeca
('OR2', 74),  -- Rayos X de Codo
('OR2', 75);  -- Rayos X de Hombro

-- ahora los que puede realizar un urólogo
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('UR2', 1),    -- Hemograma Completo
('UR2', 12),   -- Hemograma Completo con Recuento Diferencial
('UR2', 25),   -- Prueba de Creatinina en Suero
('UR2', 26),   -- Prueba de Urea en Sangre
('UR2', 27),   -- Microalbuminuria
('UR2', 34),   -- Velocidad de Sedimentación Globular (VSG)
('UR2', 38),   -- Prueba de Antígeno Prostático Específico (PSA)
('UR2', 47),   -- Prueba de Electrolitos (Na, K, Cl)
('UR2', 60),   -- Tomografía Computarizada (TAC)
('UR2', 61),   -- Resonancia Magnética (RM)
('UR2', 67),   -- Rayos X de Pelvis
('UR2', 68);   -- Rayos X de Cadera

-- ahora los que puede realizar un traumatólogo
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('TR2', 1),   -- Hemograma Completo
('TR2', 12),  -- Hemograma Completo con Recuento Diferencial
('TR2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('TR2', 36),  -- Electromiografía (EMG)
('TR2', 44),  -- Test de Lactato en Sangre
('TR2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('TR2', 60),  -- Tomografía Computarizada (TAC)
('TR2', 61),  -- Resonancia Magnética (RM)
('TR2', 64),  -- Rayos X de Columna Cervical
('TR2', 65),  -- Rayos X de Columna Torácica
('TR2', 66),  -- Rayos X de Columna Lumbar
('TR2', 67),  -- Rayos X de Pelvis
('TR2', 68),  -- Rayos X de Cadera
('TR2', 69),  -- Rayos X de Rodilla
('TR2', 70),  -- Rayos X de Tobillo
('TR2', 71),  -- Rayos X de Pie
('TR2', 72),  -- Rayos X de Mano
('TR2', 73),  -- Rayos X de Muñeca
('TR2', 74),  -- Rayos X de Codo
('TR2', 75);  -- Rayos X de Hombro

-- ahora los que puede realizar un fisioterapia, dermatólogo, psiquiatra, nutriologo, odontologo y  medico de emergencia
-- Ahora, los exámenes que pueden solicitar un fisioterapeuta, dermatólogo, psiquiatra, nutriólogo, odontólogo y médico de emergencias.

-- Fisioterapeuta
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('RH2', 35),  -- Espirometría Forzada
('RH2', 36),  -- Electromiografía (EMG)
('RH2', 44),  -- Test de Lactato en Sangre
('RH2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('RH2', 69),  -- Rayos X de Rodilla
('RH2', 70),  -- Rayos X de Tobillo
('RH2', 71),  -- Rayos X de Pie
('RH2', 75);  -- Rayos X de Hombro

-- Dermatólogo
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('DR2', 1),   -- Hemograma Completo
('DR2', 12),  -- Hemograma Completo con Recuento Diferencial
('DR2', 17),  -- Proteína C Reactiva (PCR)
('DR2', 28),  -- Prueba de Bilirrubina (Directa e Indirecta)
('DR2', 29),  -- Fosfatasa Alcalina (ALP)
('DR2', 30),  -- Alanina Aminotransferasa (ALT)
('DR2', 31),  -- Aspartato Aminotransferasa (AST)
('DR2', 33),  -- Prueba de ANA (Anticuerpos Antinucleares)
('DR2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('DR2', 40),  -- Prueba de Ferritina
('DR2', 47);  -- Prueba de Electrolitos (Na, K, Cl)

-- Psiquiatra
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('PS2', 1),   -- Hemograma Completo
('PS2', 12),  -- Hemograma Completo con Recuento Diferencial
('PS2', 25),  -- Prueba de Creatinina en Suero
('PS2', 26),  -- Prueba de Urea en Sangre
('PS2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('PS2', 37),  -- Electroencefalograma (EEG)
('PS2', 41),  -- Prueba de Hemoglobina Glicosilada (HbA1c)
('PS2', 43),  -- Prueba de Fibrinógeno
('PS2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('PS2', 49),  -- Prueba de Cortisol en Suero
('PS2', 50);  -- Prueba de Aldosterona

-- Nutriólogo
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('NT2', 1),   -- Hemograma Completo
('NT2', 2),   -- Prueba de Glucosa en Ayunas
('NT2', 3),   -- Perfil Lipídico
('NT2', 12),  -- Hemograma Completo con Recuento Diferencial
('NT2', 13),  -- Curva de Tolerancia a la Glucosa
('NT2', 14),  -- Lipoproteínas de Alta Densidad (HDL)
('NT2', 15),  -- Lipoproteínas de Baja Densidad (LDL)
('NT2', 16),  -- Triglicéridos
('NT2', 17),  -- Proteína C Reactiva (PCR)
('NT2', 25),  -- Prueba de Creatinina en Suero
('NT2', 26),  -- Prueba de Urea en Sangre
('NT2', 27),  -- Microalbuminuria
('NT2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('NT2', 39),  -- Prueba de Vitamina D
('NT2', 40),  -- Prueba de Ferritina
('NT2', 41),  -- Prueba de Hemoglobina Glicosilada (HbA1c)
('NT2', 47);  -- Prueba de Electrolitos (Na, K, Cl)

-- Odontólogo
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('OD2', 1),   -- Hemograma Completo
('OD2', 12),  -- Hemograma Completo con Recuento Diferencial
('OD2', 17),  -- Proteína C Reactiva (PCR)
('OD2', 28),  -- Prueba de Bilirrubina (Directa e Indirecta)
('OD2', 31),  -- Aspartato Aminotransferasa (AST)
('OD2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('OD2', 40),  -- Prueba de Ferritina
('OD2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('OD2', 72),  -- Rayos X de Mano
('OD2', 73),  -- Rayos X de Muñeca
('OD2', 74);  -- Rayos X de Codo

-- Médico de Emergencias
INSERT INTO medicos_examenes (id_medico, id_examen) VALUES
('EM2', 1),   -- Hemograma Completo
('EM2', 2),   -- Prueba de Glucosa en Ayunas
('EM2', 3),   -- Perfil Lipídico
('EM2', 4),   -- Monitorización Ambulatoria de la Presión Arterial
('EM2', 7),   -- Electrocardiograma (ECG)
('EM2', 9),   -- Prueba de Función Hepática
('EM2', 10),  -- Prueba de Función Renal
('EM2', 12),  -- Hemograma Completo con Recuento Diferencial
('EM2', 13),  -- Curva de Tolerancia a la Glucosa
('EM2', 14),  -- Lipoproteínas de Alta Densidad (HDL)
('EM2', 15),  -- Lipoproteínas de Baja Densidad (LDL)
('EM2', 16),  -- Triglicéridos
('EM2', 17),  -- Proteína C Reactiva (PCR)
('EM2', 18),  -- Troponina
('EM2', 19),  -- Prueba de Dímero-D
('EM2', 20),  -- Ecocardiograma Doppler
('EM2', 21),  -- Prueba de Esfuerzo Cardiovascular
('EM2', 22),  -- Gasometría Arterial
('EM2', 25),  -- Prueba de Creatinina en Suero
('EM2', 26),  -- Prueba de Urea en Sangre
('EM2', 27),  -- Microalbuminuria
('EM2', 34),  -- Velocidad de Sedimentación Globular (VSG)
('EM2', 41),  -- Prueba de Hemoglobina Glicosilada (HbA1c)
('EM2', 43),  -- Prueba de Fibrinógeno
('EM2', 44),  -- Test de Lactato en Sangre
('EM2', 47),  -- Prueba de Electrolitos (Na, K, Cl)
('EM2', 55),  -- Rayos X de Tórax
('EM2', 56),  -- Rayos X de Abdomen
('EM2', 57),  -- Rayos X de Columna
('EM2', 58),  -- Rayos X de Extremidades
('EM2', 60),  -- Tomografía Computarizada (TAC)
('EM2', 61);  -- Resonancia Magnética (RM)



CREATE TABLE seguros (
    id_seguro INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);
INSERT INTO seguros (nombre) VALUES
('BlueCross BlueShield of Panama'),
('ASSA Compañía de Seguros'),
('Mapfre Panamá'),
('Internacional de Seguros (IS)'),
('Pan-American Life Insurance Group (PALIG)'),
('Generali Panamá');


CREATE TABLE pacientes(
    id_paciente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    cedula VARCHAR(25) UNIQUE NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    sexo ENUM('M', 'F') NOT NULL,
    correo VARCHAR(100) not null,
    telefono VARCHAR(20) NOT NULL,
    direccion VARCHAR(200) NOT NULL,
    numero_seguro VARCHAR(50),
    id_seguro INT,
    observaciones TEXT
);

-- CREATE TABLE atenciones (
--     id_atencion INT PRIMARY KEY AUTO_INCREMENT,
--     id_paciente INT NOT NULL,
--     fecha_ingreso DATETIME DEFAULT CURRENT_TIMESTAMP,
--     fecha_alta DATETIME,
--     estado ENUM('En Atención', 'Alta') DEFAULT 'En Atención',
--     CONSTRAINT fk_atencion_paciente FOREIGN KEY (id_paciente)
--         REFERENCES pacientes(id_paciente)
--         ON DELETE RESTRICT
--         ON UPDATE CASCADE
-- );

-- Modificar la tabla expedientes_pacientes para relacionarla con atenciones
CREATE TABLE expedientes_pacientes (
    id_expediente INT PRIMARY KEY AUTO_INCREMENT,
    paciente INT NOT NULL,
    causaIngreso VARCHAR(200) NOT NULL,
    fecha_ingreso DATETIME DEFAULT CURRENT_TIMESTAMP,
    doctor INT,
    tratamiento TEXT,
    medicamentos TEXT,
    diagnostico TEXT,
    fecha_alta DATETIME,
    departamento INT NOT NULL,
    estado ENUM('Espera','En Atencion', 'Alta') DEFAULT 'Espera',
    CONSTRAINT fk_expediente_paciente FOREIGN KEY (paciente)
        REFERENCES pacientes(id_paciente)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_expediente_doctor FOREIGN KEY (doctor)
        REFERENCES empleado(id_empleado)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
        CONSTRAINT fk_expediente_departamento FOREIGN KEY (departamento)
        REFERENCES departamento(id_departamento)
);


DELIMITER $$

CREATE PROCEDURE registrarIngresoPaciente (
    IN p_departamento INT,
    IN p_id_paciente INT,
    IN p_causa_ingreso VARCHAR(200)
)
BEGIN
    DECLARE v_existe_paciente INT;

    -- Verificar si el paciente existe
    SELECT COUNT(*) INTO v_existe_paciente
    FROM pacientes
    WHERE id_paciente = p_id_paciente;

    IF v_existe_paciente > 0 THEN
        -- Verificar si el paciente ya está siendo atendido
        IF EXISTS (
            SELECT 1 FROM expedientes_pacientes
            WHERE paciente = p_id_paciente
            AND estado IN ('Espera', 'En Atencion')
        ) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El paciente ya está siendo atendido.';
        ELSE
            INSERT INTO expedientes_pacientes (paciente, causaIngreso, departamento)
            VALUES (p_id_paciente, p_causa_ingreso, p_departamento);
        END IF;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El paciente no existe.';
    END IF;
END $$

DELIMITER ;



DELIMITER $$

CREATE PROCEDURE asignarDoctor (
    IN p_id_doctor INT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255),
    OUT p_datos_paciente TEXT
)
BEGIN
    DECLARE v_existe_doctor INT;
    DECLARE v_id_expediente INT;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- En caso de error, revertir la transacción y establecer código de error
        ROLLBACK;
        SET p_codigo_estado = -1;
        SET p_mensaje = 'Error en la asignación del doctor.';
    END;

    START TRANSACTION;

    -- Inicializar el mensaje y el código de estado
    SET p_codigo_estado = 0;
    SET p_mensaje = '';
    SET p_datos_paciente = '';

    -- Verificar si el doctor existe
    SELECT COUNT(*) INTO v_existe_doctor
    FROM empleado
    WHERE id_empleado = p_id_doctor;

    IF v_existe_doctor > 0 THEN
        -- Buscar un paciente ingresado sin doctor asignado
        SELECT expedientes_pacientes.id_expediente, CONCAT(pacientes.nombre, ' ', pacientes.apellido, ' (Cédula: ', pacientes.cedula, ')') AS datos_paciente
        INTO v_id_expediente, p_datos_paciente
        FROM expedientes_pacientes
        JOIN pacientes ON expedientes_pacientes.paciente = pacientes.id_paciente
        WHERE expedientes_pacientes.estado = 'Espera' AND expedientes_pacientes.doctor IS NULL
        LIMIT 1;

        IF v_id_expediente IS NOT NULL THEN
            -- Asignar el doctor al expediente
            UPDATE expedientes_pacientes
            SET doctor = p_id_doctor, estado = 'En Atencion'
            WHERE id_expediente = v_id_expediente;

            -- Confirmar transacción
            COMMIT;

            SET p_codigo_estado = 1;
            SET p_mensaje = 'Doctor asignado correctamente al paciente.';
        ELSE
            -- No hay pacientes por atender
            ROLLBACK;
            SET p_codigo_estado = 2;
            SET p_mensaje = 'No hay pacientes por atender.';
        END IF;
    ELSE
        -- El doctor no existe
        ROLLBACK;
        SET p_codigo_estado = 3;
        SET p_mensaje = 'El doctor no existe.';
    END IF;
END $$

DELIMITER ;




-- Tabla para registrar los exámenes realizados al paciente durante la atención
CREATE TABLE expedientes_examenes (
    id_examen_paciente INT PRIMARY KEY AUTO_INCREMENT,
    fecha_examen DATE,
    id_expediente INT NOT NULL,
    examen INT NOT NULL,
    resultados TEXT,
    estado ENUM('Espera', 'Sin Resultado', 'Con Resultado') DEFAULT 'Espera',
    CONSTRAINT fk_expediente_examenes_expediente FOREIGN KEY (id_expediente)
        REFERENCES expedientes_pacientes(id_expediente)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_expediente_examenes_examen FOREIGN KEY (examen)
        REFERENCES examenes(id_examen)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

DELIMITER $$

CREATE PROCEDURE indicarExamenRealizado(
    IN p_id_examen_paciente INT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE v_estado_actual ENUM('Espera', 'Sin Resultado', 'Con Resultado');

    -- Manejo de excepciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_codigo_estado = -1;
        SET p_mensaje = 'Error al actualizar el estado del examen.';
    END;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Obtener el estado actual del examen
    SELECT estado INTO v_estado_actual
    FROM expedientes_examenes
    WHERE id_examen_paciente = p_id_examen_paciente;

    -- Verificar si el estado actual es 'Espera'
    IF v_estado_actual = 'Espera' THEN
        -- Actualizar el estado a 'Sin Resultado'
        UPDATE expedientes_examenes
        SET estado = 'Sin Resultado'
        WHERE id_examen_paciente = p_id_examen_paciente;

        -- Confirmar la transacción
        COMMIT;

        SET p_codigo_estado = 1;
        SET p_mensaje = 'Estado del examen actualizado a Sin Resultado.';
    ELSE
        -- No se puede actualizar el estado
        ROLLBACK;
        SET p_codigo_estado = 2;
        SET p_mensaje = 'El estado del examen no es Espera.';
    END IF;
END $$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE indicarResultadosListos(
    IN p_id_examen_paciente INT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE v_estado_actual ENUM('Espera', 'Sin Resultado', 'Con Resultado');

    -- Manejo de excepciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_codigo_estado = -1;
        SET p_mensaje = 'Error al actualizar el estado del examen.';
    END;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Obtener el estado actual del examen
    SELECT estado INTO v_estado_actual
    FROM expedientes_examenes
    WHERE id_examen_paciente = p_id_examen_paciente;

    -- Verificar si el estado actual es 'Espera'
    IF v_estado_actual = 'Sin Resultado' THEN
        -- Actualizar el estado a 'Sin Resultado'
        UPDATE expedientes_examenes
        SET estado = 'Con Resultado'
        WHERE id_examen_paciente = p_id_examen_paciente;

        -- Confirmar la transacción
        COMMIT;

        SET p_codigo_estado = 1;
        SET p_mensaje = 'Resultado del examen correctamente indicado.';
    ELSE
        -- No se puede actualizar el estado
        ROLLBACK;
        SET p_codigo_estado = 2;
        SET p_mensaje = 'El estado del examen no es el estado Esperado.';
    END IF;
END $$

DELIMITER ;



DELIMITER $$

CREATE PROCEDURE asignarExamen(
    IN p_id_doctor INT,
    IN p_cedula_paciente INT,
    IN p_examen INT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE v_existe_doctor INT;
    DECLARE v_existe_paciente INT;
    DECLARE v_id_expediente INT;
    -- Manejo de excepciones
        DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    DECLARE msg TEXT;
    DECLARE code INT;
    
    -- Obtener el mensaje de error y el código de error
    GET DIAGNOSTICS CONDITION 1
        code = MYSQL_ERRNO, 
        msg = MESSAGE_TEXT;
    
    -- Realizar el rollback
    ROLLBACK;
    
    -- Establecer los valores de salida
    SET p_codigo_estado = -1;
    SET p_mensaje = CONCAT('Error al recetar medicamentos al paciente: ', msg);
END;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Inicializar el mensaje y el código de estado
    SET p_codigo_estado = 0;
    SET p_mensaje = '';

    -- Verificar si el doctor existe
    SELECT COUNT(*) INTO v_existe_doctor
    FROM empleado
    WHERE id_empleado = p_id_doctor;

    IF v_existe_doctor > 0 THEN
        -- Verificar si el paciente existe y está en atención con este doctor
    
        SELECT COUNT(*), expedientes_pacientes.id_expediente INTO v_existe_paciente, v_id_expediente
        FROM expedientes_pacientes
        JOIN pacientes as p ON expedientes_pacientes.paciente = p.id_paciente
        WHERE p.cedula = p_cedula_paciente
          AND estado = 'En Atencion' 
          AND doctor = p_id_doctor;
        IF v_existe_paciente > 0 THEN
            INSERT INTO expedientes_examenes (id_expediente, examen, estado)
            VALUES (v_id_expediente, p_examen, 'Espera');
            -- Confirmar la transacción
            COMMIT;

            SET p_codigo_estado = 1;
            SET p_mensaje = 'examen correctamente.';
        ELSE
            -- El paciente no está en atención o el doctor no lo está atendiendo
            ROLLBACK;
            SET p_codigo_estado = 2;
            SET p_mensaje = 'El paciente no está en atención o no está siendo atendido por este doctor.';
        END IF;
    ELSE
        -- El doctor no existe
        ROLLBACK;
        SET p_codigo_estado = 3;
        SET p_mensaje = 'El doctor no existe.';
    END IF;

END $$

DELIMITER ;


-- Tabla para generar facturas al dar de alta al paciente
CREATE TABLE facturas (
    id_factura INT PRIMARY KEY AUTO_INCREMENT,
    id_atencion INT NOT NULL,
    fecha_factura DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_factura_atencion FOREIGN KEY (id_atencion)
        REFERENCES atenciones(id_atencion)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);


DELIMITER //

CREATE PROCEDURE GenerarFactura(
    IN p_id_atencion INT,
    IN p_fecha_alta DATETIME
)
BEGIN
    DECLARE v_total DECIMAL(10,2);
    DECLARE v_cargo_adicional DECIMAL(10,2) DEFAULT 0;
    DECLARE v_id_rol VARCHAR(10);
    
    -- Iniciar una transacción
    START TRANSACTION;
    
    -- Actualizar la atención del paciente
    UPDATE atenciones
    SET fecha_alta = p_fecha_alta,
        estado = 'Alta'
    WHERE id_atencion = p_id_atencion;
    
    -- Obtener el rol del médico que atendió al paciente
    SELECT e.id_rol INTO v_id_rol
    FROM atenciones a
    JOIN empleados e ON a.id_doctor = e.id_empleado
    WHERE a.id_atencion = p_id_atencion;
    
    -- Verificar si el rol del médico está en la lista específica
    IF v_id_rol IN ('CG2', 'CD2', 'NR2', 'GN2', 'PD2', 'OR2', 'UR2', 'TR2') THEN
        SET v_cargo_adicional = 140;
    END IF;
    
    -- Calcular el total de la factura
    SELECT 
        IFNULL(SUM(e.costo_examen), 0) + 30 + v_cargo_adicional INTO v_total
    FROM expedientes_examenes ee
    JOIN examenes e ON e.examen = e.id_examen
    WHERE ee.expediente = (
        SELECT id_expediente
        FROM expedientes_pacientes
        WHERE id_atencion = p_id_atencion
    );
    
    -- Insertar la factura en la tabla `facturas`
    INSERT INTO facturas (id_atencion, fecha_factura, total)
    VALUES (p_id_atencion, NOW(), v_total);
    
    -- Confirmar la transacción
    COMMIT;
END //

DELIMITER ;







DELIMITER $$

CREATE PROCEDURE TraspasarAtencion(
    IN p_id_doctor INT,
    IN p_departamento INT,
    IN p_cedula_paciente INT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    -- Declaraciones de variables deben estar al inicio
    DECLARE v_existe_doctor INT;
    DECLARE v_existe_paciente INT;
    DECLARE v_id_expediente INT;


    -- Manejo de excepciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    DECLARE msg TEXT;
    DECLARE code INT;
    
    -- Obtener el mensaje de error y el código de error
    GET DIAGNOSTICS CONDITION 1
        code = MYSQL_ERRNO, 
        msg = MESSAGE_TEXT;
    
    -- Realizar el rollback
    ROLLBACK;
    
    -- Establecer los valores de salida
    SET p_codigo_estado = -1;
    SET p_mensaje = CONCAT('Error al recetar medicamentos al paciente: ', msg);
END;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Inicializar el mensaje y el código de estado
    SET p_codigo_estado = 0;
    SET p_mensaje = '';

    -- Verificar si el doctor existe
    SELECT COUNT(*) INTO v_existe_doctor
    FROM empleado
    WHERE id_empleado = p_id_doctor;

    IF v_existe_doctor > 0 THEN
        -- Verificar si el paciente existe y está en atención con este doctor
        SELECT COUNT(*), expedientes_pacientes.id_expediente INTO v_existe_paciente, v_id_expediente
        FROM expedientes_pacientes
        JOIN pacientes as p ON expedientes_pacientes.paciente = p.id_paciente
        WHERE p.cedula = p_cedula_paciente
          AND estado = 'En Atencion' 
          AND doctor = p_id_doctor;

        IF v_existe_paciente > 0 THEN
            -- Actualizar el departamento y el estado del paciente
            UPDATE expedientes_pacientes
            SET departamento = p_departamento, estado = 'Espera', doctor = NULL
            WHERE id_expediente = v_id_expediente;

            -- Confirmar la transacción
            COMMIT;

            SET p_codigo_estado = 1;
            SET p_mensaje = 'Atención traspasada correctamente.';
        ELSE
            -- El paciente no está en atención o el doctor no lo está atendiendo
            ROLLBACK;
            SET p_codigo_estado = 2;
            SET p_mensaje = 'El paciente no está en atención o no está siendo atendido por este doctor.';
        END IF;
    ELSE
        -- El doctor no existe
        ROLLBACK;
        SET p_codigo_estado = 3;
        SET p_mensaje = 'El doctor no existe.';
    END IF;

END $$
DELIMITER ;





DELIMITER $$

CREATE PROCEDURE darAltaPaciente(
    IN p_id_doctor INT,
    IN p_cedula_paciente INT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE v_existe_doctor INT;
    DECLARE v_existe_paciente INT;
    DECLARE v_id_expediente INT;


    -- Manejo de excepciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_codigo_estado = -1;
        SET p_mensaje = 'Error al dar de alta al paciente.';
    END;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Inicializar el mensaje y el código de estado
    SET p_codigo_estado = 0;
    SET p_mensaje = '';

    -- Verificar si el doctor existe
    SELECT COUNT(*) INTO v_existe_doctor
    FROM empleado
    WHERE id_empleado = p_id_doctor;

    IF v_existe_doctor > 0 THEN
        -- Verificar si el paciente existe y está en atención con este doctor
        SELECT COUNT(*), expedientes_pacientes.id_expediente INTO v_existe_paciente, v_id_expediente
        FROM expedientes_pacientes
        JOIN pacientes as p ON expedientes_pacientes.paciente = p.id_paciente
        WHERE p.cedula = p_cedula_paciente
          AND estado = 'En Atencion' 
          AND doctor = p_id_doctor;

        IF v_existe_paciente > 0 THEN
            -- Actualizar el departamento y el estado del paciente
            UPDATE expedientes_pacientes
            SET estado = 'Alta', fecha_alta = NOW()
            WHERE id_expediente = v_id_expediente;
            -- Confirmar la transacción
            COMMIT;

            SET p_codigo_estado = 1;
            SET p_mensaje = 'Paciente dado de alta correctamente.';
        ELSE
            -- El paciente no está en atención o el doctor no lo está atendiendo
            ROLLBACK;
            SET p_codigo_estado = 2;
            SET p_mensaje = 'El paciente no está en atención o no está siendo atendido por este doctor.';
        END IF;
    ELSE
        -- El doctor no existe
        ROLLBACK;
        SET p_codigo_estado = 3;
        SET p_mensaje = 'El doctor no existe.';
    END IF;

END $$

DELIMITER ;




DELIMITER $$

CREATE PROCEDURE actualizarMedicamentos(
    IN p_id_doctor INT,
    IN p_cedula_paciente INT,
    IN p_medicamentos TEXT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE v_existe_doctor INT;
    DECLARE v_existe_paciente INT;
    DECLARE v_id_paciente INT;
    DECLARE v_id_expediente INT;


    -- Manejo de excepciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    DECLARE msg TEXT;
    DECLARE code INT;
    
    -- Obtener el mensaje de error y el código de error
    GET DIAGNOSTICS CONDITION 1
        code = MYSQL_ERRNO, 
        msg = MESSAGE_TEXT;
    
    -- Realizar el rollback
    ROLLBACK;
    
    -- Establecer los valores de salida
    SET p_codigo_estado = -1;
    SET p_mensaje = CONCAT('Error al recetar medicamentos al paciente: ', msg);
END;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Inicializar el mensaje y el código de estado
    SET p_codigo_estado = 0;
    SET p_mensaje = '';

    -- Verificar si el doctor existe
    SELECT COUNT(*) INTO v_existe_doctor
    FROM empleado
    WHERE id_empleado = p_id_doctor;

    IF v_existe_doctor > 0 THEN
        -- Verificar si el paciente existe y está en atención con este doctor
        SELECT COUNT(*), p.id_paciente, expedientes_pacientes.id_expediente INTO v_existe_paciente, v_id_paciente, v_id_expediente
        FROM expedientes_pacientes
        JOIN pacientes as p ON expedientes_pacientes.paciente = p.id_paciente
        WHERE p.cedula = p_cedula_paciente
          AND estado = 'En Atencion' 
          AND doctor = p_id_doctor;

        IF v_existe_paciente > 0 THEN
            UPDATE expedientes_pacientes
            SET medicamentos = p_medicamentos
            WHERE id_expediente = v_id_expediente;
            -- Confirmar la transacción
            COMMIT;

            SET p_codigo_estado = 1;
            SET p_mensaje = 'medicamentos recetados correctamente.';
        ELSE
            -- El paciente no está en atención o el doctor no lo está atendiendo
            ROLLBACK;
            SET p_codigo_estado = 2;
            SET p_mensaje = 'El paciente no está en atención o no está siendo atendido por este doctor.';
        END IF;
    ELSE
        -- El doctor no existe
        ROLLBACK;
        SET p_codigo_estado = 3;
        SET p_mensaje = 'El doctor no existe.';
    END IF;

END $$

DELIMITER ;





DELIMITER $$

CREATE PROCEDURE actualizarTratamiento(
    IN p_id_doctor INT,
    IN p_cedula_paciente INT,
    IN p_tratamieto TEXT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE v_existe_doctor INT;
    DECLARE v_existe_paciente INT;
    DECLARE v_id_expediente INT;

    -- Manejo de excepciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_codigo_estado = -1;
        SET p_mensaje = 'Error al recetar tratamiento al paciente.';
    END;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Inicializar el mensaje y el código de estado
    SET p_codigo_estado = 0;
    SET p_mensaje = '';

    -- Verificar si el doctor existe
    SELECT COUNT(*) INTO v_existe_doctor
    FROM empleado
    WHERE id_empleado = p_id_doctor;

    IF v_existe_doctor > 0 THEN
        -- Verificar si el paciente existe y está en atención con este doctor
        SELECT COUNT(*), expedientes_pacientes.id_expediente INTO v_existe_paciente, v_id_expediente
        FROM expedientes_pacientes
        JOIN pacientes as p ON expedientes_pacientes.paciente = p.id_paciente
        WHERE p.cedula = p_cedula_paciente
          AND estado = 'En Atencion' 
          AND doctor = p_id_doctor;

        IF v_existe_paciente > 0 THEN
            UPDATE expedientes_pacientes
            SET tratamiento = p_tratamieto
            WHERE id_expediente = v_id_expediente;
            -- Confirmar la transacción
            COMMIT;

            SET p_codigo_estado = 1;
            SET p_mensaje = 'tratamiento recetados correctamente.';
        ELSE
            -- El paciente no está en atención o el doctor no lo está atendiendo
            ROLLBACK;
            SET p_codigo_estado = 2;
            SET p_mensaje = 'El paciente no está en atención o no está siendo atendido por este doctor.';
        END IF;
    ELSE
        -- El doctor no existe
        ROLLBACK;
        SET p_codigo_estado = 3;
        SET p_mensaje = 'El doctor no existe.';
    END IF;

END $$

DELIMITER ;










-- 🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲🎲





CREATE TABLE insumos (
    id_insumo INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    costo DECIMAL(10,2) NOT NULL
);

CREATE TABLE insumos_departamento (
    id_insumo INT NOT NULL,                        -- ID del insumo (relacionado con Insumos)
    id_departamento INT NOT NULL,           -- Cantidad del insumo en el departamento
    PRIMARY KEY (id_insumo, id_departamento),      -- Clave compuesta para evitar duplicados
    FOREIGN KEY (id_insumo) REFERENCES insumos(id_insumo),
    FOREIGN KEY (id_departamento) REFERENCES Departamento(id_departamento)
);









CREATE TABLE inventario_departamento (
    id_insumo INT NOT NULL,                        -- ID del insumo (relacionado con InventarioGeneral)
    id_departamento INT NOT NULL,                 -- ID del departamento (relacionado con Departamento)
    cantidad INT NOT NULL,                       -- Cantidad del insumo en el departamento
    PRIMARY KEY (id_insumo, id_departamento),      -- Clave compuesta para evitar duplicados
    FOREIGN KEY (id_insumo) REFERENCES insumos(id_insumo),
    FOREIGN KEY (id_departamento) REFERENCES Departamento(id_departamento)
);

CREATE TABLE peticiones_insumos (
    id_peticion INT PRIMARY KEY AUTO_INCREMENT,
    cantidad INT NOT NULL,
    insumo INT NOT NULL,
    id_departamento INT NOT NULL,
    fecha_peticion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Pendiente', 'Aprobada') DEFAULT 'Pendiente',
    CONSTRAINT fk_peticion_departamento FOREIGN KEY (id_departamento)
        REFERENCES departamento(id_departamento)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_peticion_insumo FOREIGN KEY (insumo)
        REFERENCES insumos(id_insumo)
);


DELIMITER $$

CREATE PROCEDURE pedirInsumo(
    IN p_Cantidad INT,
    IN p_id_insumo INT,
    IN p_departamento INT,
    OUT p_codigo_estado INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN

    -- Manejo de excepciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_codigo_estado = -1;
        SET p_mensaje = 'Error al pedir mas insumos.';
    END;

    INSERT INTO peticiones_insumos (cantidad, insumo, id_departamento)
        VALUES (p_Cantidad, p_id_insumo, p_departamento);

    COMMIT;

    SET p_codigo_estado = 1;
    SET p_mensaje = 'Insumo pedido correctamente.';


END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE transferirInsumo(
    IN p_id_insumo INT,              -- ID del insumo a transferir
    IN p_id_departamento INT,        -- ID del departamento receptor
    IN p_cantidad INT,               -- Cantidad a transferir
    IN p_id_peticion INT,            -- ID de la petición de insumo
    OUT p_codigo_estado INT,         -- Código de estado de la operación
    OUT p_mensaje VARCHAR(255)       -- Mensaje descriptivo del resultado
)
BEGIN
    DECLARE v_cantidad_actual INT;
    DECLARE v_cantidad_departamento INT;

    -- Manejo de excepciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_codigo_estado = -1;
        SET p_mensaje = 'Error al transferir el insumo.';
    END;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Obtener la cantidad actual en el inventario general (id_departamento = 0)
    SELECT cantidad INTO v_cantidad_actual
    FROM inventario_departamento
    WHERE id_insumo = p_id_insumo AND id_departamento = 0;

    -- Verificar si hay suficiente cantidad en el inventario general
    IF v_cantidad_actual >= p_cantidad THEN
        -- Verificar si el insumo ya existe en el inventario del departamento
        SELECT cantidad INTO v_cantidad_departamento
        FROM inventario_departamento
        WHERE id_insumo = p_id_insumo AND id_departamento = p_id_departamento;

        IF v_cantidad_departamento IS NOT NULL THEN
            -- Actualizar la cantidad existente en el departamento
            UPDATE inventario_departamento
            SET cantidad = cantidad + p_cantidad
            WHERE id_insumo = p_id_insumo AND id_departamento = p_id_departamento;
        ELSE
            -- Insertar el insumo en el inventario del departamento
            INSERT INTO inventario_departamento (id_insumo, id_departamento, cantidad)
            VALUES (p_id_insumo, p_id_departamento, p_cantidad);
        END IF;

        -- Actualizar la cantidad en el inventario general
        UPDATE inventario_departamento
        SET cantidad = cantidad - p_cantidad
        WHERE id_insumo = p_id_insumo AND id_departamento = 0;

        -- Actualizar el estado de la petición de insumo a "Aprobada"
        UPDATE peticiones_insumos
        SET estado = 'Aprobada'
        WHERE id_peticion = p_id_peticion;

        -- Confirmar la transacción
        COMMIT;

        SET p_codigo_estado = 1;
        SET p_mensaje = 'Insumo transferido correctamente.';
    ELSE
        -- No hay suficiente cantidad en el inventario general
        ROLLBACK;
        SET p_codigo_estado = 2;
        SET p_mensaje = 'Cantidad insuficiente en el inventario general.';
    END IF;
END $$

DELIMITER ;


INSERT INTO insumos (id_insumo, nombre, descripcion, costo) VALUES
(1, 'Guantes quirúrgicos', 'Guantes estériles para procedimientos quirúrgicos', 5.00),
(2, 'Mascarillas N95', 'Mascarillas de alta filtración para protección respiratoria', 15.00),
(3, 'Jeringas 5ml', 'Jeringas reutilizables de 5 ml para inyecciones', 0.50),
(4, 'Alcohol 70%', 'Solución desinfectante al 70% para limpieza de superficies', 8.00),
(5, 'Batas quirúrgicas', 'Batas estériles para uso durante cirugías', 25.00),
(6, 'Gasas estériles', 'Gasas desechables para cobertura y limpieza de heridas', 2.00),
(7, 'Termómetros digitales', 'Termómetros electrónicos para la medición de la temperatura corporal', 45.00),
(8, 'Cintas adhesivas médicas', 'Cintas resistentes para fijación de gasas y vendajes', 3.00),
(9, 'Vendas elásticas', 'Vendas elásticas para soporte y compresión de extremidades', 4.50),
(10, 'Estetoscopios', 'Instrumento médico para auscultación de sonidos corporales', 60.00),
(11, 'Cubrebocas quirúrgicos', 'Mascarillas desechables para protección durante procedimientos', 3.50),
(12, 'Cajas de guantes estériles', 'Cajas que contienen guantes estériles para uso médico', 50.00),
(13, 'Desinfectante hospitalario', 'Solución desinfectante de amplio espectro para ambientes hospitalarios', 20.00),
(14, 'Monitores de signos vitales', 'Dispositivos electrónicos para monitoreo continuo de signos vitales', 500.00),
(15, 'Luces quirúrgicas', 'Iluminación especializada para salas de cirugía', 300.00),
(16, 'Cánulas de traqueostomía', 'Cánulas utilizadas en procedimientos de traqueostomía', 25.00),
(17, 'Cubrecalzado desechable', 'Cubrezapatos desechables para uso en áreas estériles', 1.50),
(18, 'Gorros quirúrgicos', 'Gorros desechables para mantener la higiene durante cirugías', 2.00),
(19, 'Batas para visitantes', 'Batas desechables para uso de visitantes en áreas sanitarias', 3.00),
(20, 'Extintores de CO2', 'Extintores portátiles de dióxido de carbono para emergencias', 150.00),
(21, 'Toallas desinfectantes', 'Toallas impregnadas con desinfectante para limpieza de superficies', 10.00),
(22, 'Papel higiénico industrial', 'Papel higiénico de alto rendimiento para instalaciones médicas', 12.00);




INSERT INTO insumos_departamento (id_insumo, id_departamento) VALUES
-- Guantes quirúrgicos (ID Insumo: 1)
(1, 4),  -- Medicina General
(1, 5),  -- Laboratorios
(1, 6),  -- Cirugía
(1, 7),  -- Enfermería

-- Mascarillas N95 (ID Insumo: 2)
(2, 4),  -- Medicina General
(2, 5),  -- Laboratorios
(2, 6),  -- Cirugía
(2, 7),  -- Enfermería
(2, 8),  -- Cardiología

-- Jeringas 5ml (ID Insumo: 3)
(3, 4),  -- Medicina General
(3, 7),  -- Enfermería
(3, 9),  -- Neurología
(3, 11), -- Pediatría

-- Alcohol 70% (ID Insumo: 4)
(4, 3),  -- Inventario
(4, 4),  -- Medicina General
(4, 5),  -- Laboratorios
(4, 6),  -- Cirugía
(4, 7),  -- Enfermería

-- Batas quirúrgicas (ID Insumo: 5)
(5, 6),  -- Cirugía
(5, 7),  -- Enfermería

-- Gasas estériles (ID Insumo: 6)
(6, 4),  -- Medicina General
(6, 6),  -- Cirugía
(6, 7),  -- Enfermería

-- Termómetros digitales (ID Insumo: 7)
(7, 4),  -- Medicina General
(7, 10), -- Ginecología
(7, 11), -- Pediatría

-- Cintas adhesivas médicas (ID Insumo: 8)
(8, 6),  -- Cirugía
(8, 7),  -- Enfermería
(8, 13), -- Ortopedia

-- Vendas elásticas (ID Insumo: 9)
(9, 13), -- Ortopedia
(9, 15), -- Traumatología
(9, 19), -- Fisioterapia

-- Estetoscopios (ID Insumo: 10)
(10, 4),  -- Medicina General
(10, 8),  -- Cardiología
(10, 11), -- Pediatría

-- Cubrebocas quirúrgicos (ID Insumo: 11)
(11, 4),  -- Medicina General
(11, 5),  -- Laboratorios
(11, 6),  -- Cirugía
(11, 7),  -- Enfermería

-- Cajas de guantes estériles (ID Insumo: 12)
(12, 3),  -- Inventario
(12, 6),  -- Cirugía

-- Desinfectante hospitalario (ID Insumo: 13)
(13, 3),  -- Inventario
(13, 5),  -- Laboratorios
(13, 7),  -- Enfermería

-- Monitores de signos vitales (ID Insumo: 14)
(14, 8),  -- Cardiología
(14, 9),  -- Neurología
(14, 15), -- Traumatología

-- Luces quirúrgicas (ID Insumo: 15)
(15, 6),  -- Cirugía

-- Cánulas de traqueostomía (ID Insumo: 16)
(16, 8),  -- Cardiología
(16, 9),  -- Neurología

-- Cubrecalzado desechable (ID Insumo: 17)
(17, 5),  -- Laboratorios
(17, 6),  -- Cirugía

-- Gorros quirúrgicos (ID Insumo: 18)
(18, 6),  -- Cirugía
(18, 7),  -- Enfermería

-- Batas para visitantes (ID Insumo: 19)
(19, 4),  -- Medicina General
(19, 11), -- Pediatría
(19, 10), -- Ginecología

-- Extintores de CO2 (ID Insumo: 20)
(20, 3),  -- Inventario
(20, 5),  -- Laboratorios
(20, 6),  -- Cirugía
(20, 7),  -- Enfermería

-- Toallas desinfectantes (ID Insumo: 21)
(21, 3),  -- Inventario
(21, 4),  -- Medicina General
(21, 7),  -- Enfermería

-- Papel higiénico industrial (ID Insumo: 22)
(22, 3),  -- Inventario
(22, 4),  -- Medicina General
(22, 7);  -- Enfermería



INSERT INTO inventario_departamento (id_insumo, id_departamento, cantidad) VALUES
-- Guantes quirúrgicos (ID Insumo: 1)
(1, 3, 50),   -- Inventario
(1, 4, 15),   -- Medicina General
(1, 5, 10),   -- Laboratorios
(1, 6, 20),   -- Cirugía
(1, 7, 18),   -- Enfermería

-- Mascarillas N95 (ID Insumo: 2)
(2, 3, 40),   -- Inventario
(2, 4, 12),   -- Medicina General
(2, 5, 8),    -- Laboratorios
(2, 6, 15),   -- Cirugía
(2, 7, 14),   -- Enfermería
(2, 8, 10),   -- Cardiología

-- Jeringas 5ml (ID Insumo: 3)
(3, 3, 60),   -- Inventario
(3, 4, 30),   -- Medicina General
(3, 7, 25),   -- Enfermería
(3, 9, 20),   -- Neurología
(3, 11, 22),  -- Pediatría

-- Alcohol 70% (ID Insumo: 4)
(4, 3, 50),   -- Inventario
(4, 4, 20),   -- Medicina General
(4, 5, 12),   -- Laboratorios
(4, 6, 18),   -- Cirugía
(4, 7, 16),   -- Enfermería

-- Batas quirúrgicas (ID Insumo: 5)
(5, 3, 25),   -- Inventario
(5, 6, 10),   -- Cirugía
(5, 7, 8),    -- Enfermería

-- Gasas estériles (ID Insumo: 6)
(6, 3, 40),   -- Inventario
(6, 4, 18),   -- Medicina General
(6, 6, 15),   -- Cirugía
(6, 7, 16),   -- Enfermería

-- Termómetros digitales (ID Insumo: 7)
(7, 3, 10),   -- Inventario
(7, 4, 5),    -- Medicina General
(7, 10, 4),   -- Ginecología
(7, 11, 4),   -- Pediatría

-- Cintas adhesivas médicas (ID Insumo: 8)
(8, 3, 20),   -- Inventario
(8, 6, 8),    -- Cirugía
(8, 7, 10),   -- Enfermería
(8, 13, 7),   -- Ortopedia

-- Vendas elásticas (ID Insumo: 9)
(9, 3, 25),   -- Inventario
(9, 13, 12),  -- Ortopedia
(9, 15, 14),  -- Traumatología
(9, 19, 10),  -- Fisioterapia

-- Estetoscopios (ID Insumo: 10)
(10, 3, 8),   -- Inventario
(10, 4, 3),   -- Medicina General
(10, 8, 3),   -- Cardiología
(10, 11, 2),  -- Pediatría

-- Cubrebocas quirúrgicos (ID Insumo: 11)
(11, 3, 45),  -- Inventario
(11, 4, 18),  -- Medicina General
(11, 5, 12),  -- Laboratorios
(11, 6, 20),  -- Cirugía
(11, 7, 16),  -- Enfermería

-- Cajas de guantes estériles (ID Insumo: 12)
(12, 3, 35),  -- Inventario
(12, 6, 15),  -- Cirugía

-- Desinfectante hospitalario (ID Insumo: 13)
(13, 3, 28),  -- Inventario
(13, 5, 12),  -- Laboratorios
(13, 7, 20),  -- Enfermería

-- Monitores de signos vitales (ID Insumo: 14)
(14, 3, 4),   -- Inventario
(14, 8, 1),   -- Cardiología
(14, 9, 1),   -- Neurología
(14, 15, 1),  -- Traumatología

-- Luces quirúrgicas (ID Insumo: 15)
(15, 3, 2),   -- Inventario
(15, 6, 3),   -- Cirugía

-- Cánulas de traqueostomía (ID Insumo: 16)
(16, 3, 8),   -- Inventario
(16, 8, 3),   -- Cardiología
(16, 9, 2),   -- Neurología

-- Cubrecalzado desechable (ID Insumo: 17)
(17, 3, 50),  -- Inventario
(17, 5, 20),  -- Laboratorios
(17, 6, 25),  -- Cirugía

-- Gorros quirúrgicos (ID Insumo: 18)
(18, 3, 35),  -- Inventario
(18, 6, 15),  -- Cirugía
(18, 7, 12),  -- Enfermería

-- Batas para visitantes (ID Insumo: 19)
(19, 3, 25),  -- Inventario
(19, 4, 10),  -- Medicina General
(19, 11, 8),  -- Pediatría
(19, 10, 6),  -- Ginecología

-- Extintores de CO2 (ID Insumo: 20)
(20, 3, 5),   -- Inventario
(20, 5, 1),   -- Laboratorios
(20, 6, 2),   -- Cirugía
(20, 7, 2),   -- Enfermería

-- Toallas desinfectantes (ID Insumo: 21)
(21, 3, 40),  -- Inventario
(21, 4, 15),  -- Medicina General
(21, 7, 18),  -- Enfermería

-- Papel higiénico industrial (ID Insumo: 22)
(22, 3, 60),  -- Inventario
(22, 4, 25),  -- Medicina General
(22, 7, 30);  -- Enfermería