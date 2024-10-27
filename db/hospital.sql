-- SQLBook: Code
--Crea la base de datos
CREATE DATABASE Hospital

--Crear la tabla de los Usuarios
CREATE TABLE Usuarios (
  Num_Idoneidad Integer(10) Not Null,
  Nombre Varchar(15) Not Null,
  Apellido Varchar(15) Not Null,
 Fecha_Nacimiento DATE Not Null,
 Cedula Varchar(20) not Null Primary key,
 Genero Varchar(10) not null );

--Crear la tabla de los empleados
CREATE TABLE Empleados (
  Num_Identificacion Varchar(20) not null primary key,
 Nombre varchar(15) not null, Apellido varchar(15) not null, Cedula Varchar(20),
  Contraseña varchar(15) not null,Num_Servicio varchar(25), FOREIGN KEY (Cedula) REFERENCES usuarios(Cedula)) ;


--Crear la tabla de departamentos
CREATE TABLE Departamentos (Nombre varchar(15) not null, Id_Departamento varchar(3) not null primary key)

--Crear la tabla de rol
CREATE TABLE Rol (Nombre varchar(15) not null, Id_Rol varchar(3) not null primary key)

--Crear la tabla de servicios
CREATE TABLE Servicio (Num_Servicio varchar(25) not null primary key, Id_Departamento varchar(15) not null, Id_Rol varchar(15) not null, Num_Identificacion Varchar(20) not null,
FEntrada date, FSalida date, FOREIGN KEY (Id_Departamento) REFERENCES Departamentos(Id_Departamento), FOREIGN KEY
 (Id_Rol) REFERENCES Rol(Id_Rol), FOREIGN KEY (Num_Identificacion) REFERENCES empleados(Num_Identificacion));


--Alterar la tabla de empleados para añadir el num de servicio
ALTER TABLE empleados
ADD CONSTRAINT fk_num_servicio
FOREIGN KEY (Num_servicio) REFERENCES Servicio(Num_servicio)
ON DELETE CASCADE
ON UPDATE CASCADE;

