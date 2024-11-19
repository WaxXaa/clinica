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

