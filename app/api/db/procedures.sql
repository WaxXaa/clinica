DELIMITER $$

CREATE PROCEDURE crear_usuario_y_empleado(
    IN p_username VARCHAR(50),
    IN p_contra VARCHAR(255),
    IN p_nombre_empleado VARCHAR(100),
    IN p_departamento INT,
    IN p_rol INT
)
BEGIN
    DECLARE v_id_usuario INT;

    INSERT INTO usuario (username, contra)
    VALUES (p_username, p_contra);

    SET v_id_usuario = LAST_INSERT_ID();

    INSERT INTO empleado (nombre, departamento, usuario, rol)
    VALUES (p_nombre_empleado, p_departamento, v_id_usuario, p_rol);
END$$

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
        ROLLBACK;
        SET p_codigo_estado = -1;
        SET p_mensaje = 'Error al asignar examen al paciente.';
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
        SELECT COUNT(*), id_expediente INTO v_existe_paciente, v_id_expediente
        FROM expedientes_pacientes
        WHERE paciente = p_cedula_paciente 
          AND estado = 'En Atencion' 
          AND doctor = p_id_doctor;

        IF v_existe_paciente > 0 THEN
            INSERT INTO expedientes_examenes (fecha, expediente, examen, estado)
            VALUES (NOW(), v_id_expediente, p_examen, 'Espera');
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